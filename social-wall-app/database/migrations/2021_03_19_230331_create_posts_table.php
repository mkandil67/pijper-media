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
            //allow emoji's and
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->string("post_id")->unique();

            $table->text("caption");
            $table->text("post_url");
            $table->mediumText("image_url") -> nullable();
            $table->boolean("is_trending");
            $table->boolean("is_viral");
            $table->unsignedBigInteger("engagement");
            $table->unsignedBigInteger("old_engagement");
            $table->unsignedBigInteger("writer_id")->nullable();
            $table->dateTime("posted_at")->nullable();
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
