<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ----------↓新規追加↓----------
use App\Http\Controllers\PostController;
Route::get('sns/create',[PostController::class,'create'])->name('sns.create')->middleware('auth'); //投稿画面表示
Route::post('sns',[PostController::class,'store'])->name('sns.store'); //投稿実行
Route::get('sns',[PostController::class,'index'])->name('sns.index'); //投稿一覧表示
Route::get('sns/show/{post}',[PostController::class,'show'])->name('sns.show'); //個別投稿表示
Route::delete('sns/{post}',[PostController::class,'destroy'])->name('sns.destroy'); //投稿削除
Route::get('sns/userpage/{user}',[PostController::class,'userpage'])->name('sns.userpage'); //ユーザーページ表示
Route::post('sns/userpage/{user}',[PostController::class,'follow'])->name('sns.follow'); //フォロー
Route::delete('sns/userpage/{user}',[PostController::class,'unfollow'])->name('sns.unfollow'); //フォロー解除
Route::get('sns/following',[PostController::class,'following'])->name('sns.following')->middleware('auth'); //フォロー中の投稿一覧表示
Route::get('/dashboard',[PostController::class,'index'])->middleware(['auth'])->name('dashboard'); //ログイン後、投稿一覧が表示されるようにする
// ----------↑新規追加↑----------

Route::get('/', function () {
    // return view('welcome'); //不要のためコメントアウト
});

// ↓不要のためコメントアウト
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
