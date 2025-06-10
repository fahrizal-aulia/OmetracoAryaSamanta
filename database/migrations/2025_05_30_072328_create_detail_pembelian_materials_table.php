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
    Schema::create('detail_pembelian_materials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembelian_id')->constrained('pembelians')->onDelete('cascade');
        $table->string('nama_material');
        $table->string('satuan');
        $table->string('status')->nullable();
        $table->integer('jumlah')->nullable();
        $table->decimal('panjang', 8, 2)->nullable();
        $table->decimal('lebar', 8, 2)->nullable();
        $table->decimal('tinggi', 8, 2)->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian_materials');
    }
};
