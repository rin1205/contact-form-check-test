<!-- layouts.appを継承 -->
@extends('layouts.app')

<!-- cssファイルの読み込み -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

<!-- メインコンテンツ -->
@section('content')
<div class="auth-form__content">
    <div class="auth-form__heading">
        <h2>Login</h2>
    </div>
    <!-- 全体エラー表示：ログイン失敗時（loginキー, authバッグ） -->
    @if ($errors->auth->has('login'))
    <div class="form__error">
        {{ $errors->auth->first('login') }}
    </div>
    @endif

    <!-- フォーム：ログイン処理/loginにpost送信 -->
    <!-- novalidateで標準のバリデーションを無効にし、Laravel側のバリデーションメッセージを適用 -->
    <form action="{{ route('login') }}" class="form" method="post" novalidate>
        @csrf
        <!-- メールアドレス -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例：text@example.com" value="{{ old('email') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- パスワード -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="password" name="password" placeholder="例：coachtech1106">
                    <!-- セキュリティのためvalue属性なし -->
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('password')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- ログインボタン -->
        <div class="form__button-login">
            <button class="form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection