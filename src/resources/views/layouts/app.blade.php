<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <!-- Google Fontsの読み込み -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@900&family=Spectral&display=swap" rel="stylesheet">
    <!-- cssの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <!-- 各ページ専用のcss読み込み -->
    @yield('css')
</head>

<body>
    <!-- ヘッダー -->
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">Fashionably Late</a>
        </div>
        <!-- ナビゲーション -->
        <nav class="header-nav">
            <!-- ログインページの場合 -->
            @if (Request::is('login'))
            <!-- registerへのリンク表示 -->
            <a class="header-nav__link" href="{{ route('register') }}">register</a>
            <!-- 登録ページの場合 -->
            @elseif (Request::is('register'))
            <!-- loginへのリンク表示 -->
            <a class="header-nav__link" href="{{ route('login') }}">login</a>
            <!-- ログイン状態を確認：ログイン中＆管理画面の場合 -->
            @elseif (Auth::check() && Request::is('admin*'))
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <!-- ログアウトボタンを表示 -->
                <button class="header-nav__button">logout</button>
            </form>
            @endif
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

</body>

</html>