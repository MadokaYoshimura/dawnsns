<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    このコントローラーは、新規ユーザーの登録とその検証および作成を処理します。デフォルトでは、このコントローラーはトレイトを使用して、追加のコードを必要とせずにこの機能を提供します。
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * 登録後にユーザーをリダイレクトする場所。
     * @var string
     */
    protected $redirectTo = '/added';

    /**
     * Create a new controller instance.
     * 新しいコントローラインスタンスを作成します。
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array  $data
     * @return \Illulminate\Contracts\Vaidation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'username' => 'required|string|min:4|max:12',
                'mail' => 'required|string|email|min:4|max:12|unique:users',
                'password' => 'required|alpha_dash|min:4|max:12',
                'password_confirmation' => 'same:password'
            ],
            [
                'username.required' => 'ユーザー名をは必須です',
                'username.min' => 'ユーザー名は4文字以上にしてください',
                'username.max' => 'ユーザー名は12文字以内にしてください',
                'mail.required' => 'メールアドレスは必須です',
                'mail.min' => 'メールアドレスは4文字以上にしてください',
                'mail.max' => 'メールアドレスは12文字以内にしてください',
                'mail.unique' => 'このメールアドレスは使用できません',
                'password.required' => 'パスワードは必須です',
                'password.alpha_dash' => 'パスワードは英数字のみ使用可能です',
                'password.min' => 'パスワードは4文字以上で入力してください',
                'password.max' => 'パスワードは12文字以内で入力してください',
                'password_confirmation.same' => 'パスワードが一致しません',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'mail' => $data['mail'],
            'password' => Hash::make($data['password']),
        ]);
    }


    // public function registerForm(){
    //     return view("auth.register");
    // }

    // 新規登録画面のフォームで送信された値を$request変数で受け取り
    public function register(Request $request)
    {
        // 受け取った値のHTTP動詞がPOSTなら実行
        if ($request->isMethod('post')) {

            // 受け取った値を変数$dataに格納
            $data = $request->input();

            // 変数$valにバリデーション後の$dataを代入
            $val = $this->validator($data);
            // バリデーションがNGだった場合の処理
            if ($val->fails()) {
                // ページはそのままで
                return redirect("register")
                    ->withErrors($val)
                    ->withInput();
            } else {

                // createメソッドを$dataで実行
                $this->create($data);

                // 新規登録完了画面へ移動
                return redirect('added');
            }
        }
        // Falseならこのままのページを表示
        return view('auth.register');
    }

    public function added()
    {
        // usersテーブルを作成日時で降順にして一番最初のデータを取得して$usersに格納
        $user = DB::table('users')->orderBy('created_at', 'desc')->first();
        // 変数usersを送る
        return view('auth.added', compact('user'));
    }
}
