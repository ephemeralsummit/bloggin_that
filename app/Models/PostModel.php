<?php
namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'Post';
    protected $primaryKey = 'PostID';

    protected $allowedFields = [
        'Title',
        'Image',
        'Content',
        'Category',
        'PublicationDate',
        'Tags',
        'UserID',
    ];

    protected $useTimestamps = false;
    protected $returnType = 'array';

    // Example: fetch posts with user info (join with User table)
    public function getPostsWithUsers()
    {
        return $this->select('Post.*, User.Username, User.Email, User.ProfilePicture')
                    ->join('User', 'User.UserID = Post.UserID', 'left') 
                    ->findAll();
    }

    public function getPostWithUser($postId)
    {
        return $this->select('Post.*, User.Username, User.Email, User.ProfilePicture')
                    ->join('User', 'User.UserID = Post.UserID', 'left')
                    ->where('Post.PostID', $postId)
                    ->first();
    }
}
