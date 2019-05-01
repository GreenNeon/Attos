<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMontirKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('montir_kerjas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_pegawai');
            $table->foreign('fk_pegawai')->references('id')->on('pegawais');
            $table->unsignedBigInteger('fk_kendaraan');
            $table->foreign('fk_kendaraan')->references('id')->on('kendaraans');
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
        Schema::dropIfExists('montir_kerjas');
    }
}
