<?php

namespace App\Http\Controllers;

//バリデーション用のフォームリクエストクラス
use App\Http\Requests\ContactRequest;
//カテゴリのデータベースモデル
use App\Models\Category;
//お問い合わせ内容を保存するモデル
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        //categoriesテーブルの全レコードを取得し、$categoriesに格納
        $categories = Category::all();
        //セッションに保存されている入力内容を取得。入力がなければ空配列
        $contact = $request->session()->get('contact', []);
        //indexファイル（入力画面）を表示。選択肢として$categoriesを渡す。入力内容を再表示可能に。
        return view('index', compact('categories'))->withInput($contact);
    }
    public function confirm(ContactRequest $request)
    {
        //リクエストの中から必要な項目のみを取り出す
        $contact = $request->only(
            ['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']
        );

        //入力内容を保存
        $request->session()->put('contact', $contact);

        // モデル化せずにラベルだけ借りる
        $tmp = new Contact($contact);
        $contact['gender_label'] = $tmp->getGenderLabel();
        $contact['category_id_label'] = $tmp->getCategoryLabel();

        //confirmファイル（確認画面）を表示。$contactを渡す。
        return view('confirm', compact('contact'));
    }

    public function edit(Request $request)
    {
        //入力画面にリダイレクトし、セッションに保存済みの入力内容を再表示
        return redirect()->route('index')->withInput($request->session()->get('contact', []));
    }
    public function store(ContactRequest $request)
    {
        //リクエストの中から必要な項目のみを取り出す
        $contact = $request->only(
            ['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']
        );
        //電話番号を１つの文字列に結合
        $contact['tel'] = $contact['tel1'] . $contact['tel2'] . $contact['tel3'];
        // 不要なtel1〜3を除外（エラー防止）
        unset($contact['tel1'], $contact['tel2'], $contact['tel3']);

        //データベースに保存
        Contact::create($contact);
        //セッションに保存済みの入力内容を削除
        $request->session()->forget('contact');
        //サンクスページ（完了画面）を表示
        return view('thanks');
    }
}
