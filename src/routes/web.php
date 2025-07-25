<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;


// 商品一覧（トップ画面）
Route::get('/', [ItemController::class, 'index'])->name('home');
// 商品一覧（おすすめ・マイリスト切り替え用）
Route::get('/items', [ItemController::class, 'index'])->name('item.index');


// 商品一覧（マイリスト表示）
Route::get('/mylist', [ItemController::class, 'myList'])->name('home.mylist')->middleware('auth');

// 商品詳細
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');

// 商品購入
Route::get('/purchase/{item_id}', [PurchaseController::class, 'showPurchaseForm'])->name('purchase.show')->middleware('auth');
Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase.store')->middleware('auth');

// 送付先住所変更
Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('purchase.address.edit')->middleware('auth');
Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress'])->name('purchase.address.update')->middleware('auth');

// 商品出品
Route::get('/sell', [ItemController::class, 'create'])->name('item.create')->middleware('auth');
Route::post('/sell', [ItemController::class, 'store'])->name('item.store')->middleware('auth');

// プロフィール（マイページ）
Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage')->middleware('auth');
Route::get('/mypage/buy', [UserController::class, 'buyList'])->name('mypage.buy')->middleware('auth');
Route::get('/mypage/sell', [UserController::class, 'sellList'])->name('mypage.sell')->middleware('auth');

// プロフィール編集
Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('profile.edit')->middleware('auth');
Route::put('/mypage/profile', [UserController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

//お気に入り・コメント
Route::post('/items/{item}/like', [ItemController::class, 'like'])->name('items.like')->middleware('auth');
Route::post('/items/{item}/like', [ItemController::class, 'toggle'])->name('items.like')->middleware('auth');

Route::post('/items/{item}/comment', [ItemController::class, 'comment'])->name('items.comment')->middleware('auth');

