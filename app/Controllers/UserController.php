<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\LikeModel;

class UserController extends BaseController
{
    // ======================
    // LIST USER + POST
    // ======================
    public function index()
    {
        $userModel = new UserModel();
        $postModel = new PostModel();

        $users = $userModel->findAll();
        $posts = $postModel
            ->select('Post.*, User.Username')
            ->join('User', 'User.UserID = Post.UserID', 'left')
            ->findAll();

        return view('users/index', [
            'users' => $users,
            'posts' => $posts
        ]);
    }

    // ======================
    // CREATE USER
    // ======================
    public function create()
    {
        return view('users/create');
    }

    public function store()
    {
        helper('form');
        $model = new UserModel();

        $model->insert([
            'Username' => $this->request->getPost('Username'),
            'Email' => $this->request->getPost('Email'),
            'Password' => password_hash(
                $this->request->getPost('Password'),
                PASSWORD_BCRYPT
            ),
            'Bio' => $this->request->getPost('Bio'),
            'ProfilePicture' => $this->request->getPost('ProfilePicture'),
        ]);

        return redirect()->to('/users')
            ->with('message', 'User created successfully!');
    }

    // ======================
    // EDIT USER
    // ======================
    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        if ($user['UserID'] != session()->get('UserID')) {
            return redirect()->to('/users')
                ->with('error', 'Tidak boleh edit user lain.');
        }

        return view('users/edit', ['user' => $user]);
    }

    public function update($id)
    {
        helper('form');
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        $data = [
            'Username' => $this->request->getPost('Username'),
            'Email' => $this->request->getPost('Email'),
            'Bio' => $this->request->getPost('Bio'),
            'ProfilePicture' => $this->request->getPost('ProfilePicture'),
        ];

        if ($this->request->getPost('Password')) {
            $data['Password'] = password_hash(
                $this->request->getPost('Password'),
                PASSWORD_BCRYPT
            );
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users/profile'))
            ->with('message', 'User updated successfully!');
    }

    // ======================
    // DELETE USER
    // ======================
    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('/users')
            ->with('message', 'User deleted successfully!');
    }

    // ======================
    // PROFILE USER
    // ======================
    public function profile($id = null)
    {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $targetID = $id ?? session()->get('UserID');
        if (!$targetID) {
            return redirect()->to('/login');
        }

        $user = $userModel->find($targetID);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User tidak ditemukan");
        }

        $posts = $postModel->where('UserID', $targetID)
            ->orderBy('PublicationDate', 'DESC')
            ->findAll();

        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel
                ->where('PostID', $post['PostID'])
                ->countAllResults();

            $post['is_liked'] = session()->get('UserID')
                ? (bool) $likeModel->where([
                    'PostID' => $post['PostID'],
                    'UserID' => session()->get('UserID')
                ])->first()
                : false;
        }

        return view('users/profile', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    // ======================
    // POST YANG DISUKAI USER
    // ======================
    public function likedPosts($id = null)
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $targetID = $id ?? session()->get('UserID');
        if (!$targetID) {
            return redirect()->to('/login');
        }

        $posts = $postModel
            ->select('Post.*, User.Username')
            ->join('likes', 'likes.PostID = Post.PostID')
            ->join('User', 'User.UserID = Post.UserID')
            ->where('likes.UserID', $targetID)
            ->findAll();

        foreach ($posts as &$p) {
            $p['total_likes'] = $likeModel
                ->where('PostID', $p['PostID'])
                ->countAllResults();
            $p['is_liked'] = true;
        }

        return view('users/liked_posts', [
            'posts' => $posts,
            'title' => 'Post yang Disukai'
        ]);
    }
}
