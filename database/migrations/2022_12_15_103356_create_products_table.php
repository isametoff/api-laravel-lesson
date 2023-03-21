<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('sex');
            $table->string('country');
            $table->string('address');
            $table->string('address2');
            $table->string('work_phone');
            $table->string('home_phone');
            $table->string('email');
            $table->string('marital_status');
            $table->string('dob_year')->nullable();
            $table->string('state');
            $table->string('sity');
            $table->string('dl')->nullable();
            $table->integer('zip');
            $table->integer('price');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
