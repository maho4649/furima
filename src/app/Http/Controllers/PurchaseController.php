<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;


class PurchaseController extends Controller
{
    public function showPurchaseForm($item_id)
{
    $item = Item::findOrFail($item_id);
    return view('purchase.show', compact('item'));
}

public function purchase(PurchaseRequest $request, $item_id)
{
    $user = auth()->user();
    $item = Item::findOrFail($item_id);

    if ($item->is_sold) {
        return back()->with('error', 'すでに売り切れています。');
    }
    // 住所が未設定ならリダイレクト
    if (!$user->zipcode || !$user->address) {
        return redirect()->route('profile.edit')->with('warning', 'プロフィール（住所）を登録してください');
    }

    // 購入履歴を保存
    Purchase::create([
        'user_id' => $user->id,
        'item_id' => $item->id,
        'payment_method' => $request->payment_method,
        'postal_code' => $user->zipcode,
        'address' => $user->address,
        'building' => $user->building,
    ]);
    // is_sold を true にする
    $item->is_sold = true;
    $item->save();


    return redirect()->route('mypage.buy')->with('success', '購入が完了しました');
  }

  public function editAddress($item_id)
{
    $item = Item::findOrFail($item_id);
    return view('purchase.edit-address', compact('item'));
}

public function updateAddress(Request $request, $item_id)
{
    $request->validate([
        'postal_code' => 'required|string',
        'address' => 'required|string',
        'building' => 'nullable|string',
    ]);

    $user = auth()->user();
    $user->zipcode = $request->postal_code;
    $user->address = $request->address;
    $user->building = $request->building;
    $user->save();

    return redirect()->route('purchase.show', $item_id)->with('success', '住所を更新しました。');
  }

}
