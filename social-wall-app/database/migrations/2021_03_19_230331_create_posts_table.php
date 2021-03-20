<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string("category");
            $table->string("platform");
            $table->text("caption");
            $table->text("post_url");
            $table->text("image_url");
            $table->unsignedBigInteger("engagement");
            $table->unsignedBigInteger("old_engagement");
            $table->unsignedBigInteger("writer_id")->nullable();
            $table->timestamps();


            $table->foreign('writer_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
