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
    Schema::create('dokumentasi_fotos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('proyek_id');
        $table->integer('minggu_ke');
        $table->text('weekly_note')->nullable();
        $table->timestamps();

        $table->foreign('proyek_id')->references('id')->on('proyeks')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_fotos');
    }
};
