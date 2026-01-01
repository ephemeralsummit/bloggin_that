<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\LikeModel;
use App\Controllers\BaseController;

class PostController extends BaseController
{
    // =========================
    // LIST POSTS + SEARCH + LIKE
    // =========================
    public function index()
    {
        $postModel = new PostModel();
        $userModel = new UserModel();
        $likeModel = new LikeModel();

        $search = $this->request->getGet('search');
        $userIDFilter = $this->request->getGet('user');
        $currentUserID = session()->get('UserID');

        $builder = $postModel
            ->select('Post.*, User.Username, User.ProfilePicture')
            ->join('User', 'User.UserID = Post.UserID', 'left');

        if (!empty($search)) {
            $builder->groupStart()
                ->like('Post.Title', $search)
                ->orLike('Post.Content', $search)
                ->groupEnd();
        }

        if (!empty($userIDFilter)) {
            $builder->where('Post.UserID', $userIDFilter);
        }

        $posts = $builder
            ->orderBy('Post.PublicationDate', 'DESC')
            ->findAll();

        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel
                ->where('PostID', $post['PostID'])
                ->countAllResults();

            $post['is_liked'] = false;
            if ($currentUserID) {
                $post['is_liked'] = $likeModel->where([
                    'PostID' => $post['PostID'],
                    'UserID' => $currentUserID
                ])->first() ? true : false;
            }
        }

        $users = $userModel->select('UserID, Username')->findAll();

        return view('posts/index', [
            'posts' => $posts,
            'search' => $search,
            'userID' => $userIDFilter,
            'users' => $users
        ]);
    }

    // GET /posts/create
    public function create()
    {
        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('posts/create', ['users' => $users]);
    }

    // POST /posts/store
    public function store()
    {
        $postModel = new PostModel();
        helper(['form']);

        // Handle image upload
        $imageFile = $this->request->getFile('image');
        $imageName = null;

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/uploads', $imageName);
        }

        $data = [
            'Title'           => $this->request->getPost('Title'),
            'Image'           => $imageName, // ✅ filename, not file object
            'Content'         => $this->request->getPost('Content'),
            'Category'        => $this->request->getPost('Category'),
            'PublicationDate' => date('Y-m-d H:i:s'),
            'Tags'            => $this->request->getPost('Tags'),
            'UserID'          => session()->get('UserID'),
        ];

        $postModel->insert($data);

        return redirect()
            ->to('/posts')
            ->with('message', 'Post created successfully!');
    }



    // GET /posts/edit/{id}
    public function edit($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        // --- ADMIN OVERRIDE ---
        $isAdmin = (session()->get('Username') === 'admin');
        if ($post['UserID'] != session()->get('UserID') && !$isAdmin) {
            return redirect()->to('/posts')->with('error', 'You are not allowed to edit this post.');
        }

        $userModel = new UserModel();

        return view('posts/edit', [
            'post' => $post,
            'users' => $userModel->findAll(),
        ]);
    }

    // POST /posts/update/{id}
    public function update($id)
    {
        $postModel = new PostModel();
        helper('form');

        $post = $postModel->find($id);

        if (!$post) {
            return redirect()->to('/posts')->with('error', 'Post not found');
        }

        // --- ADMIN OVERRIDE ---
        $isAdmin = (session()->get('Username') === 'admin');
        if ($post['UserID'] != session()->get('UserID') && !$isAdmin) {
            return redirect()->to('/posts')->with('error', 'Unauthorized update.');
        }

        $imageFile = $this->request->getFile('image');
        $imageName = $post['Image'];

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            if (!empty($imageName) && file_exists(ROOTPATH . 'public/uploads/' . $imageName)) {
                unlink(ROOTPATH . 'public/uploads/' . $imageName);
            }
            $imageName = $imageFile->getRandomName();
            $imageFile->move(ROOTPATH . 'public/uploads', $imageName);
        }

        $data = [
            'Title'    => $this->request->getPost('Title'),
            'Image'    => $imageName,
            'Content'  => $this->request->getPost('Content'),
            'Category' => $this->request->getPost('Category'),
            'Tags'     => $this->request->getPost('Tags'),
            // We keep the original UserID so the admin doesn't "steal" the post
            'UserID'   => $post['UserID'], 
        ];

        $postModel->update($id, $data);

        return redirect()
            ->to('/posts')
            ->with('message', 'Post updated successfully!');
    }

    // GET /posts/delete/{id}
    public function delete($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if (!$post) {
            return redirect()->to('/posts')->with('error', 'Post not found.');
        }

        // --- ADMIN OVERRIDE ---
        $isAdmin = (session()->get('Username') === 'admin');
        if ($post['UserID'] != session()->get('UserID') && !$isAdmin) {
            return redirect()->to('/posts')->with('error', 'You are not allowed to delete this post.');
        }

        // Optional: Delete the image file from server when post is deleted
        if (!empty($post['Image']) && file_exists(ROOTPATH . 'public/uploads/' . $post['Image'])) {
            unlink(ROOTPATH . 'public/uploads/' . $post['Image']);
        }

        $postModel->delete($id);
        return redirect()->to('/posts')->with('message', 'Post deleted successfully!');
    }

    // =========================
    // SINGLE POST VIEW
    // =========================
    public function view($id)
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $currentUserID = session()->get('UserID');

        // Get post + author
        $post = $postModel
            ->select('Post.*, User.Username, User.ProfilePicture')
            ->join('User', 'User.UserID = Post.UserID', 'left')
            ->where('Post.PostID', $id)
            ->first();

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        // Total likes
        $post['total_likes'] = $likeModel
            ->where('PostID', $id)
            ->countAllResults();

        // Is liked by current user
        $post['is_liked'] = false;
        if ($currentUserID) {
            $post['is_liked'] = (bool) $likeModel->where([
                'PostID' => $id,
                'UserID' => $currentUserID
            ])->first();
        }

        return view('posts/view', [
            'post' => $post
        ]);
    }



    // =========================
    // POSTS YANG DI-LIKE USER
    // =========================
    public function likedPosts()
    {
        $currentUserID = session()->get('UserID');
        if (!$currentUserID) {
            return redirect()->to('/login');
        }

        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $posts = $postModel
            ->select([
                        'posts.PostID',
                        'posts.Title',
                        'posts.Content',
                        'posts.Image AS Image', // overwrite intentionally
                        'posts.Tags',
                        'posts.PublicationDate',
                        'users.Username'
                    ])  
            ->join('likes', 'likes.PostID = posts.PostID')
            ->join('users', 'users.UserID = posts.UserID', 'left')
            ->where('likes.UserID', $currentUserID)
            ->orderBy('posts.PublicationDate', 'DESC')
            ->findAll();


        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel
                ->where('PostID', $post['PostID'])
                ->countAllResults();
            $post['is_liked'] = true;
        }

        return view('posts/liked', [
            'posts' => $posts,
            'title' => 'liked posts'
        ]);
    }
}
