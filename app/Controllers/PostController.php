<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\LikeModel;
use App\Controllers\BaseController;

class PostController extends BaseController
{
    // GET /posts
    public function index()
    {
        $postModel = new PostModel();
        $userModel = new UserModel();
        $likeModel = new LikeModel();

        // 1. Ambil filter/search dari query parameters
        $search = $this->request->getGet('search');
        $userIDFilter = $this->request->getGet('user');
        $currentUserID = session()->get('UserID'); // ID user yang sedang login

        // 2. Base query untuk mengambil posts
        $builder = $postModel->select('Post.*, User.Username')
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

        $posts = $builder->orderBy('Post.PublicationDate', 'DESC')->findAll();

        // 3. Loop untuk menghitung total like dan cek status "is_liked"
        // menggunakan & agar perubahan pada $post langsung tersimpan di array $posts
        foreach ($posts as &$post) {
            // Hitung total like untuk post ini
            $post['total_likes'] = $likeModel->where('post_id', $post['PostID'])->countAllResults();

            // Cek apakah user yang login sudah pernah like post ini
            $post['is_liked'] = false;
            if ($currentUserID) {
                $check = $likeModel->where([
                    'post_id' => $post['PostID'],
                    'user_id' => $currentUserID
                ])->first();

                if ($check) {
                    $post['is_liked'] = true;
                }
            }
        }

        // Ambil data users untuk dropdown filter
        $users = $userModel->select('UserID, Username')->findAll();

        // Kirim data ke view (Satu return saja di akhir)
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

        $data = [
            'Title' => $this->request->getPost('Title'),
            'Content' => $this->request->getPost('Content'),
            'Category' => $this->request->getPost('Category'),
            'PublicationDate' => date('Y-m-d H:i:s'),
            'Tags' => $this->request->getPost('Tags'),
            'UserID' => session()->get('UserID'),
        ];

        $postModel->insert($data);

        return redirect()->to('/posts')->with('message', 'Post created successfully!');
    }

    // GET /posts/edit/{id}
    public function edit($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Post not found');
        }

        if ($post['UserID'] != session()->get('UserID')) {
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

        $data = [
            'Title' => $this->request->getPost('Title'),
            'Content' => $this->request->getPost('Content'),
            'Category' => $this->request->getPost('Category'),
            'Tags' => $this->request->getPost('Tags'),
            'UserID' => session()->get('UserID'),
        ];

        $postModel->update($id, $data);
        return redirect()->to('/posts')->with('message', 'Post updated successfully!');
    }

    // GET /posts/delete/{id}
    public function delete($id)
    {
        $postModel = new PostModel();
        $post = $postModel->find($id);

        if (!$post) {
            return redirect()->to('/posts')->with('error', 'Post not found.');
        }

        if ($post['UserID'] != session()->get('UserID')) {
            return redirect()->to('/posts')->with('error', 'You are not allowed to delete this post.');
        }

        $postModel->delete($id);
        return redirect()->to('/posts')->with('message', 'Post deleted successfully!');
    }

    // GET /posts/view/{id}
    public function view($id)
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();
        $currentUserID = session()->get('UserID');

        $post = $postModel
            ->select('Post.*, User.Username')
            ->join('User', 'User.UserID = Post.UserID', 'left')
            ->where('Post.PostID', $id)
            ->first();

        if (!$post) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Post not found");
        }

        // Tambahkan juga data like untuk halaman single view
        $post['total_likes'] = $likeModel->where('post_id', $id)->countAllResults();
        $post['is_liked'] = false;
        if ($currentUserID) {
            $post['is_liked'] = $likeModel->where(['post_id' => $id, 'user_id' => $currentUserID])->first() ? true : false;
        }

        return view('posts/view', [
            'post' => $post
        ]);
    }

    // view khusus untuk post yang di cek like
    public function likedPosts()
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $currentUserID = session()->get('UserID');

        if (!$currentUserID) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query: Ambil Post yang UserID-nya ada di tabel likes
        $posts = $postModel->select('Post.*, User.Username')
            ->join('User', 'User.UserID = Post.UserID', 'left')
            ->join('likes', 'likes.post_id = Post.PostID') // Join ke tabel likes
            ->where('likes.user_id', $currentUserID)        // Filter hanya like milik user login
            ->orderBy('Post.PublicationDate', 'DESC')
            ->findAll();

        // Tambah info total likes agar tampilan konsisten
        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel->where('post_id', $post['PostID'])->countAllResults();
            $post['is_liked'] = true; //pasti true
        }

        return view('posts/liked', [
            'posts' => $posts,
            'title' => 'Postingan yang Saya Sukai'
        ]);
    }
}
