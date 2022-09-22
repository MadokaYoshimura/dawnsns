<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;


class FollowsController extends Controller
{
    //
    public function followList()
    {
        // usersテーブルと結合して、follower_idからログイン中のユーザーIDを検索して、フォローユーザーの情報を取得する
        $follow_list = DB::table('follows')
            ->join('users', 'follows.follow_id', '=', 'users.id')
            ->where('follower_id', Auth::id())
            ->select('users.*')
            ->get();
        return view('follows.followList')
            ->with([
                'follow_list' => $follow_list,
            ]);
    }
    public function followerList()
    {
        // usersテーブルと結合して、follow_idからログイン中のユーザーIDを検索して、フォロワーの情報を取得する
        $follower_list = DB::table('follows')
            ->join('users', 'follows.follower_id', '=', 'users.id')
            ->where('follow_id', Auth::id())
            ->select('users.*')
            ->get();

        return view('follows.followerList')
            ->with([
                'follower_list' => $follower_list,
            ]);
    }

    public function follow($id)
    {
        // 新たにフォローして追加する
        DB::table('follows')
            ->insert([
                'follow_id' => $id,
                'follower_id' => Auth::id(),
            ]);
        return back();
    }

    public function remove($id)
    {
        // 選択したユーザーのフォロワーが自分のデータを消す（フォローリストから削除）
        DB::table('follows')
            ->where('follower_id', Auth::id())
            ->where('follow_id', $id)
            ->delete();
        return back();
    }
}
