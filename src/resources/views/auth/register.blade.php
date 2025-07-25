@extends('layouts.logo-only')

@section('content')
<div class="auth-form">
    <h2>会員登録</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <label for="name">名前</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
        <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
        <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
        @error('password')
        <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label for="password_confirmation">パスワード確認</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        @error('password_confirmation')
        <div class="text-red-500">{{ $message }}</div>
        @enderror

        <button type="submit">登録</button>
    </form>
    <a href="{{ route('login') }}" >ログインはこちら</a>
</div>
@endsection
