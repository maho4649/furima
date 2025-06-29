@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">購入手続き</h2>

    {{-- 商品情報 --}}
    <div class="flex gap-6 mb-6">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-40 h-40 object-cover rounded">
        <div>
            <h3 class="text-xl font-semibold mb-1">{{ $item->name }}</h3>
            <p class="text-red-500 text-xl font-bold">¥{{ number_format($item->price) }}</p>
        </div>
    </div>

    {{-- 購入フォーム --}}
    <form action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        {{-- 支払い方法 --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">支払い方法</label>
            <select name="payment_method" class="w-full border rounded p-2" required>
                <option value="">選択してください</option>
                <option value="credit">クレジットカード</option>
                <option value="bank">銀行振込</option>
                <option value="cod">代金引換</option>
            </select>
        </div>

        {{-- 住所入力 --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">〒郵便番号</label>
            <input type="text" name="postal_code" class="w-full border rounded p-2" placeholder="例: 123-4567" 
            value="{{ old('postal_code', auth()->user()->zipcode) }}" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-2">住所</label>
            <input type="text" name="address" class="w-full border rounded p-2" placeholder="住所を入力" 
            value="{{ old('address', auth()->user()->address) }}" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-2">建物名（任意）</label>
            <input type="text" name="building" class="w-full border rounded p-2" placeholder="建物名"
            value="{{ old('building', auth()->user()->building) }}">
        </div>
        <div class="mb-4 text-right">
            <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}" class="text-blue-600 underline">変更する</a>
        </div>

        {{-- 確認枠 --}}
        <div class="border rounded p-4 bg-gray-100 mb-6">
            <p><strong>商品代金：</strong>¥{{ number_format($item->price) }}</p>
            <p><strong>支払い方法：</strong><span id="selected-method">未選択</span></p>
        </div>

        {{-- 購入ボタン --}}
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded">
            購入する
        </button>
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
