<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants_proxies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('contact');
            $table->string('tel');
            $table->string('address');
            $table->string('business_license');
            $table->string('range');
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
        Schema::dropIfExists('merchants_proxies');
    }
}
