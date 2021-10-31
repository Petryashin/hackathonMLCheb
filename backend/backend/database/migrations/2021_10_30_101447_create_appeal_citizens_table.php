<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealCitizensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal_citizens', function (Blueprint $table) {
            $table->integer("id")->primary();
            $table->longText("text_appeal")->nullable();
            $table->text('adress')->nullable();
            $table->text('home')->nullable();
            $table->json("text_appeal_lem")->nullable();
            $table->string("type")->nullable(); // Тип кластера
            $table->float("lat",8,6)->nullable();
            $table->float("lng",8,6)->nullable();
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
        Schema::dropIfExists('appeal_citizens');
    }
}
