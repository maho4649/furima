<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'image_path',
        'user_id',
        'is_sold',
        'condition',
    ];

    public function favorites()
    {
    return $this->hasMany(Favorite::class);
    }

    //出品者（ユーザー）とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // コメントのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // カテゴリの多対多リレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // いいね数
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
     // 商品が売り切れかどうか
    public function isSold()
    {
        return $this->is_sold;
    }

    protected $casts = [
        'is_sold' => 'boolean',
        //'categories' => 'array',
    ];
    
}
