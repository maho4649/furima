<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;
use App\Models\Category; 
use App\Models\Like;



class ItemController extends Controller
{
    public function index(Request $request)
{
    $tab = $request->input('tab');
    $userId = auth()->id();

    // ▼ マイリスト：ログインしているユーザーが「いいね」した商品だけ表示
    if ($tab === 'mylist' && auth()->check()) {
        $items = Item::whereHas('likes', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

    // ▼ おすすめ：ログイン中は自分の商品と自分のいいねを除く、それ以外は全商品
    } else {
        $items = Item::query();

        if (auth()->check()) {
            $items->where('user_id', '!=', $userId)
                  ->whereDoesntHave('likes', function ($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        }
    }

    // ▼ 共通：検索があれば適用
    if ($request->filled('search')) {
        $items->where('name', 'like', '%' . $request->search . '%');
    }

    $items = $items->latest()->get();

    return view('items.index', compact('items'));
}


public function create()
{
    $categories = Category::all();
    return view('items.create', compact('categories'));
}

public function store(ExhibitionRequest $request)
{

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

public function comment(CommentRequest $request, $itemId)
{
    $request->validate(['comment' => 'required|string|max:255']);
    $item = Item::findOrFail($itemId);
    $item->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->comment
    ]);
    return back()->with('success', 'コメントを投稿しました。');
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
