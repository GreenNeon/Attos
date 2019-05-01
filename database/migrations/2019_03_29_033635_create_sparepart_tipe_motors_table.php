<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartTipeMotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart_tipe_motors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_sparepart');
            $table->foreign('fk_sparepart')->references('id')->on('spareparts')->onDelete('cascade');

            $table->unsignedBigInteger('fk_jenis_motor');
            $table->foreign('fk_jenis_motor')->references('id')->on('jenis_motors')->onDelete('cascade');

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
        Schema::dropIfExists('sparepart_tipe_motors');
    }
}
