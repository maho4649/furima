<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** 全商品を取得できる */
    public function test_all_items_are_displayed()
    {
        Item::factory()->count(3)->create();

        $response = $this->get('/items');

        $response->assertStatus(200);
        $response->assertSee(Item::first()->name);
    }

    /** 購入済み商品は「Sold」と表示される */
    public function test_sold_label_is_displayed_for_purchased_items()
    {
        $buyer = User::factory()->create();

    // 購入済みの商品のItemを作成し、is_sold=trueにセットする
    $item = Item::factory()->create([
        'is_sold' => true,
    ]);

    // Purchaseレコードも作成（payment_methodなど必須フィールドはファクトリで対応）
    Purchase::factory()->create([
        'user_id' => $buyer->id,
        'item_id' => $item->id,
    ]);

    $response = $this->get('/items');

    $response->assertSee('Sold');
    }

    /** 自分が出品した商品は表示されない */
    public function test_own_items_are_not_displayed()
    {
        $user = User::factory()->create();
        $ownItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/items');

        $response->assertDontSee($ownItem->name);
    }

    public function test_search_by_japanese_keyword()
    {
    Item::factory()->create(['name' => 'パソコン']);
    Item::factory()->create(['name' => 'スマートフォン']);

    $response = $this->get('/items?search=パソコン');

    $response->assertStatus(200);
    $response->assertSeeText('パソコン');
    $response->assertDontSee('スマートフォン');
  }

  /** @test */
    public function マイリストページでも検索結果が保持されている()
    {
        $user = User::factory()->create();

        // 出品者（item1用・item2用）を実際に作成
        $seller1 = User::factory()->create();
        $seller2 = User::factory()->create();

        $item1 = Item::factory()->create([
         'name' => 'パソコン',
         'user_id' => $seller1->id
        ]);

       $item2 = Item::factory()->create([
       'name' => 'Banana Phone',
       'user_id' => $seller2->id
        ]);

        // user が item1 をいいね
        $user->likes()->create(['item_id' => $item1->id]);

        $this->actingAs($user);

        // 検索キーワード付きでマイリストにアクセス
        $response = $this->get('/items?tab=mylist&search=パソコン');

        $response->assertStatus(200);
        $response->assertSeeText('パソコン');
        $response->assertDontSee('Banana Phone');
        // 検索フォームに入力値が保持されていることも検証
        $response->assertSee('パソコン');


    }

}
