<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 商品名
            $table->string('brand')->nullable(); // ブランド名
            $table->text('description')->nullable(); // 商品説明
            $table->unsignedInteger('price');  // 価格
            $table->string('image_path')->nullable(); // 商品画像
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 出品者
            $table->boolean('is_sold')->default(false); // 売却状態
            $table->string('condition')->nullable(); // 商品の状態
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
