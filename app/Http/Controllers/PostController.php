<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use Auth;

class PostController extends Controller
{
    // 投稿画面表示
    public function create() {
        return view('sns.create');
    }

    // 投稿実行
    public function store(Request $request) {
        $validated = request()->validate([
            //両方、またはどちらか一方が入力されていればエラーにならないようにする
            'post_text'=>'required_without_all:post_blob|string|max:255',
            'post_blob'=>'required_without_all:post_text|image|max:1024'
        ]);
        $post = new Post();
        if(request('post_text')) { //テキストが入力された時用
            $post->post_text = $validated['post_text'];
        }
        if(request('post_blob')) { //画像が入力された時用
            $name = request()->file('post_blob')->getClientOriginalName();
            request()->file('post_blob')->move('storage/images',$name);
            $post->post_blob = $name;
        }
        $post->user_id=auth()->user()->id;
        $post->save();
        $request->session()->flash('message','保存しました');
        return back();
    }

    // 投稿一覧表示
    public function index() {
        $posts=Post::all(); //全件表示
        return view('sns.index',compact('posts'));
    }

    // 個別投稿表示
    public function show(Post $post) {
        return view('sns.show',compact('post'));
    }

    // ユーザーページ表示、ゲストユーザー用の判定分を作成する必要あり
    public function userpage(User $user) {
        $posts=Post::where('user_id',$user->id)->get();
        if(Auth::check()) {
            $follow=Follow::where('followed_id',$user->id)->where('user_id',auth()->user()->id)->value('followed_id');
            return view('sns.userpage',compact('user','posts','follow'));
        } else {
            return view('sns.userpage',compact('user','posts'));
        }
    }

    // 投稿削除
    public function destroy(Request $request,Post $post) {
        $post->delete();
        $request->session()->flash('message','削除しました');
        return redirect('sns');
    }

    // フォロー
    public function follow(Request $request,User $user) {
        $follow = new Follow();
        $follow->user_id = auth()->user()->id;
        $follow->followed_id = $user->id;
        $follow->save();
        $request->session()->flash('message','フォローしました');
        $posts=Post::where('user_id',$user->id)->get();
        return view('sns.userpage',compact('user','posts','follow'));
    }

    // フォロー解除
    public function unfollow(Request $request,User $user) {
        Follow::where('followed_id',$user->id)->where('user_id',auth()->user()->id)->delete();
        $request->session()->flash('message','フォロー解除しました');
        $posts=Post::where('user_id',$user->id)->get();
        return view('sns.userpage',compact('user','posts'));
    }

    // フォロー中の投稿一覧表示
    public function following() {
        // フォローしているユーザーの情報を全取得
        $follows = Follow::where('user_id',auth()->user()->id)->get();

        // posts関数へ、フォローしているユーザーの投稿を格納していく
        $posts = [];
        foreach($follows as $follow) {
            $followposts = Post::where('user_id',$follow->followed_id)->get();
            foreach($followposts as $followpost) {
                array_push($posts,$followpost);
            }
        }

        return view('sns.following',compact('posts'));
    }
}
