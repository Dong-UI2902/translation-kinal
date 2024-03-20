<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVietnameseSynonymsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vietnamese_synonyms', function (Blueprint $table) {
            $table->foreignId('word1_id')->constrained("vietnamese")->cascadeOnDelete();
            $table->foreignId('word2_id')->constrained("vietnamese")->cascadeOnDelete();
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
        Schema::dropIfExists('vietnamese_synonyms');
    }
}
