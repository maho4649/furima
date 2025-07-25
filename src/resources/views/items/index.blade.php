@extends('layouts.app')

@section('content')
<div style="margin-top: 2rem; margin-bottom: 1.5rem;"></div>

<div style="flex-wrap: wrap;gap: 40px;justify-content: center;margin-top: 2rem;width: 100%;margin-left: auto;margin-right: auto;">
    
    {{-- タブ切り替え --}}
    <div class="mb-4">
        <a href="{{ route('item.index', ['tab' => 'recommend']) }}"
           class="{{ request('tab') !== 'mylist' ? 'tab-active' : 'tab-inactive' }}">
            おすすめ
        </a>
        <a href="{{ route('item.index', ['tab' => 'mylist']) }}"
           class="{{ request('tab') === 'mylist' ? 'tab-active' : 'tab-inactive' }}">
            マイリスト
        </a>
        <div style="width: 100vw; border-bottom: 2px solid #ccc; margin: 0;"></div>
        
    </div>

    @php
        $isMyList = request('tab') === 'mylist';
    @endphp

    @if ($isMyList && !auth()->check())

    @elseif ($items->isEmpty())
        <p>現在、出品されている商品はありません。</p>
    @else
        <div class="row">
            @foreach ($items as $item)
            
                {{-- ログイン中のユーザーが自分の商品を出品した場合は表示しない --}}
                @auth
                    @if ($item->user_id === auth()->id())
                        @continue
                    @endif
                @endauth

                <div class="col-md-3 mb-4">
                <div class="card h-100 position-relative">
                  @if ($item->is_sold)
                    <div class="sold-overlay">Sold</div>
                    @endif

                   <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                     @if ($item->image_path)
                     <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                     @else
                     <img src="{{ asset('images/no-image.png') }}" class="card-img-top" alt="No Image">
                     @endif
                      </a>

                      <div class="card-body text-center">
                        <h5 class="card-title">{{ $item->name }}</h5>
                       </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
