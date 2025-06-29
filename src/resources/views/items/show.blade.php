@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- 左：商品画像 --}}
        <div>
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="rounded-lg w-full">
        </div>

        {{-- 右：商品情報 --}}
        <div>
            <h2 class="text-2xl font-bold mb-2">{{ $item->name }}</h2>
            <p class="text-gray-500 mb-1">ブランド：{{ $item->brand ?? 'なし' }}</p>
            <p class="text-xl font-semibold text-red-500 mb-3">¥{{ number_format($item->price) }}</p>

            {{-- いいね・コメント --}}
            <div class="flex items-center gap-4 mb-4">
                <button class="flex items-center gap-1">⭐ 12</button>
                <button class="flex items-center gap-1">💬 5</button>
            </div>

            <form action="{{ route('purchase.show', $item->id) }}" method="GET">
                <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded mb-4">購入手続きへ</button>
            </form>

            <p class="mb-2"><strong>商品の状態：</strong>{{ $item->condition }}</p>
            <p class="mb-2"><strong>商品説明：</strong><br>{{ $item->description }}</p>
            <p class="mb-2"><strong>カテゴリ：</strong>
                @foreach($item->categories as $cat)
                    <span class="inline-block bg-gray-200 px-2 py-1 text-sm rounded mr-2">{{ $cat->name }}</span>
                @endforeach
            </p>

            {{-- 投稿者情報 --}}
            <div class="mt-6 p-4 border rounded">
                <p class="font-semibold">出品者：{{ $item->user->name }}</p>
                @if ($item->user->left_icon)
                    <img src="{{ asset('storage/' . $item->user->left_icon) }}" alt="ユーザーアイコン" class="w-16 h-16 rounded-full mt-2">
                @endif

                {{-- コメント投稿 --}}
                <form action="#" method="POST" class="mt-4">
                    @csrf
                    <textarea name="comment" rows="3" class="w-full border rounded p-2" placeholder="コメントを入力..."></textarea>
                    <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
