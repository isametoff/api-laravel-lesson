<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('user_id', 'user');
        });
    }


    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('user', 'user_id');
        });
    }
};
