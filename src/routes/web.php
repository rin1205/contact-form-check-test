<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\loginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// お問合せフォームの入力画面表示
Route::get('/', [ContactController::class, 'index'])->name('index');
// お問合せフォームの確認画面表示
Route::post('/confirm', [ContactController::class, 'confirm'])->name('confirm');
// 確認画面からの送信内容を保存して、完了画面を表示
Route::post('/thanks', [ContactController::class, 'store'])->name('thanks');
// 修正時の入力画面表示:old()で入力値再表示
Route::get('/edit', [ContactController::class, 'edit'])->name('edit');
// ログイン画面表示
Route::get('/login', [LoginController::class, 'show'])->name('login');
// ログイン画面からの入力内容を受取、認証処理
Route::post('/login', [LoginController::class, 'login']);

// 認証済みのみアクセスできる
Route::middleware(['auth'])->group(function () {
    // 管理画面表示
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // お問合せデータをエクスポート
    Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');
    // 特定のお問い合わせデータを削除（モーダルウィンドウ内の削除ボタンから）
    Route::delete('/admin/{contact}', [AdminController::class, 'destroy'])->name('admin.delete');
});
