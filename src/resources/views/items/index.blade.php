@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品一覧</h1>

    @if ($items->isEmpty())
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
                    <div class="card h-100">
                        <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                            @if ($item->image_path)
                                <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->name }}">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="card-img-top" alt="No Image">
                            @endif
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $item->name }}</h5>

                            @if ($item->is_sold)
                                <span class="badge bg-secondary">Sold</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
