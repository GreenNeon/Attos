<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailServisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_servis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_jasa_servis');
            $table->foreign('fk_jasa_servis')->references('id')->on('jasa_servis');
            $table->unsignedBigInteger('fk_transaksi');
            $table->foreign('fk_transaksi')->references('id')->on('transaksis');
            $table->unsignedBigInteger('fk_kendaraan');
            $table->foreign('fk_kendaraan')->references('id')->on('kendaraans');
            $table->unsignedBigInteger('fk_montir');
            $table->foreign('fk_montir')->references('id')->on('montir_kerjas');
            $table->integer('jumlah')->default(1);
            $table->double('total')->default(0);
            $table->integer('status')->default(0); // 0 antrian 1 dikerjakan 2 selesai
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
        Schema::dropIfExists('detail_servis');
    }
}
