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
            // 「文字列か」「255文字までか」を見る
            'post_text'=>'required_without_all:post_blob|string|max:255',
            // 「画像ファイル形式か」「1024文字以内か」を見る
            'post_blob'=>'required_without_all:post_text|image|max:1024'
        ]);
        $post = new Post(); //新しいPostインスタンスを作成
        if(request('post_text')) { //テキストが入力された時用
            $post->post_text = $validated['post_text'];
        }
        if(request('post_blob')) { //画像が入力された時用
            $name = request()->file('post_blob')->getClientOriginalName(); // 元々のファイル名を取得し、$nameへ代入
            request()->file('post_blob')->move('storage/images',$name); // $nameの名前で画像ファイルを指定した場所に保存
            $post->post_blob = $name; //$nameの名前で画像ファイルのファイル名をデータベースに保存
        }
        $post->user_id=auth()->user()->id; //認証済みのログイン中のユーザーIDを、$post内のuser_idへ保存
        $post->save(); //新しく作成したインスタンスをデータベースに保存
        $request->session()->flash('message','保存しました'); //セッションにmessageを一時保存
        return back(); //処理後に元のページに戻るよう指定
    }

    // 投稿一覧表示
    public function index() {
        $posts=Post::all(); //postsテーブルのデータを全取得（Eloquent ORM使用）
        return view('sns.index',compact('posts')); //indexページにリダイレクトさせた上で、$postsを受け渡す
    }

    // 個別投稿表示
    public function show(Post $post) { // 依存注入、postsテーブルからルートパラメータの数字がIDとなる投稿（post）データを取ってきてくれる
        return view('sns.show',compact('post')); // showページにリダイレクトさせた上で、$postを受け渡す
    }

    // ユーザーページ表示、ゲストユーザー用の判定分を作成する必要あり
    public function userpage(User $user) { // 依存注入、usersテーブルからルートパラメータの数字がIDとなるユーザー（user）を取ってきてくれる
        $posts=Post::where('user_id',$user->id)->get(); // $userのidデータを元に、postsテーブルから該当のユーザーIDの投稿全てを持ってくる

        // ログインしているかどうかで、ユーザーページへ受け渡すデータを変動させる
        if(Auth::check()) { // authファサードのcheckメソッドを使用することでユーザーがログインしているかどうか判定、ログインしていればtrue
            $follow=Follow::where('followed_id',$user->id)->where('user_id',auth()->user()->id)->value('followed_id'); // followsテーブル内、「followed_idが$userのidと合致している」かつ「user_idがログインしているユーザーのIDと合致している」行からfollowed_idを抽出している
            return view('sns.userpage',compact('user','posts','follow')); // ユーザーページにリダイレクトさせた上で、$user、$posts、$followを受け渡し
        } else {
            return view('sns.userpage',compact('user','posts')); // ユーザーページにリダイレクトさせた上で、$user、$postsを受け渡し
        }
    }

    // 投稿削除
    public function destroy(Request $request,Post $post) { // 依存注入、postsテーブルからルートパラメータの数字がIDとなる投稿（post）を取ってきてくれる（Requestはメッセージ保存用）
        $post->delete(); // 削除処理
        $request->session()->flash('message','削除しました'); // セッションにメッセージを保存
        return redirect('sns'); // sns.indexページへリダイレクトさせる
    }

    // フォロー
    public function follow(Request $request,User $user) { // 依存注入、usersテーブルからルートパラメータの数字がIDとなるユーザー（user）を取ってきてくれる（Requestはメッセージ保存用）
        $follow = new Follow(); // 新しいfollowインスタンスを作成
        $follow->user_id = auth()->user()->id; // $followのuser_idにセッション内のユーザーIDを設定
        $follow->followed_id = $user->id; // $followのfollowed_idにフォロー先のユーザーIDを設定
        $follow->save(); // 新しく作成したインスタンスをデータベースに保存
        $request->session()->flash('message','フォローしました'); // セッションにメッセージを保存
        $posts=Post::where('user_id',$user->id)->get(); // $userのidデータを元に、postsテーブルから該当のユーザーIDの投稿全てを持ってくる（リダイレクト先用）
        return view('sns.userpage',compact('user','posts','follow')); // ユーザーページにリダイレクトさせた上で、$user、$posts、$followを受け渡し
    }

    // フォロー解除
    public function unfollow(Request $request,User $user) { // 依存注入、usersテーブルからルートパラメータの数字がIDとなるユーザー（user）を取ってきてくれる（Requestはメッセージ保存用）
        Follow::where('followed_id',$user->id)->where('user_id',auth()->user()->id)->delete(); // followsテーブル内、「followed_idが$userのidと合致している」かつ「user_idがログインしているユーザーのIDと合致している」行を抽出し削除
        $request->session()->flash('message','フォロー解除しました'); // セッションにメッセージを保存
        $posts=Post::where('user_id',$user->id)->get(); // $userのidデータを元に、postsテーブルから該当のユーザーIDの投稿全てを持ってくる（リダイレクト先用）
        return view('sns.userpage',compact('user','posts')); // ユーザーページにリダイレクトさせた上で、$user、$posts、$followを受け渡し
    }

    // フォロー中の投稿一覧表示
    public function following() {
        // ログイン中のユーザーが、フォローしているユーザーの情報を全取得
        $follows = Follow::where('user_id',auth()->user()->id)->get(); // followsテーブル内、user_idがセッション内のユーザーIDと合致しているものを全て取得する（※）

        // posts関数へ、フォローしているユーザーの投稿を格納していく
        $posts = []; // posts配列を作成
        foreach($follows as $follow) {
            $followposts = Post::where('user_id',$follow->followed_id)->get(); // postsテーブル内、user_idが※のfollowed_idと合致しているものを取得し$followpostsへ格納
            foreach($followposts as $followpost) {
                array_push($posts,$followpost); // posts配列へ$followpostの内容を格納していく
            }
        }

        return view('sns.following',compact('posts')); // フォロー中の投稿一覧ページにリダイレクトさせた上で、posts配列を受け渡し
    }
}
