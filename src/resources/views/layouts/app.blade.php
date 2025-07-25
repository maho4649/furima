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
        <!-- 左側：ロゴ -->
        <div class="nav-container">
          <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('storage/logo.svg') }}" alt="Logo">
          </a>

          <!-- 中央：検索フォーム -->
          <form action="{{ route('home') }}" method="GET" class="search-form">
             <input type="text" name="search" placeholder="何をお探しですか？" value="{{ request('search') }}">
          </form>
          <!-- 右側：リンク -->
          <div class="right-area"> 
           <nav class="nav-links auth-links">
                @auth
                    <a href="/mypage">マイページ</a>      
                    <form method="POST" action="/logout" class="logout-form">
                        @csrf
                        <button type="submit">ログアウト</button>
                    </form>
                    <a href="{{ route('item.create') }}"  class="sell-btn">出品</a>
                @endauth
                
                @guest
                 <a href="{{ route('login') }}" >ログイン</a>
                 <a href="{{ route('register') }}" >会員登録</a>
                @endguest
           </nav>
        </div>  
      </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>
</body>
</html>
