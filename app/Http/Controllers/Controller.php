<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Illuminate\Support\Facades\DB;
use View;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            // ログインしているユーザーの情報
            $user = Auth::user();
            // フォローしている人の情報の取得
            $follow = DB::table('follows')
                ->where('follower_id', $user->id)
                ->get();
            // フォロワーの数の取得
            $follower = DB::table('follows')
                ->where('follow_id', $user->id)
                ->get();
            // フォローしている人の数の取得
            $follow_count = $follow->count();
            // フォローしている人の数の取得
            $follower_count = $follower->count();
            // フォローしているユーザーと自分の呟きを取得
            $list = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('follows', 'users.id', '=', 'follows.follow_id')
                ->where('follower_id', Auth::id())
                ->orWhere('posts.user_id', Auth::id())
                ->select('posts.*', 'users.username', 'users.images')
                ->groupBy('posts.id')
                ->latest()
                ->get();

            $follow_posts = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->join('follows', 'users.id', '=', 'follows.follow_id')
                ->where('follower_id', Auth::id())
                ->select('posts.*', 'users.username', 'users.images')
                ->groupBy('posts.id')
                ->latest()
                ->get();

            $follower_posts = DB::table('posts')
                ->join('users', 'posts.user_id', '=', 'users.id')
                ->leftJoin('follows', 'users.id', '=', 'follows.follower_id')
                ->where('follow_id', Auth::id())
                ->select('posts.*', 'users.username', 'users.images')
                ->groupBy('posts.id')
                ->latest()
                ->get();

            $follow = DB::table('follows')
                ->where('follower_id', Auth::id())
                ->get();
            // $followを配列化して、フォローしているユーザーのidだけ取得
            $followed = array_column($follow->toArray(), 'follow_id');

            View::share('user', $user);
            View::share('follow', $follow);
            View::share('follower', $follower);
            View::share('follow_count', $follow_count);
            View::share('follower_count', $follower_count);
            View::share('list', $list);
            View::share('follow_posts', $follow_posts);
            View::share('follower_posts', $follower_posts);
            View::share('followed', $followed);

            return $next($request);
        });
    }
}
