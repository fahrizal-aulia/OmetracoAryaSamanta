<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('penyewaans', function (Blueprint $table) {
        $table->string('nama_alat')->nullable();
        $table->time('mulai_jam')->nullable();
        $table->time('selesai_jam')->nullable();
        $table->decimal('total_jam_kerja', 5, 2)->nullable();
        $table->integer('jumlah_alat')->nullable();
        $table->string('satuan')->nullable(); // unit atau m3
        $table->decimal('volume_docket', 8, 2)->nullable();
        $table->decimal('kumulatif', 8, 2)->nullable();
    });
}

public function down()
{
    Schema::table('penyewaans', function (Blueprint $table) {
        $table->dropColumn([
            'nama_alat', 'mulai_jam', 'selesai_jam', 'total_jam_kerja',
            'jumlah_alat', 'satuan', 'volume_docket', 'kumulatif'
        ]);
    });
}

};
