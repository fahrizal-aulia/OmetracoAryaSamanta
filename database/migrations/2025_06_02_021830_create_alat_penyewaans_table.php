<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatPenyewaansTable extends Migration
{
    public function up()
    {
        Schema::create('alat_penyewaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penyewaan_id');
            $table->string('nama_alat');
            $table->time('mulai_jam');
            $table->time('selesai_jam');
            $table->float('total_jam_kerja');
            $table->integer('jumlah_alat');
            $table->string('satuan');
            $table->float('volume_docket')->nullable();
            $table->float('kumulatif')->nullable();
            $table->timestamps();

            $table->foreign('penyewaan_id')->references('id')->on('penyewaans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_penyewaans');
    }
}
