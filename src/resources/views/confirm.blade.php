<!-- layouts.appを継承 -->
@extends('layouts.app')

<!-- cssファイルの読み込み -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

<!-- メインコンテンツ -->
@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>
    <!-- フォーム：/thanksにpost送信 -->
    <form action="{{ route('thanks') }}" class="form" method="post">
        @csrf
        <!-- 送信するデータをhiddenで保持 -->
        <input type="hidden" name="last_name" value="{{ $contact['last_name'] }}">
        <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
        <input type="hidden" name="gender" value="{{ $contact['gender'] }}">
        <input type="hidden" name="email" value="{{ $contact['email'] }}">
        <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}">
        <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}">
        <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}">
        <input type="hidden" name="address" value="{{ $contact['address'] }}">
        <input type="hidden" name="building" value="{{ $contact['building'] }}">
        <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}">
        <input type="hidden" name="detail" value="{{ $contact['detail'] }}">

        <!-- 表全体 -->
        <div class="confirm-table">
            <table class="confirm-table__inner">
                <!-- お名前 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お名前</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['last_name'] }}　{{ $contact['first_name'] }}" readonly>
                    </td>
                </tr>
                <!-- 性別 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">性別</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['gender_label'] }}" readonly>
                        <!-- 表示用ラベル -->
                    </td>
                </tr>
                <!-- メールアドレス -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">メールアドレス</th>
                    <td class="confirm-table__text">
                        <input type="email" value="{{ $contact['email'] }}" readonly>
                    </td>
                </tr>
                <!-- 電話番号 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">電話番号</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['tel1'] }}{{ $contact['tel2'] }}{{ $contact['tel3'] }}" readonly>
                    </td>
                </tr>
                <!-- 住所 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">住所</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['address'] }}" readonly>
                    </td>
                </tr>
                <!-- 建物名 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">建物名</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['building'] }}" readonly>
                    </td>
                </tr>
                <!-- お問い合わせの種類 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせの種類</th>
                    <td class="confirm-table__text">
                        <input type="text" value="{{ $contact['category_id_label'] }}" readonly>
                        <!-- 表示用ラベル -->
                    </td>
                </tr>
                <!-- お問い合わせ内容 -->
                <tr class="confirm-table__row">
                    <th class="confirm-table__header">お問い合わせ内容</th>
                    <td class="confirm-table__text">
                        <textarea readonly>{{ $contact['detail'] }}</textarea>
                    </td>
                </tr>
            </table>
        </div>
        <!-- ボタンエリア -->
        <div class="form__button">
            <button class="form__button-submit" type="submit">送信</button>
            <a href="{{ route('edit') }}" class="modify-button">修正</a>
        </div>
    </form>
</div>
@endsection