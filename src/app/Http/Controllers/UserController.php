<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class UserController extends Controller
{
    public function editProfile()
   {
    $user = auth()->user();
    return view('users.edit-profile', compact('user'));
   }

    public function updateProfile(AddressRequest $request)
    {

      $user = auth()->user();

     $user->fill($request->only(['name','zipcode', 'address', 'building']));

    if ($request->hasFile('left_icon')) {
        $user->left_icon = $request->file('left_icon')->store('icons', 'public');
    }


     try {
    $user->save();
    return redirect('/')->with('success', 'プロフィールを更新しました');
} catch (\Exception $e) {
    dd($e->getMessage());
}




    }

    public function mypage()
    {
    $user = auth()->user();
    
    if (!$user->zipcode || !$user->address) {
    return redirect()->route('profile.edit')->with('warning', 'プロフィールを入力してください');
    }

    $items = $user->items()->latest()->get();

    return view('users.mypage', [
        'user' => $user,
        'items' => $items,
        'listType' => 'sell', // 例えば「出品商品」表示のときは 'sell'
    ]);
    }

    public function sellList()
    {
    $user = auth()->user();
    $items = $user->items()->latest()->get(); // 出品商品取得
    return view('users.mypage', [
        'user' => $user,
        'items' => $items,
        'listType' => 'sell', 
    ]);
    }

    public function buyList()
    {
    $user = auth()->user();
    $purchases = $user->purchases()->with('item')->orderBy('created_at', 'desc')->get();
    $items = $purchases->pluck('item')->filter();  // null除外

    return view('users.mypage', [
        'user' => $user,
        'items' => $items,
        'listType' => 'buy', 
    ]);
    }




}
