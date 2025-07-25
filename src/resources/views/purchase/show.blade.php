@extends('layouts.app')

@section('content')
<div class="purchase-wrapper" style="margin-top: 40px;">
  <form action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST">
    @csrf

    {{-- コンテナ中央寄せ --}}
    <div style="max-width: 1000px; margin: 0 auto; display: flex; justify-content: space-between; gap: 40px; align-items: flex-start;">

      {{-- 左側：商品情報＋フォーム --}}
      <div style="flex: 1;">
        <!-- 商品情報 -->
        <div style="display: flex; gap: 16px; margin-bottom: 24px;">
          <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width: 160px; height: 160px; object-fit: cover;">
          <div>
            <h2 style="font-size: 20px; font-weight: bold;">{{ $item->name }}</h2>
            <p class="price-text" style="font-size: 24px;">¥{{ number_format($item->price) }}</p>
          </div>
        </div>
        </br>
         <div style=" border-bottom: 2px solid #ccc;margin-bottom: 2.5rem; margin-top: 2rem padding-bottom: 0.5rem;"></div>

        <!-- 支払い方法 -->
        <div style="margin-top: 2rem;">
          <label style="font-weight: bold; display: block; margin-bottom: 8px;font-size: 1.5rem;
    ">支払い方法</label>
          <select name="payment_method" style="width: 40%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">選択してください</option>
            <option value="credit">クレジットカード</option>
            <option value="bank">銀行振込</option>
            <option value="cod">代金引換</option>
          </select>
        </div>
        @if ($errors->has('payment_method'))
         <p style="color: red;">{{ $errors->first('payment_method') }}</p>
        @endif


        </br>
        <div style=" border-bottom: 2px solid #ccc;margin-top: 2rem;"></div>

        <!-- 配送先 -->
        <div style="margin-top: 1rem;">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
            <h2 style="font-weight: bold;">配送先</h2>
            <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}" style="font-size: 14px; color: blue; text-decoration: underline;">変更する</a>
          </div>
          <div style=" padding: 12px; border-radius: 6px;">
            <p>〒{{ auth()->user()->zipcode }}</p>
            <p>{{ auth()->user()->address }}</p>
            @if(auth()->user()->building)
              <p>{{ auth()->user()->building }}</p>
            @endif
          </div>
        </div>
        </br>
          <div style=" border-bottom: 2px solid #ccc;margin-top: 2rem padding-bottom: 0.5rem;"></div>
       </div>
      
      
      {{-- 右側：購入情報 --}}
      <div style="width: 320px; display: flex; flex-direction: column; gap: 16px;">

        @if (session('error'))
         <div style="color: red; font-weight: bold; margin: 10px 0;">
         {{ session('error') }}
         </div>
        @endif

       {{-- 情報ボックス（枠あり） --}}
       <div style="border: 1px solid #ccc; border-radius: 8px; overflow: hidden;">
        <!-- 商品代金 -->
        <div style="display: flex; justify-content: space-between; padding: 12px 16px; border-bottom: 1px solid #ccc;">
         <span style="font-weight: bold;">商品代金</span>
          <span>¥{{ number_format($item->price) }}</span>
        </div>

        <!-- 支払い方法 -->
         <div style="display: flex; justify-content: space-between; padding: 12px 16px;">
           <span style="font-weight: bold;">支払い方法</span>
            <span id="selected-method">未選択</span>
         </div>
       </div>

       {{-- ボタンだけ別に（枠なし） --}}
       <div style="text-align: center;">
        <button type="submit"
         style="width: 100%; background-color: #ff4800; color: white; padding: 10px 0; font-size: 16px; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">購入する
        </button>
       </div>
      </div>

      
    </div>
  </form>
</div>

<script>
  document.querySelector('select[name="payment_method"]').addEventListener('change', function () {
    const method = {
      credit: 'クレジットカード',
      bank: '銀行振込',
      cod: '代金引換'
    }[this.value] || '未選択';
    document.getElementById('selected-method').textContent = method;
  });
</script>
@endsection
