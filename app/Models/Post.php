<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // 編集して良い項目を指定
    protected $fillable = [
        'post_text',
        'post_blob',
        'user_id'
    ];

    // usersテーブルとのリレーション設定（1対1）
    public function user() {
        return $this->belongsTo(User::class);
    }
}
