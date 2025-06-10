<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPembelianMaterialsTable extends Migration
{
    public function up()
    {
        Schema::table('pembelian_materials', function (Blueprint $table) {
            $table->string('nama_material')->nullable();
            $table->integer('jumlah')->nullable(); // untuk satuan biasa
            $table->decimal('panjang', 8, 2)->nullable(); // untuk satuan meter
            $table->decimal('lebar', 8, 2)->nullable();
            $table->decimal('tinggi', 8, 2)->nullable();
            $table->string('satuan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pembelian_materials', function (Blueprint $table) {
            $table->dropColumn(['nama_material', 'jumlah', 'panjang', 'lebar', 'tinggi', 'satuan', 'status']);
        });
    }
}
