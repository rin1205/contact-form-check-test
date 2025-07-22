<!-- layouts.appを継承 -->
@extends('layouts.app')

<!-- cssファイルの読み込み -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

<!-- メインコンテンツ -->
@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    <!-- フォーム：/confirmにpost送信 -->
    <form action="{{ route('confirm') }}" class="form" method="post">
        @csrf
        <!-- お名前 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- 姓名入力欄 -->
                <div class="form__input--text">
                    <input type="text" name="last_name" placeholder="例:山田" value="{{ old('last_name') }}">
                    <input type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('last_name')
                    {{$message}}
                    @enderror
                </div>
                <div class="form__error">
                    @error('first_name')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 性別 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- ラジオボタンで性別選択＊初期値男性 -->
                <div class="radio-group">
                    <label class="custom-radio">
                        <input type="radio" name="gender" value="1" {{ old('gender','1') === '1' ? 'checked' : '' }}>
                        <span class="radio-mark"></span>男性
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="gender" value="2" {{ old('gender') === '2' ? 'checked' : '' }}>
                        <span class="radio-mark"></span>女性
                    </label>
                    <label class="custom-radio">
                        <input type="radio" name="gender" value="3" {{ old('gender') === '3' ? 'checked' : '' }}>
                        <span class="radio-mark"></span>その他
                    </label>
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('gender')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- メールアドレス -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- アドレス入力欄 -->
                <div class="form__input--text">
                    <input type="email" name="email" placeholder="例:test@example.com" value="{{ old('email') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('email')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 電話番号 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- 電話番号入力欄(３分割) -->
                <div class="form__input--text">
                    <input class="tel-input" type="text" name="tel1" placeholder="080" value="{{ old('tel1') }}">
                    <span>-</span>
                    <input class="tel-input" type="text" name="tel2" placeholder="1234" value="{{ old('tel2') }}">
                    <span>-</span>
                    <input class="tel-input" type="text" name="tel3" placeholder="5678" value="{{ old('tel3') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('tel1')
                    <p>{{ $message }}</p>
                    @enderror
                    @error('tel2')
                    <p>{{ $message }}</p>
                    @enderror
                    @error('tel3')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <!-- 住所 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- 住所入力欄 -->
                <div class="form__input--text">
                    <input type="text" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('address')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 建物名 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <!-- 建物名入力欄(任意) -->
                <div class="form__input--text">
                    <input type="text" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building') }}">
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('building')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- お問い合わせの種類 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <!-- セレクトボックスで種類選択＊初期値：選択してください -->
            <div class="form__group-content">
                <select class="select-box__item" name="category_id">
                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>選択してください</option>
                    <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>商品のお届けについて</option>
                    <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>商品の交換について</option>
                    <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>商品トラブル</option>
                    <option value="4" {{ old('category_id') == 4 ? 'selected' : '' }}>ショップへのお問い合わせ</option>
                    <option value="5" {{ old('category_id') == 5 ? 'selected' : '' }}>その他</option>
                </select>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('category_id')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- お問い合わせ内容 -->
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <!-- お問い合わせ内容入力欄：テキストボックス -->
                <div class="form__input--textarea">
                    <textarea name="detail" placeholder="お問合せ内容をご記載ください">{{ old('detail') }}</textarea>
                </div>
                <!-- エラーメッセージ表示 -->
                <div class="form__error">
                    @error('detail')
                    {{$message}}
                    @enderror
                </div>
            </div>
        </div>
        <!-- 送信ボタン -->
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection