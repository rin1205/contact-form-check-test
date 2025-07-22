<!-- layouts.appを継承 -->
@extends('layouts.app')

<style>
    svg.w-5.h-5 {
        /*paginateメソッドの矢印の大きさ調整*/
        width: 20px;
        height: 20px;
    }
</style>

<!-- cssファイルの読み込み -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

<!-- メインコンテンツ -->
@section('content')
<div class="admin__content">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>
    <!-- 検索フォーム：/adminにget送信 -->
    <form action="{{ route('admin.index') }}" class="admin__search" method="get">
        <!-- 名前・メールアドレス検索のテキストボックス:request()で入力値保持 -->
        <input type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
        <!-- 性別選択のセレクトボックス -->
        <div class="selectbox">
            <select name="gender" class="select-box__item">
                <option value="" disabled {{ request('gender') ? '' : 'selected' }}>性別</option>
                <option value="全て" {{ request('gender') == '全て' ? 'selected' : '' }}>全て</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>
        </div>
        <!-- お問い合わせの種類選択のセレクトボックス -->
        <div class="selectbox">
            <select name="category_id" class="select-box__item">
                <option value="" disabled {{ request('category_id') ? '' : 'selected'}}>お問い合わせの種類</option>
                <!-- カテゴリ一覧をセレクトボックスの選択肢として表示 -->
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->content }}
                </option>
                @endforeach
            </select>
        </div>
        <!-- 日付検索の入力欄 -->
        <input type="date" name="date" value="{{ request('date') }}">
        <!-- 検索ボタン -->
        <button type="submit" class="search__button">検索</button>
        <!-- リセットボタン -->
        <a href="{{ route('admin.index') }}" class="reset__button">リセット</a>
    </form>

    <!-- エクスポート用フォーム：get送信 -->
    <form action="{{ route('admin.export') }}" method="get" class="form">
        <!-- 検索条件を保持し、エクスポートの結果に反映 -->
        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
        <input type="hidden" name="gender" value="{{ request('gender') }}">
        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <!-- エクスポートボタン -->
        <button class="export-button" type="submit">エクスポート</button>
        <!-- ページネーション：カスタムテンプレート -->
        <div class="pagination">
            {{ $contacts->links('vendor.pagination.custom') }}
        </div>
    </form>

    <!-- 一覧テーブル -->
    <table class="admin-table">
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <!-- ヘッダーラベルなし -->
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- お問い合わせデータを1件ずつループしてテーブルに表示 -->
            @foreach($contacts as $contact)
            <tr>
                <!-- 氏名(姓・名) -->
                <td>{{ $contact->last_name }}　{{ $contact->first_name }}</td>
                <!-- 性別 -->
                <td>{{ $contact->getGenderLabel() }}</td>
                <!-- メールアドレス -->
                <td>{{ $contact->email }}</td>
                <!-- お問い合わせの種類 -->
                <td>{{ $contact->getCategoryLabel() }}</td>
                <!-- 詳細ボタン：検索条件を保持、表示するお問い合わせデータのIDをつけてモーダル表示用リンクを生成 -->
                <td><a href="{{ route('admin.index', array_merge(request()->query(), ['detail_id' => $contact->id])) }}" class="detail-button">詳細</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- モーダルウィンドウ -->
@if($contactDetail)
<div class="modal-overlay">
    <div class="modal__content">
        <!-- モーダル内：閉じるボタン -->
        <button class="modal-close" onclick="location.href='{{ route('admin.index',request()->except('detail_id')) }}'">×</button>
        <p>
            <span class="label">お名前</span>
            <span class="value">{{ $contactDetail->last_name }}　{{ $contactDetail->first_name }}</span>
        </p>
        <p>
            <span class="label">性別</span>
            <span class="value">{{ $contactDetail->getGenderLabel() }}</span>
        </p>
        <p>
            <span class="label">メールアドレス</span>
            <span class="value">{{ $contactDetail->email }}</span>
        </p>
        <p>
            <span class="label">電話番号</span>
            <span class="value">{{ $contactDetail->tel }}</span>
        </p>
        <p>
            <span class="label">住所</span>
            <span class="value">{{ $contactDetail->address }}</span>
        </p>
        <p>
            <span class="label">建物名</span>
            <span class="value">{{ $contactDetail->building }}</span>
        </p>
        <p>
            <span class="label">お問い合わせの種類</span>
            <span class="value">{{ $contactDetail->getCategoryLabel() }}</span>
        </p>
        <p>
            <span class="label">お問い合わせ内容</span>
            <span class="value">{{ $contactDetail->detail }}</span>
        </p>
        <!-- モーダル内：削除 -->
        <form action="{{ route('admin.delete',$contactDetail->id) }}" method="post">
            @csrf
            @method('DELETE')
            <!-- 削除ボタン -->
            <button class="delete-button" type="submit">削除</button>
        </form>
    </div>
</div>
@endif

@endsection