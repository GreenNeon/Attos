<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaiKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_kerjas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_pegawai');
            $table->foreign('fk_pegawai')->references('id')->on('pegawais');
            $table->unsignedBigInteger('fk_transaksi');
            $table->foreign('fk_transaksi')->references('id')->on('transaksis');
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
        Schema::dropIfExists('pegawai_kerjas');
    }
}
