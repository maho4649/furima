@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
   <div class="product-wrapper">
        {{-- 左：商品画像のみ --}}
        <div class="product-image">
            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="rounded-lg">
        </div>

        {{-- 右：商品情報まとめて1つに --}}

        <div class="product-info">
            {{-- 商品名・ブランド・価格・購入ボタン --}}
                <h2>{{ $item->name }}</h2>
                    <p >ブランド：{{ $item->brand ?? 'なし' }}</p>
                    <p class="price-text">¥{{ number_format($item->price) }} <span style="font-size: 20px; font-weight: normal;">（税込）</span></p>

                   
        {{-- いいねボタン --}}
        <div class="likes-comments text-center">
          <form action="{{ route('items.toggleLike', $item->id) }}" method="POST" class="action-group">
          @csrf
          @php
           $liked = auth()->check() && auth()->user()->likes->contains('item_id', $item->id);
          @endphp
            <button type="submit" class="like-button {{ $liked ? 'liked' : '' }}">☆</button>
            <span class="count">{{ $item->likes->count() }}</span>
          </form>
          
         {{-- コメントボタン --}}
            <div class="action-group">
              <button type="button" onclick="toggleComments()" class="comment-button">💬</button>
                <span class="count">{{ $item->comments->count() }}</span>
            </div>

        </div>
       
            {{-- 購入ボタン --}}
            <form action="{{ route('purchase.show', $item->id) }}" method="GET" >
                <button class="buy-button">購入手続きへ</button>
            </form>

            <h2 class="font-semibold mt-6 mb-2">商品説明</h2>
             <p class="mb-2">{{ $item->description }}</p>
             <p>購入後、即発送いたします。</p>

            <h2 class="font-semibold mt-6 mb-2">商品の情報</h2>
            <div class="info-row">
              <div class="info-label">カテゴリ</div>
                <div class="info-content">
                   @foreach($item->categories as $cat)
                 <span class="category-pill">{{ $cat->name }}</span>
                 @endforeach
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">商品の状態</div>
                 <div class="info-content">
                   {{ $item->condition }}
                 </div>
            </div>

            

            {{-- コメント表示 --}}
            <h2 class="mt-6 mb-2 text-lg font-semibold">コメント（{{ $item->comments->count() }}件）</h2>
            
               {{-- 投稿者情報 --}}
                  <div class="mt-6 p-4 border rounded">
                    <div class="seller-box flex items-center gap-3">
                    @if ($item->user->left_icon)
                    <img src="{{ asset('storage/' . $item->user->left_icon) }}" alt="ユーザーアイコン" class="seller-icon rounded-full w-12 h-12">
                    @endif
                     <div class="seller-info">
                       <p class="font-semibold">出品者：{{ $item->user->name }}</p>
                     </div>
                    </div>
                   </div>
                   @forelse ($item->comments as $comment)
                <div class="flex items-start gap-3 mb-3">
                    {{-- コメント本文 --}}
                    <div>
                        <p class="text-sm text-gray-700">
                          <span class="font-semibold">{{ $comment->user->name }}：</span>{{ $comment->content }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 mb-4">コメントはまだありません。</p>
            @endforelse

            {{-- コメント投稿欄 --}}
            <form action="{{ route('items.comment', $item->id) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="comment" rows="3"  class="textarea_comment" placeholder="コメントを入力...">{{ old('comment') }}</textarea>
                  @error('comment')
                   <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
                <button type="submit" class="buy-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection


            