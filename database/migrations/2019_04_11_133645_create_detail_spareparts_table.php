<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_spareparts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_transaksi');
            $table->unsignedBigInteger('fk_montir')->nullable();
            $table->foreign('fk_transaksi')->references('id')->on('transaksis');
            $table->unsignedBigInteger('fk_sparepart');
            $table->foreign('fk_sparepart')->references('id')->on('spareparts');
            $table->foreign('fk_montir')->references('id')->on('pegawai_kerjas')->onDelete('set null');
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
        Schema::dropIfExists('detail_spareparts');
    }
}
