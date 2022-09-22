<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;


class UsersController extends Controller
{
    //
    public function profile($id)
    {
        //選択したユーザーの呟き一覧を表示する
        $profile_list = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('user_id', $id)
            ->select('posts.*', 'users.username', 'users.images', 'users.bio')
            // post.*じゃなくて必要なデータだけにする
            ->latest()
            ->get();
        $select_user = User::find($id);

        return view('users.profile')
            ->with([
                'profile_list' => $profile_list,
                'select_user' => $select_user,
            ]);
    }

    // プロフィールの編集画面へ遷移
    public function profileUpdateForm()
    {
        $user = DB::table('users')
            ->where('id', Auth::id())
            ->first();
        $word_count = session()->get('word_count');
        return view('users.profileUpdate', [
            'user' => $user,
            'word_count' => $word_count,
        ]);
    }

    // プロフィールのアップデート
    protected function profileUpdate(Request $request)
    {
        // 受け取った値のHTTP動詞がPOSTなら実行
        // if ($request->isMethod('post')) {
        // 受け取った値を変数$dataに格納
        $data = $request->all();
        // 変数$valにバリデーション後の$dataを代入
        $val = $this->validator($data);
        // バリデーションがNGだった場合の処理
        if ($val->fails()) {
            // ページはそのままで
            return redirect()->route('profile-update', ['id' => Auth::id()])
                ->withErrors($val)
                ->withInput();
        } else {
            $user = Auth::user();
            $user->fill([
                'username' => $data['username'],
                'mail' => $data['mail'],
                'bio' => $data['bio'],
            ]);
            // 画像はファイルがあれば更新
            if (isset($data['images'])) {
                $file = request()->file('images');
                $fileName = $file->getClientOriginalName();
                $file->storeAs('public/images/icons', $fileName);
                // 画像のリサイズ
                Image::make($file)->resize(55, 55)->save(public_path('images/icons/' . $fileName));
                $user->fill([
                    'images' => $fileName,
                ]);
            }
            // 新しいパスワードが入力されていたら更新
            if (isset($data['new_password'])) {
                $user->fill([
                    'password' => Hash::make($data['new_password']),
                ]);
                // 現在のパスワードを表示するために文字数をセッションに保存
                $request->session()->put('word_count', strlen($request->new_password));
            }
            // 変更があれば更新
            $user->save();

            // プロフィール画面へ遷移
            return redirect()->route('profile', ['id' => Auth::id()]);
        }
        // }
        // Falseならこのままのページを表示
        return redirect()->route('profile-update', ['id' => Auth::id()]);
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'username' => 'required|string|min:4|max:12',
                'mail' => 'required|string|email|min:4|max:12',
                'mail' => Rule::unique('users')->ignore(Auth::id(), 'id'),
                'new_password' => 'alpha_num|min:4|max:12|different:password|nullable',
                'bio' => 'max:200|nullable',
                'images' => 'file|mimes:jpg,png,bmp,gif,svg|nullable',
            ],
            [
                'username.required' => 'ユーザー名をは必須です',
                'username.min' => 'ユーザー名は4文字以上にしてください',
                'username.max' => 'ユーザー名は12文字以内にしてください',
                'mail.required' => 'メールアドレスは必須です',
                'mail.min' => 'メールアドレスは4文字以上にしてください',
                'mail.max' => 'メールアドレスは12文字以内にしてください',
                'mail.unique' => 'このメールアドレスは使用できません',
                'new_password.alpha_dash' => 'パスワードは英数字のみ使用可能です',
                'new_password.min' => 'パスワードは4文字以上で入力してください',
                'new_password.max' => 'パスワードは12文字以内で入力してください',
                'new_password.different' => 'このパスワードは使用できません',
                'bio.max' => 'プロフィール文は200文字以内にしてください',
                'images.file' => 'アップロードに失敗しました',
                'images.mimes' => 'このファイルは使用できません',
            ]
        );
    }

    // 検索画面
    public function search(Request $request)
    {
        $search = $request->input('Search');
        $query = User::query();

        // 検索ワードが入力されていなければ
        if (empty($search)) {
            // 自分以外の全てのユーザーの一覧を取得
            $list = User::where('id', '<>', Auth::id())->get();
            return view('users.search')
                ->with([
                    'list' => $list,
                    'search' => $search,
                ]);
        } else {
            // 検索ワードが入力されていたら
            // あいまい検索をしてヒットするユーザーの一覧を取得
            $query->where('username', 'like', '%' . $search . '%')->where('id', '<>', Auth::id());
            $list = $query->paginate(10);

            return view('users.search')
                ->with([
                    'list' => $list,
                    'search' => $search,
                ]);
        };
    }
}
