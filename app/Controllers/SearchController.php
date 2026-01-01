<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\LikeModel;

class SearchController extends BaseController
{
    public function index() {
        $userModel = new \App\Models\UserModel();
        return view('posts/search', [
            'users' => $userModel->select('UserID, Username')->findAll()
        ]);
    }

    public function fetch()
    {
        $postModel = new \App\Models\PostModel();
        
        // Use $this->request->getGet() to ensure we are grabbing the right keys
        $search = $this->request->getGet('search');
        $tags = $this->request->getGet('tags');

        $builder = $postModel->select('Post.*, User.Username, User.ProfilePicture')
                            ->join('User', 'User.UserID = Post.UserID', 'left');

        // Filter 1: Keywords (Title or Content)
        if (!empty(trim($search))) {
            $builder->groupStart()
                    ->like('Post.Title', $search)
                    ->orLike('Post.Content', $search)
                    ->orLike('User.Username', $search)
                    ->groupEnd();
        }

        // Filter 2: Tags
        // We use another groupStart if you want to be strict
        if (!empty(trim($tags))) {
            // This ensures the query includes: AND (Post.Tags LIKE %tag%)
            $builder->like('Post.Tags', trim($tags));
        }

        $posts = $builder->orderBy('Post.PublicationDate', 'DESC')->findAll();

        // Pass data to the partial view
        return view('partials/post_list', ['posts' => $posts]);
    }

    public function search()
    {
        $postModel = new PostModel();
        $userModel = new UserModel();
        $likeModel = new LikeModel();

        // 1. Capture the GET parameters
        $search = $this->request->getGet('search');
        $userIDFilter = $this->request->getGet('user');
        $currentUserID = session()->get('UserID');

        // 2. Build the query
        $builder = $postModel
            ->select('Post.*, User.Username, User.ProfilePicture')
            ->join('User', 'User.UserID = Post.UserID', 'left');

        // Apply filters only if data is provided
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

        // 3. Handle Like data (Optional: See optimization tip in previous reply)
        foreach ($posts as &$post) {
            $post['total_likes'] = $likeModel->where('PostID', $post['PostID'])->countAllResults();
            $post['is_liked'] = false;
            if ($currentUserID) {
                $post['is_liked'] = $likeModel->where([
                    'PostID' => $post['PostID'],
                    'UserID' => $currentUserID
                ])->first() ? true : false;
            }
        }

        // 4. Get list of users for the dropdown filter
        $users = $userModel->select('UserID, Username')->findAll();

        // 5. Return the search-specific view
        return view('posts/search', [
            'posts'  => $posts,
            'search' => $search,
            'userID' => $userIDFilter,
            'users'  => $users
        ]);
    }
}

    