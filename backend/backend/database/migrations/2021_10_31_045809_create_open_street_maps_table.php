<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenStreetMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_street_maps', function (Blueprint $table) {
            $table->integer("id")->primary();
            $table->float("lat",8,6)->nullable();
            $table->float("lng",8,6)->nullable();
            $table->longText("type")->nullable();
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
        Schema::dropIfExists('open_street_maps');
    }
}
