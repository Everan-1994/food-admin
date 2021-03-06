<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_problems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question');
            $table->string('answer');
            $table->tinyInteger('is_show')->default(1);
            $table->tinyInteger('sort')->default(0);
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
        Schema::dropIfExists('common_problems');
    }
}
