<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function showPurchaseForm($item_id)
{
    $item = Item::findOrFail($item_id);
    return view('purchase.show', compact('item'));
}

public function purchase(Request $request, $item_id)
{
    $item = Item::findOrFail($item_id);

    // 購入処理ロジック（例：購入テーブルに記録）
    $request->validate([
        'payment_method' => 'required',
        'postal_code' => 'required',
        'address' => 'required',
    ]);

    auth()->user()->purchases()->create([
        'item_id' => $item->id,
        'payment_method' => $request->payment_method,
        'postal_code' => $request->postal_code,
        'address' => $request->address,
        'building' => $request->building,
    ]);

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
