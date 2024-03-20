<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordPosTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_pos_taggables', function (Blueprint $table) {
            $table->id();
            $table->string("tag_code");
            $table->foreign('tag_code')->references("code")->on("word_pos_tags")->cascadeOnDelete();
            $table->morphs('taggable');
            $table->unique(['tag_code', 'taggable_id', 'taggable_type']);
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
        Schema::dropIfExists('word_pos_taggables');
    }
}
