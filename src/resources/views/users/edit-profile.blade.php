@extends('layouts.app')

@section('content')
<h2>プロフィール設定</h2>
 <div class="flex items-center space-x-2">
    @if($user->left_icon)
        <img src="{{ asset('storage/' . $user->left_icon) }}" class="w-8 h-8 rounded-full" alt="left icon">
    @endif
  </div>
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="left_icon" accept="image/*">
    
    <label>ユーザー名</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}">

    <label>郵便番号</label>
    <input type="text" name="zipcode" value="{{ old('zipcode', auth()->user()->zipcode) }}">

    <label>住所</label>
    <input type="text" name="address" value="{{ old('address', auth()->user()->address) }}">

    <label>建物名</label>
    <input type="text" name="building" value="{{ old('building', auth()->user()->building) }}">

    <button type="submit">保存</button>
</form>
@endsection