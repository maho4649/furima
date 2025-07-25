@extends('layouts.app')

@section('content')
<div class=" mx-auto p-4">

    <!-- プロフィール表示 -->
    <div class="container">
        <div style="display: flex; align-items: center; gap: 50px; margin-bottom: 24px;">
            @if($user->left_icon)
                <img src="{{ asset('storage/' . $user->left_icon) }}" 
                     style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;" 
                     alt="プロフィール画像">
            @endif
            <div style="display: flex; align-items: center; gap: 100px;">
                <h2 style="font-weight: bold;">{{ $user->name }}</h2>
                <a href="{{ route('profile.edit') }}" style="display: inline-block;padding: 0.5em 1em;border: 1px solid red;background-color: white;color: red;cursor: pointer;user-select: none;transition: all 0.2s; text-decoration: none;">プロフィールを編集</a>
            </div>
        </div>
     </div>

        <!-- 商品切り替えタブ -->
        <div>
            <a href="{{ route('mypage.sell') }}" 
            class="{{ request()->routeIs('mypage.sell') ? 'tab-active' : 'tab-inactive' }}">出品した商品</a>
            <a href="{{ route('mypage.buy') }}" 
            class="{{ request()->routeIs('mypage.buy') ? 'tab-active' : 'tab-inactive' }}">購入した商品</a>
        </div>
          <div style=" border-bottom: 2px solid #ccc;margin-bottom:1rem;"></div>

        <!-- 商品一覧 -->
         <div class="container">
            @if (session('success'))
            <div style="color: green; font-weight: bold; margin: 10px 0;">
              {{ session('success') }}
            </div>
            @endif

            @foreach($items as $item)
            @if ($item)
            <div class="card h-100 position-relative">
              <img src="{{ asset('storage/' . $item->image_path) }}" 
               alt="{{ $item->name }}" 
               style="width: 100%;height: 180px;object-fit: cover;display: block;border-radius: 6px;">
              <div class="card-body text-center">     
              <h5 class="card-title">{{ $item->name }}</h5>
              </div>
            </div>
            @endif
            @endforeach

        
        </div>

</div>
@endsection
