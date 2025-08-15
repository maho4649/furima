<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;

class ItemCreateTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
public function 商品出品画面で必要な情報が保存できる()
{
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    // カテゴリを作成
    $cat1 = \App\Models\Category::factory()->create(['id' => 1]);
    $cat2 = \App\Models\Category::factory()->create(['id' => 2]);

    // ダミー画像
    $file = \Illuminate\Http\UploadedFile::fake()->create('dummy.jpg', 100);

    $response = $this->post(route('item.store'), [
        'name' => 'テスト商品',
        'brand' => 'ブランドA',
        'description' => '商品説明です',
        'price' => 1000,
        'condition' => '良好',
        'categories' => [$cat1->id, $cat2->id],
        'image' => $file,
    ]);

    $response->assertRedirect('/mypage'); // または route('mypage') でもOK

    $this->assertDatabaseHas('items', [
        'name' => 'テスト商品',
        'user_id' => $user->id,
    ]);
}

}
