<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PostModel;
use App\Models\LikeModel;

class UserController extends BaseController
{
    public function profile($id = null)
    {
        $userModel = new UserModel();
        $postModel = new PostModel();
        $likeModel = new LikeModel();

        $targetID = $id ?? session()->get('UserID');
        if (!$targetID)
            return redirect()->to('/login');

        $user = $userModel->find($targetID);
        if (!$user)
            throw new \CodeIgniter\Exceptions\PageNotFoundException("User tidak ditemukan");

        // Post yang DIBUAT oleh user ini
        $posts = $postModel->where('UserID', $targetID)
            ->orderBy('PublicationDate', 'DESC')->findAll();

        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel->where('post_id', $post['PostID'])->countAllResults();
            $post['is_liked'] = session()->get('UserID') ? ($likeModel->where(['post_id' => $post['PostID'], 'user_id' => session()->get('UserID')])->first() ? true : false) : false;
        }

        return view('user/profile', ['user' => $user, 'posts' => $posts]);
    }

    // VIEW KHUSUS: Postingan yang di-LIKE oleh user tersebut
    public function likedPosts($id = null)
    {
        $postModel = new PostModel();
        $likeModel = new LikeModel();
        $targetID = $id ?? session()->get('UserID');

        if (!$targetID)
            return redirect()->to('/login');

        $posts = $postModel->select('Post.*, User.Username')
            ->join('likes', 'likes.post_id = Post.PostID')
            ->join('User', 'User.UserID = Post.UserID')
            ->where('likes.user_id', $targetID)
            ->findAll();

        foreach ($posts as &$p) {
            $p['total_likes'] = $likeModel->where('post_id', $p['PostID'])->countAllResults();
            $p['is_liked'] = true;
        }

        return view('user/liked_posts', ['posts' => $posts, 'title' => 'Post yang Disukai']);
    }
}