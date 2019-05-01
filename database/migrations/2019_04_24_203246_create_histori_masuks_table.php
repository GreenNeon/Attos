<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_pemesanan');
            $table->foreign('fk_pemesanan')->references('id')->on('pemesanans');
            $table->unsignedBigInteger('fk_sparepart');
            $table->foreign('fk_sparepart')->references('id')->on('spareparts');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->double('total')->default(0);
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
        Schema::dropIfExists('histori_masuks');
    }
}
