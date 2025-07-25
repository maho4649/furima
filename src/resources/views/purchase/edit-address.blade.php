@extends('layouts.app')

@section('content')
<div style="margin-top: 2rem; max-width: 600px; width: 100%; margin-left: auto; margin-right: auto;">
    <h2 style="text-align: center; font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
    送付先住所の変更</h2>

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        {{-- 郵便番号 --}}
        <div class="mb-4">
            <label style="font-weight: bold;">郵便番号</label>
            <input type="text" name="postal_code" class="w-full border rounded p-2"
                   placeholder="例: 123-4567"
                   value="{{ old('postal_code', auth()->user()->zipcode) }}" required>
        </div>
</br>

        {{-- 住所 --}}
        <div class="mb-4">
            <label style="font-weight: bold;">住所</label>
            <input type="text" name="address" class="w-full border rounded p-2"
                   placeholder="住所を入力"
                   value="{{ old('address', auth()->user()->address) }}" required>
        </div>
</br>

        {{-- 建物名 --}}
        <div class="mb-6">
            <label style="font-weight: bold;">建物名</label>
            <input type="text" name="building" class="w-full border rounded p-2"
                   placeholder="建物名など"
                   value="{{ old('building', auth()->user()->building) }}">
        </div>
</br>

        <button type="submit" style="width: 100%; background-color: #ff4800; color: white; padding: 10px 0; font-size: 16px; font-weight: bold; border: none; border-radius: 6px; cursor: pointer;">
            更新する
        </button>
    </form>
</div>

@endsection
