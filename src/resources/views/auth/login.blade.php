@extends('layouts.logo-only')

@section('content')

<div class="auth-form">
    <h2>ログイン</h2>

    @if ($errors->any())
    <div class="error-box">
        @foreach ($errors->all() as $error)
            <p class="error-text">{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
         <label for="email">メールアドレス</label>
         <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>

         <label for="password">パスワード</label>
         <input type="password" name="password" id="password" required>
         
        <button type="submit">ログイン</button>
    </form>
    <a href="{{ route('register') }}" >会員登録はこちら</a>
</div>
@endsection
