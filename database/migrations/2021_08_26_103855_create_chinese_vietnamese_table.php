<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChineseVietnameseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinese_vietnamese', function (Blueprint $table) {
            $table->foreignId('chinese_id')->constrained("chinese")->cascadeOnDelete();
            $table->foreignId('vietnamese_id')->constrained("vietnamese")->cascadeOnDelete();
            $table->string('pos_tag_code');
            $table->primary(['chinese_id', 'vietnamese_id', 'pos_tag_code']);
            $table->foreign('pos_tag_code')->references("code")->on("word_pos_tags")->cascadeOnDelete();
            $table->unsignedBigInteger("frequency")->default(0);
            $table->boolean("verified")->default(false);
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
        Schema::dropIfExists('chinese_vietnamese');
    }
}
