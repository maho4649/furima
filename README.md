## Dockerビルド
1. git clone git@github.com:maho4649/furima.git
2. cd furima
3. docker-compose up -d --build


## Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed
7. php artisan storage:link
8. vendor/bin/phpunit


## 使用技術
php:7.4.9-fpm
Laravel Framework 8.83.29  
mysql  Ver 9.2.0 for macos15.2 on arm64 (Homebrew)  
  
URL  
開発環境:http://localhost/  
phpMyAdmin:http://localhost:8080  


トップページ(管理画面)  
/
商品一覧画面（トップ画面）_マイリスト  
/?page=mylist  
体重検索  
/weight_logs/search  
商品詳細画面  
/item/:item_id  
商品購入画面  
/purchase/:item_id  
送付先住所変更画面  
/purchase/address/:item_id  
商品出品画面  
/sell  
会員登録  
/register  
プロフィール画面  
/mypage
プロフィール編集画面（設定画面）  
/mypage/profile  
プロフィール画面_購入した商品一覧.  
/mypage?page=buy  
プロフィール画面_出品した商品一覧.  
/mypage?page=sell  
ログイン  
/login  
ログアウト  
/logout  

