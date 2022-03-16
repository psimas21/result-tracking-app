<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePollingUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polling_units', function (Blueprint $table) {
            $table->id();
            $table->string('polling_unit');
            $table->string('pu_code');
            $table->string('ward_id');
            $table->unsignedBigInteger('lga_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    Schema::table('polling_units', function (Blueprint $table){
        $table->foreign('lga_id')->references('id')->on('lgas');
        $table->foreign('state_id')->references('id')->on('states');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('polling_units');
    }
}
