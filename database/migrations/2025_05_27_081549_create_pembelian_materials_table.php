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
    Schema::create('pembelian_materials', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proyek_id')->constrained('proyeks')->onDelete('cascade');
        $table->string('lokasi');
        $table->date('tanggal_permintaan');
        $table->enum('status', ['Menunggu', 'Disetujui'])->default('Menunggu');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_materials');
    }
};
