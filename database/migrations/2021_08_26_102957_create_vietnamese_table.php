<?php

use App\Models\Vietnamese;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVietnameseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vietnamese', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger("type")->default(Vietnamese::TYPE_NORMAL);
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
        Schema::dropIfExists('vietnamese');
    }
}
