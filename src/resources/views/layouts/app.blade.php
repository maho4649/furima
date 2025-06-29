<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
          <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('storage/logo.svg') }}" alt="Logo">
          </a>
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <input type="text" name="search" placeholder="何をお探しですか？" value="{{ request('search') }}">
                <button type="submit">検索</button>
            </form>

            <nav class="nav-links auth-links">
                @auth
                    <a href="/mypage" class="nav-btn">マイページ</a>      
                    <form method="POST" action="/logout" class="logout-form">
                        @csrf
                        <button type="submit"class="nav-btn">ログアウト</button>
                    </form>
                    <a href="{{ route('item.create') }}"  class="sell-btn">出品</a>
                @endauth
            </nav>
            @guest
              <nav class="nav-links guest-links">
                    <a href="{{ route('login') }}">ログイン</a>
                    <a href="{{ route('register') }}">会員登録</a>
               </nav>
            @endguest
            
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
