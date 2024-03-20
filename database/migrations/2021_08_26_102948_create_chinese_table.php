<?php

use App\Models\Chinese;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChineseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chinese', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("type")->default(Chinese::TYPE_SIMPLIFIED);
            $table->string("text")->index();
            $table->text("definition")->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(["text", "type"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chinese');
    }
}
