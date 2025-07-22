<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // ログインできるか確認
        if (Auth::attempt($request->only('email', 'password'))) {
            // セッションIDを再生成して安全にログイン
            $request->session()->regenerate();
            return redirect('/admin');
        }
        // 認証失敗時：loginキー・authエラーバッグで送信
        throw ValidationException::withMessages([
            'login' => ['メールアドレスまたはパスワードが正しくありません'],
        ])->errorBag('auth');
    }
}
