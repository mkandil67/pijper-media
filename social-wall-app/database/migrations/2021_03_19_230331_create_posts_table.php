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
            $table->string("post_id")->unique();

            $table->text("caption");
            $table->text("post_url");
            $table->text("image_url") -> nullable();
            $table->boolean("is_trending");
            $table->boolean("is_viral");
            $table->unsignedBigInteger("engagement");
            $table->unsignedBigInteger("old_engagement");
            $table->unsignedBigInteger("writer_id")->nullable();
            $table->dateTime("posted_at");
            $table->unsignedBigInteger("account_id");
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
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
