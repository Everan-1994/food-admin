<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_intros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('intro');
            $table->string('feature');
            $table->string('idea');
            $table->string('brand_image');
            $table->string('brand_video');
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
        Schema::dropIfExists('brand_intros');
    }
}
