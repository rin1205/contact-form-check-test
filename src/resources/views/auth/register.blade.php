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
        <h2>Register</h2>
    </div>
    <!-- フォーム：/registerにpost送信 -->
    <!-- novalidateで標準のバリデーションを無効にし、Laravel側のバリデーションメッセージを適用 -->
    <form action="{{ route('register') }}" class="form" method="post" novalidate>
        @csrf
        <!-- お名前 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="name" placeholder="例：山田　太郎" value="{{ old('name') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <!-- メールアドレス -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例：test@example.com" value="{{ old('email') }}">
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
        <!-- 登録ボタン -->
        <div class="form__button-register">
            <button class="form__button-submit" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection