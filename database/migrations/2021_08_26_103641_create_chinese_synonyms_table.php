<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChineseSynonymsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinese_synonyms', function (Blueprint $table) {
            $table->foreignId('word1_id')->constrained("chinese")->cascadeOnDelete();
            $table->foreignId('word2_id')->constrained("chinese")->cascadeOnDelete();
            $table->primary(["word1_id", "word2_id"]);
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
        Schema::dropIfExists('chinese_synonyms');
    }
}
