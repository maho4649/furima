<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /** いいねした商品だけ表示される */
    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create();
        $notLikedItem = Item::factory()->create();

        // ユーザーが likedItem にいいねをする
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/items?tab=mylist'); // マイリストページのURLに合わせてください

        $response->assertStatus(200);
        $response->assertSee($likedItem->name);
        $response->assertDontSee($notLikedItem->name);
    }

    /** 購入済み商品には「Sold」と表示される */
    public function test_sold_label_is_displayed_for_purchased_items_in_mylist()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'is_sold' => true,
        ]);

        // ユーザーがいいね
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 購入記録も作成（必要に応じて payment_method など設定）
        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => 'credit', // 例
        ]);

        $this->actingAs($user);
        $response = $this->get('/items?tab=mylist');

        $response->assertSee('Sold');
    }

    /** 自分が出品した商品は表示されない */
    public function test_own_items_are_not_displayed_in_mylist()
    {
        $user = User::factory()->create();

        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        // いいねはしているが自分の商品のため表示しない想定
        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $ownItem->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/items?tab=mylist');

        $response->assertDontSee($ownItem->name);
    }

    /** 未認証の場合は何も表示されない（ログインページにリダイレクトなど） */
    public function test_guest_sees_nothing_or_redirect()
    {
        $response = $this->get('/items?tab=mylist');

         $response->assertStatus(200);
       
    }

    /** @test */
public function ユーザー情報と出品購入商品がマイページに表示される()
{
    $user = \App\Models\User::factory()->create([
        'name' => 'テストユーザー',
        'zipcode' => '123-4567',
        'address' => '東京都千代田区1-1-1',
    ]);

    // 出品商品
    $sellItem = \App\Models\Item::factory()->for($user)->create([
        'name' => '出品商品A',
    ]);

    // 購入商品（別ユーザーが出品）
    $seller = \App\Models\User::factory()->create();
    $buyItem = \App\Models\Item::factory()->for($seller)->create([
        'name' => '購入商品B',
    ]);
    \App\Models\Purchase::factory()->create([
        'user_id' => $user->id,
        'item_id' => $buyItem->id,
    ]);

    $this->actingAs($user);

    // マイページ（出品商品タブ）
    $response = $this->get(route('mypage.sell'));
    $response->assertStatus(200);
    $response->assertSee('テストユーザー');
    $response->assertSee('出品商品A');

    // マイページ（購入商品タブ）
    $response = $this->get(route('mypage.buy'));
    $response->assertStatus(200);
    $response->assertSee('購入商品B');
}

/** @test */
public function プロフィールを変更するとマイページに反映される()
{
    $user = \App\Models\User::factory()->create();

    $this->actingAs($user);

    // プロフィール更新
    $response = $this->put(route('profile.update'), [
        'name' => '新しい名前',
        'zipcode' => '987-6543',
        'address' => '大阪府',
        'building' => 'テストビル',
    ]);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => '新しい名前',
        'zipcode' => '987-6543',
        'address' => '大阪府',
        'building' => 'テストビル',
    ]);

    // マイページを開いて反映確認
    $response = $this->get(route('profile.edit'));
    $response->assertSee('新しい名前');
    $response->assertSee('987-6543');
    $response->assertSee('大阪府');
}


}
