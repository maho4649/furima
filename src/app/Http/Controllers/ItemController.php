<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use App\Models\Category; 
use App\Models\Like;


class ItemController extends Controller
{
    public function index(Request $request)
{
    $query = Item::query()->latest();

    // 認証中なら自分の出品を除外
    if (auth()->check()) {
        $query->where('user_id', '!=', auth()->id());
    }

    // 商品名で部分一致検索
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $items = $query->get();

    return view('items.index', compact('items'));
}

public function create()
{
    $categories = Category::all();
    return view('items.create', compact('categories'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'brand' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:1',
        'condition' => 'required|string',
        'categories' => 'array',
        'categories.*' => 'integer',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $path = $request->file('image')->store('items', 'public');

    $item = new Item();
    $item->user_id = auth()->id();
    $item->name = $request->name;
    $item->brand = $request->brand;
    $item->description = $request->description;
    $item->price = $request->price;
    $item->condition = $request->condition;
    $item->image_path = $path;
    $item->save();
    $item->categories()->sync($request->categories ?? []);


    return redirect()->route('mypage')->with('success', '商品を出品しました');
}

public function show($item_id)
{
    $item = Item::with(['categories', 'user','likes'])->findOrFail($item_id);

    return view('items.show', compact('item'));
}

public function like($itemId)
{
    $item = Item::findOrFail($itemId);
    $item->likes()->create(['user_id' => auth()->id()]);
    return back();
}

public function comment(Request $request, $itemId)
{
    $request->validate(['comment' => 'required|string|max:255']);
    $item = Item::findOrFail($itemId);
    $item->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->comment
    ]);
    return back();
}

public function toggle($itemId)
{
    $userId = auth()->id();
    $like = Like::where('user_id', $userId)->where('item_id', $itemId)->first();

    if ($like) {
        $like->delete(); // いいね解除
    } else {
        Like::create([
            'user_id' => $userId,
            'item_id' => $itemId,
        ]);
    }

    return back();
}



}
