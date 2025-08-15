<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\Like;
use App\Models\Comment;


class ShowTest extends TestCase
{
     use RefreshDatabase;

     /** @test */
    public function ゲストは商品詳細ページを開ける()
    {
        // Arrange: 商品データを作成
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 12345,
        ]);

        // Act: 商品詳細ページにアクセス
        $response = $this->get(route('item.show', $item->id));

        // Assert: ステータスと表示内容を確認
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee(number_format(12345));
    }

    /** @test */
    public function ログインユーザーも商品詳細ページを開ける()
    {
        // Arrange: ユーザーと商品を作成
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => 'ログインテスト商品',
        ]);

        // Act: ログイン状態でアクセス
        $response = $this->actingAs($user)->get(route('item.show', $item->id));

        // Assert
        $response->assertStatus(200);
        $response->assertSee('ログインテスト商品');
    }


    /** @test */
    public function ログインユーザーはいいねできる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post("/items/{$item->id}/toggle")
            ->assertStatus(302);
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function いいね済みの商品は色が変わる表示になる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);
        $response = $this->get("/item/{$item->id}");

        $response->assertSee('like-button'); // ビューでのCSSクラスなどに合わせる
    }

    /** @test */
    public function いいね解除できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->actingAs($user)
            ->post("/items/{$item->id}/toggle")
            ->assertStatus(302);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

     /** @test */
    public function ログイン済みユーザーはコメント送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user)
            ->post("/items/{$item->id}/comment", ['comment' => '素晴らしい商品です'])
            ->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => '素晴らしい商品です',
        ]);
    }

    /** @test */
    public function ログイン前ユーザーはコメントできない()
    {
        $item = Item::factory()->create();

        $this->post("/items/{$item->id}/comment", ['comment' => 'テストコメント'])
            ->assertRedirect('/login');
    }

     /** @test */
    public function コメント未入力はバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post("/items/{$item->id}/comment", ['comment' => '']);

        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function コメントが255文字以上はバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)
            ->post("/items/{$item->id}/comment", ['comment' => $longComment]);

        $response->assertSessionHasErrors('comment');
    }

}
