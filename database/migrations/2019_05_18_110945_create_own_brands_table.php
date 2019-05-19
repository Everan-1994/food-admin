<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('goods_name');
            $table->string('goods_type')->nullable();
            $table->string('goods_img');
            $table->string('goods_intro');
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
        Schema::dropIfExists('own_brands');
    }
}
