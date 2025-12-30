<?php

namespace App\Models;

use CodeIgniter\Model;

class LikeModel extends Model
{
    // Nama tabel di database
    protected $table = 'likes';

    // Nama primary key tabel
    protected $primaryKey = 'id';

    // Kolom yang diizinkan untuk diisi (Mass Assignment)
    protected $allowedFields = ['user_id', 'PostID'];

    // Mengaktifkan fitur otomatis pengisian waktu (created_at)
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; 
    /**
     * Fungsi opsional untuk mempermudah pengecekan apakah user tertentu
     * sudah memberikan like pada postingan tertentu.
     */
    public function checkLike($userId, $postId)
    {
        return $this->where([
            'user_id' => $userId,
            'PostID' => $postId
        ])->first();
    }

    /**
     * Fungsi opsional untuk menghitung total like sebuah postingan.
     */
    public function countLikes($postId)
    {
        return $this->where('PostID', $postId)->countAllResults();
    }
}