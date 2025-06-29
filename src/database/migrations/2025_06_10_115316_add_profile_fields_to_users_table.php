<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('zipcode')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->string('left_icon')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'zipcode')) {
                $table->dropColumn('zipcode');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('users', 'building')) {
                $table->dropColumn('building');
            }
            if (Schema::hasColumn('users', 'left_icon')) {
                $table->dropColumn('left_icon');
            }
        });
    }
}
