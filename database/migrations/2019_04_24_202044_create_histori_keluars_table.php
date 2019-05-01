<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histori_keluars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_detail_sparepart');
            $table->foreign('fk_detail_sparepart')->references('id')->on('detail_spareparts');
            $table->unsignedBigInteger('fk_sparepart')->nullable();
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
        Schema::dropIfExists('histori_keluars');
    }
}
