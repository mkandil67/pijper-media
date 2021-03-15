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
            $table ->tinyInteger('DIY');
            $table ->tinyInteger('Cuisine');
            $table ->tinyInteger('Sports');
            $table ->tinyInteger('Politics');
            $table ->tinyInteger('Entertainment');
            $table -> tinyInteger('Health');
            $table ->tinyInteger('Business');
            $table->timestamps();

            $table->index('user_id');
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
