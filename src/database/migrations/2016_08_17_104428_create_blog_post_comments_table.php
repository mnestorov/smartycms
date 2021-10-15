<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blog_post_id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->text('content');
            $table->integer('approved')->default(0);
            $table->timestamps();

            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('blog_post_comments');
        Schema::enableForeignKeyConstraints();
    }
}
