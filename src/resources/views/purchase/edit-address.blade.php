@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <h2 class="text-2xl font-bold mb-6">送付先住所の変更</h2>

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        {{-- 郵便番号 --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">〒郵便番号</label>
            <input type="text" name="postal_code" class="w-full border rounded p-2"
                   placeholder="例: 123-4567"
                   value="{{ old('postal_code', auth()->user()->zipcode) }}" required>
        </div>

        {{-- 住所 --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">住所</label>
            <input type="text" name="address" class="w-full border rounded p-2"
                   placeholder="住所を入力"
                   value="{{ old('address', auth()->user()->address) }}" required>
        </div>

        {{-- 建物名 --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">建物名（任意）</label>
            <input type="text" name="building" class="w-full border rounded p-2"
                   placeholder="建物名など"
                   value="{{ old('building', auth()->user()->building) }}">
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            更新する
        </button>
    </form>
</div>
@endsection
