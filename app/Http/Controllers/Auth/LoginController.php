<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'mail' => 'required|string|email',
                'password' => 'required|alpha_dash',
            ],
            [
                'mail.required' => 'メールアドレスを入力してください',
                'password.required' => 'パスワードを入力してください',
            ]
        );
    }


    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            // loginページから送られてきた値を変数$dataに格納
            $data = $request->only('mail', 'password');
            // ↓バリデーターを使って入力チェック
            $val = $this->validator($data);
            if ($val->fails()) {
                return redirect('login')
                    ->withErrors($val)
                    ->withInput();
            } else {
                if (Auth::attempt($data)) {
                    // 現在のパスワードを表示するために文字数をセッションに保存
                    $request->session()->put('word_count', strlen($request->password));
                    return redirect('top');
                } else {
                    // バリデーション成功後、ログイン失敗した場合
                    return redirect('login')
                        ->with('error', 'メールアドレスかパスワードが違います')
                        ->withInput();
                }
            }
        }
        return view("auth.login");
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
