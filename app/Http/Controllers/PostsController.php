<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class PostsController extends Controller
{
    // トップページの表示
    public function index()
    {
        return view('posts.index');
    }

    // 投稿フォームから送信された内容をpostsテーブルに追加する
    public function create(Request $request)
    {
        $post = $request->input('newPost');
        $data = $request->all();
        $val = $this->validator($data);
        if ($val->fails()) {
            return redirect('/top')
                ->withErrors($val)
                ->withInput();
        } else {
            DB::table('posts')->insert([
                'posts' => $post,
                'user_id' => Auth::id(),
            ]);
        }
        return redirect('/top');
    }


    // 投稿を削除
    public function delete($id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return back();
    }

    public function postUpdate(Request $request)
    {
        $id = $request->input('id');
        $up_post = $request->input('upPost');
        $data = $request->all();
        $val = $this->validator($data);
        if ($val->fails()) {
        } else {
            DB::table('posts')
                ->where('id', $id)
                ->update(
                    ['posts' => $up_post]
                );
        }
        return redirect('/top');
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'newPost' => 'max:150',
                'upPost' => 'max:200',
            ],
            [
                'newPost.max' => '150文字以内にしてください',
                'upPost.max' => '200文字以内にしてください',
            ]
        );
    }
}
