<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManajemenTempatParkirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manajemen_tempat_parkir', function (Blueprint $table) {
            $table->bigIncrements('idMTP');
            $table->bigInteger('idTempatParkir');
            $table->bigInteger('idUser');
            $table->smallInteger('mode');
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
        Schema::dropIfExists('manajemen_tempat_parkir');
    }
}
