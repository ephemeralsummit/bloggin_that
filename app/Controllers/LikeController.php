<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LikeModel;

class LikeController extends BaseController
{
    use ResponseTrait;

    public function toggle($postId)
    {
        $likeModel = new LikeModel();

        // Ambil user login 
        $userId = session()->get('UserID');
        if (!$userId) {
            return $this->failUnauthorized('You must be logged in to like a post.');
        }

        // Cek apakah sudah like
        $existingLike = $likeModel->where([
            'UserID' => $userId,
            'PostID' => $postId
        ])->first();

        if ($existingLike) {
            // Unlike
            $likeModel->delete($existingLike['id']);
            $status = 'unliked';
        } else {
            // Like
            $likeModel->insert([
                'UserID' => $userId,
                'PostID' => $postId
            ]);
            $status = 'liked';
        }

        // Hitung total like
        $totalLikes = $likeModel
            ->where('PostID', $postId)
            ->countAllResults();

        return $this->respond([
            'status' => 'success',
            'action' => $status,
            'total_likes' => $totalLikes
        ]);
    }
}
