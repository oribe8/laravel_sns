<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// ----------↓新規追加↓----------
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Post;
use App\Models\Follow;
// ----------↑新規追加↑----------

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ----------↓新規追加↓----------

        // 投稿詳細ページへの削除ボタン追加用
        Gate::define('delete_button',function(User $user,Post $post) {
            if($user->id === $post->user_id) {
                return true;
            }
            return false;
        });

        // 投稿者ページへのフォローボタン追加用（ユーザーページにて、対象のユーザーが自分でない場合ボタン追加）
        Gate::define('follow_button',function(User $user,User $posthost) {
            if($user->id !== $posthost->id) {
                return true;
            }
            return false;
        });

        // 投稿者ページへのフォロー解除ボタン追加用（ユーザーページにて、対象のユーザーをフォローしている場合ボタン追加）
        Gate::define('unfollow_button',function(User $user,User $posthost) {
            $followed = Follow::where('followed_id',$posthost->id)->where('user_id',$user->id)->value('followed_id');
            if(!is_null($followed)) {
                return true;
            }
            return false;
        });

        // ----------↑新規追加↑----------
    }
}
