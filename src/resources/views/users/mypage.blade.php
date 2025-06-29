@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4">マイページ</h2>

    <!-- プロフィール表示 -->
    <div class="flex items-center space-x-4 mb-6">
        @if($user->left_icon)
            <img src="{{ asset('storage/' . $user->left_icon) }}" class="w-16 h-16 rounded-full" alt="プロフィール画像">
        @endif
        <div>
            <p class="text-lg font-bold">{{ $user->name }}</p>
            <a href="{{ route('profile.edit') }}" class="text-blue-500 hover:underline">プロフィールを編集</a>
        </div>
    </div>

    <!-- 商品切り替えタブ -->
    <div class="mb-4 flex space-x-4">
        <a href="{{ route('mypage.sell') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">出品した商品</a>
        <a href="{{ route('mypage.buy') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">購入した商品</a>
    </div>

    <!-- 商品一覧 -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($items as $item)
            <div class="border rounded p-2">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-full h-32 object-cover mb-2">
                <p class="text-center">{{ $item->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
