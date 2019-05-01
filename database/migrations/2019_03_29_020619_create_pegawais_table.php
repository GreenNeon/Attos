<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_cabang');
            $table->foreign('fk_cabang')->references('id')->on('cabangs')->onDelete('cascade');

            $table->string('nama');
            $table->longText('alamat');
            $table->string('telepon',16);
            $table->double('gaji');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('role');
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
        Schema::dropIfExists('pegawais');
    }
}
