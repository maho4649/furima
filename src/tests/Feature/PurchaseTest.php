<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入するボタンを押下すると購入が完了する()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->for($seller)->create([

            'is_sold' => false, // 例えばフラグがあるなら
        ]);

        // buyerとしてログイン
        $this->actingAs($buyer);

        // 購入画面を表示（GET）
        $response = $this->actingAs($buyer)->post(route('purchase.store', ['item_id' => $item->id]), [
    'payment_method' => 'credit', 
]);


        $response->assertStatus(302);

        // 購入処理をPOSTで実行
        $response = $this->post(route('purchase.store', ['item_id' => $item->id]));

        // リダイレクト等レスポンス確認
        $response->assertStatus(302);

    }

    /** @test */
    public function 商品購入後は商品一覧画面にsoldと表示される()
    {
        $seller = User::factory()->create();
        $buyer = User::factory()->create();
        $item = Item::factory()->for($seller)->create(['is_sold' => true]);

        $this->actingAs($buyer);

        $response = $this->get(route('item.index'));
        $response->assertStatus(200);
        $response->assertSee('sold');  // sold表示があるかチェック
    }

    /** @test */
    public function 購入した商品はプロフィールの購入商品一覧に追加される()
    {
        $buyer = User::factory()->create();
    $seller = User::factory()->create();
    $item = Item::factory()->for($seller)->create();

    $this->actingAs($buyer);

    // 購入ページ表示（事前確認）
    $response = $this->get(route('purchase.show', ['item_id' => $item->id]));
    $response->assertStatus(200);

    // 購入処理
    $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
        'payment_method' => 'credit',
    ]);
    $response->assertRedirect(route('profile.edit'));

    // マイページ購入一覧
    $response = $this->get(route('mypage.buy'));
    $response->assertStatus(200);
    
    }

    /** @test */
public function 支払い方法を選択できる()
{
    // ユーザー作成 & ログイン
    $user = User::factory()->create();
    $item = Item::factory()->create(['is_sold' => false]);

    $this->actingAs($user);

    // 支払い方法選択画面を開く
    $response = $this->get(route('purchase.show', ['item_id' => $item->id]));
    $response->assertStatus(200);
    $response->assertSee('支払い方法');

    // 支払い方法を選択して購入
    $response = $this->post(route('purchase.store', ['item_id' => $item->id]), [
        'payment_method' => 'credit',
    ]);

    $response->assertRedirect(route('profile.edit'));
}

/** @test */
public function 送付先住所変更が購入画面に反映される()
{
    // ユーザー作成 & ログイン（最初は住所空）
    $user = User::factory()->create([
        'zipcode' => null,
        'address' => null,
        'building' => null,
    ]);
    $item = Item::factory()->create(['is_sold' => false]);

    $this->actingAs($user);

    // 住所を変更
    $this->post(route('purchase.address.update', ['item_id' => $item->id]), [
        'postal_code' => '123-4567',
        'address' => '東京都渋谷区1-2-3',
        'building' => 'テストビル101',
    ])->assertRedirect(route('purchase.show', $item->id));

    // 商品購入画面を再度開く
    $response = $this->get(route('purchase.show', ['item_id' => $item->id]));
    $response->assertStatus(200);
    $response->assertSee('〒123-4567');
    $response->assertSee('東京都渋谷区1-2-3');
    $response->assertSee('テストビル101');

    // 住所を反映した状態で購入
    $this->post(route('purchase.store', ['item_id' => $item->id]), [
        'payment_method' => 'credit',
    ])->assertRedirect(route('mypage.buy'));
}


}

