<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_pemesanan');
            $table->foreign('fk_pemesanan')->references('id')->on('pemesanans');
            $table->unsignedBigInteger('fk_sparepart');
            $table->foreign('fk_sparepart')->references('id')->on('spareparts');
            $table->string('nama')->nullable();
            $table->integer('jumlah');
            $table->double('total');
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
        Schema::dropIfExists('detail_pemesanans');
    }
}
