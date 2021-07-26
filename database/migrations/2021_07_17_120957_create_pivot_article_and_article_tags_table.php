<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePivotArticleAndArticleTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pivot_article_and_article_tags', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('article_id')->comment('article id')->default(0);
            $table->integer('article_tag_id')->comment('article tag id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_article_and_article_tags');
    }
}
