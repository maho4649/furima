<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // idを指定して商品を作成
        DB::table('items')->updateOrInsert(
            ['id' => 7],
            [
                'name' => 'パソコン',
                'brand' => 'mac',
                'price' => 1200,
                'description' => '新品',
                'condition' => '良好',
                'user_id' => 14, // 存在するユーザーIDを入れてください
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
