<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperationReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperation_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('user_name');
            $table->string('user_tel');
            $table->string('user_email');
            $table->string('user_address');
            $table->string('user_message');
            $table->string('images_url');
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
        Schema::dropIfExists('cooperation_reviews');
    }
}
