<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail'
    ];

    // Contactモデルにcategoryという名前のリレーションを定義
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //性別の数値を文字列に変換
    public function getGenderLabel()
    {
        switch ($this->gender) {
            case 1:
                return '男性';
            case 2:
                return '女性';
            case 3:
                return 'その他';
            default:
                return '';
        }
    }
    // カテゴリIDの数値を文字列に変換
    public function getCategoryLabel()
    {
        if ($this->category) {
            return $this->category->content;
        }

        switch ($this->category_id) {
            case 1:
                return '商品のお届けについて';
            case 2:
                return '商品の交換について';
            case 3:
                return '商品トラブル';
            case 4:
                return 'ショップへのお問い合わせ';
            case 5:
                return 'その他';
            default:
                return '';
        }
    }
}
