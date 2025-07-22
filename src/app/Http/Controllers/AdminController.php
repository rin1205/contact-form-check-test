<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // キーワード（名前またはメールアドレス）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別
        if ($request->filled('gender') && $request->gender !== '全て') {
            $query->where('gender', $request->gender);
        }

        // カテゴリ
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 検索条件で絞り込んだ問い合わせ一覧を取得：categoryリレーション（カテゴリ情報）もまとめて取得し、１ページ７件ずつ表示
        $contacts = $query->with('category')->paginate(7)->appends($request->all());
        // 全カテゴリ取得：検索フォームの選択肢として使用
        $categories = Category::all();

        // モーダルウィンドウ用の詳細データを取得
        $contactDetail = null;
        if ($request->filled('detail_id')) {
            $contactDetail = Contact::with('category')->find($request->input('detail_id'));
        }

        // admin.indexを表示。データを渡す。
        return view('admin.index', compact('contacts', 'categories', 'contactDetail'));
    }

    // 削除処理
    public function destroy(Contact $contact)
    {
        // データベースから該当レコードを削除
        $contact->delete();
        // 削除後admin.indexにリダイレクト
        return redirect()->route('admin.index');
    }

    // エクスポート
    public function export(Request $request)
    {
        // contactモデルのデータを取得する際に、categoryリレーション（カテゴリ情報）も一緒に取得
        $query = Contact::with('category');

        // キーワード（名前またはメールアドレス）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                    ->orWhere('last_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別
        if ($request->filled('gender') && $request->gender !== '全て') {
            $query->where('gender', $request->gender);
        }

        // カテゴリ
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 全件取得
        $contacts = $query->get();

        // CSV生成
        // CSVヘッダー
        $csvHeader = ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容', '登録日時'];
        // データをCSV用の配列に変換
        $csvData = $contacts->map(function ($contact) {
            return [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->getGenderLabel(),
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content ?? '',
                $contact->detail,
                $contact->created_at,
            ];
        });

        // ファイル名に現在日時追加
        $filename = 'contacts_export_' . now()->format('Ymd_His') . '.csv';

        // 一時的なメモリ上にファイルを作成
        $handle = fopen('php://temp', 'r+');
        // CSVファイルにデータを書き込む
        fputcsv($handle, $csvHeader);

        // 各行をCSV形式で出力
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        // 最初から読み込むために、ファイルポインタを先頭に戻す
        rewind($handle);
        // データを文字列として取得
        $csvContent = stream_get_contents($handle);
        // メモリ上のファイルを閉じる
        fclose($handle);

        // 文字化け対策
        $csvContent = mb_convert_encoding($csvContent, 'SJIS-win', 'UTF-8');

        // ファイル名を指定し、CSVをダウンロード
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
