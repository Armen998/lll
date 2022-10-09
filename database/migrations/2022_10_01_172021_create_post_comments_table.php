<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('post_id')->unsigned();
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')
                ->references('id')->on('post_comments')
                ->onDelete('cascade');
            $table->text('text');
            $table->integer('likes_counts')->default(0);
            $table->integer('dislikes_counts')->default(0);
            $table->integer('comments_counts')->default(0);
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
        Schema::dropIfExists('post_comments');
    }
};
