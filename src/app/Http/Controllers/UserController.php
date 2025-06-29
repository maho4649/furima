<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function editProfile()
   {
    $user = auth()->user();
    return view('users.edit-profile', compact('user'));
   }

    public function updateProfile(Request $request)
    {
      $request->validate([
        'name' => 'required|string|max:255',
        'zipcode' => 'required|string|max:8',
        'address' => 'required|string|max:255',
        'building' => 'required|string|max:255',
        'left_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

    $user = auth()->user();
    $user->name = $request->name;
    $user->zipcode = $request->zipcode;
    $user->address = $request->address;
    $user->building = $request->building;

    if ($request->hasFile('left_icon')) {
        $user->left_icon = $request->file('left_icon')->store('icons', 'public');

    }

    $user->save();

    return redirect()->route('mypage')->with('success', 'プロフィールを更新しました。');


    }

    public function mypage()
    {
    $user = auth()->user();

    if (!$user->zipcode || !$user->address || !$user->building) {
        return redirect()->route('profile.edit')->with('warning', 'プロフィールを入力してください');
    }
    $items = $user->items()->latest()->get();

    return view('users.mypage', compact('user','items'));
    }

    public function sellList()
    {
    $user = auth()->user();
    $items = $user->items()->latest()->get(); // 出品商品取得
    return view('users.mypage', compact('user', 'items'));
    }

    public function buyList()
    {
    $user = auth()->user();
    $items = $user->purchasedItems()->latest()->get(); // 購入商品取得（リレーションが必要）
    return view('users.mypage', compact('user', 'items'));
    }




}
