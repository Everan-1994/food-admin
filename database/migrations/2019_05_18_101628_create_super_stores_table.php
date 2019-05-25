<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('content');
            $table->string('intro');
            $table->string('logo');
            $table->string('images_url');
            $table->string('company_name')->nullable();
            $table->string('contact')->nullable();
            $table->string('tel')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('super_stores');
    }
}
