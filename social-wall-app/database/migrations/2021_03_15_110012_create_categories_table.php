<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table ->id();
            $table ->unsignedBigInteger('user_id');
            $table ->tinyInteger('News');
            $table ->tinyInteger('Showbizz/Entertainment');
            $table ->tinyInteger('Royals');
            $table ->tinyInteger('Food/Recipes');
            $table ->tinyInteger('Lifehacks');
            $table ->tinyInteger('Fashion');
            $table ->tinyInteger('Beauty');
            $table ->tinyInteger('Health');
            $table ->tinyInteger('Family');
            $table ->tinyInteger('House and garden');
            $table ->tinyInteger('Cleaning');
            $table ->tinyInteger('Lifestyle');
            $table ->tinyInteger('Cars');
            $table ->tinyInteger('Crime');
            $table->timestamps();

            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
