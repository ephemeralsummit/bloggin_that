<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;

class UserController extends BaseController
{
    // GET /users
    public function index()
    {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $users = $userModel->findAll();
        $post = $postModel
            ->select('Post.*, User.Username')
            ->join('User', 'User.UserID = Post.UserID', 'left')
            ->findAll();
        // Render the index view
        return view('users/index', ['users' => $users, 'posts' => $post]);
    }

    // GET /users/create
    public function create()
    {
        return view('users/create');
    }

    // POST /users/store
    public function store()
    {
        $model = new UserModel();
        helper('form');


        $data = [
            'Username' => $this->request->getPost('Username'),
            'Email' => $this->request->getPost('Email'),
            'Password' => password_hash($this->request->getPost('Password'), PASSWORD_BCRYPT),
            'Bio' => $this->request->getPost('Bio'),
            'ProfilePicture' => $this->request->getPost('ProfilePicture'),
        ];

        $model->insert($data);

        return redirect()->to('/users')->with('message', 'User created successfully!');
    }

    // GET /users/edit/{id}
    public function edit($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        if ($user['UserID'] != session()->get('UserID')) {
            return redirect()->to('/users')->with('error', 'You are not allowed to edit this user.');
        }

        return view('users/edit', ['user' => $user]);
    }

    // POST /users/update/{id}
    public function update($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        helper('form');


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
            $data['Password'] = password_hash($this->request->getPost('Password'), PASSWORD_BCRYPT);
        }

        $model->update($id, $data);

        return redirect()->to(site_url('users/profile/' . session()->get('UserID')))->with('message', 'User updated successfully!');
    }

    // GET /users/delete/{id}
    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('/users')->with('message', 'User deleted successfully!');
    }

    // GET /users/profile/{id}
    public function profile($id)
    {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $userID = $this->request->getGet('user');
        $user = $userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User not found");
        }

        $posts = $postModel->where('UserID', $id)->findAll();

        return view('users/profile', [
            'user' => $user,
            'posts' => $posts,
            'userID' => $userID
        ]);
    }
}
