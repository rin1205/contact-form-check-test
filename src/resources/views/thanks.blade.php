<!-- layouts.appを継承 -->
@extends('layouts.app')

<!-- cssファイルの読み込み -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

<!-- メインコンテンツ -->
@section('content')
<div class="thanks__content">
    <h2 class="thanks__message">お問合せありがとうございました</h2>
    <a href="/" class="home-button">HOME</a>
</div>
@endsection