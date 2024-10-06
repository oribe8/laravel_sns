<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    // 編集して良い項目を指定
    protected $fillable = [
        'user_id',
        'followed_id'
    ];

    // usersテーブルとのリレーション設定（1対1）
    public function followuser() {
        return $this->belongsTo(User::class);
    }
}
