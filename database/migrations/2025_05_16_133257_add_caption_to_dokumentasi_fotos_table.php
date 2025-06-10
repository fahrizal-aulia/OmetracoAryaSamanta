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
    Schema::table('dokumentasi_fotos', function (Blueprint $table) {
        $table->string('caption')->nullable()->after('file_path');
    });
}

public function down()
{
    Schema::table('dokumentasi_fotos', function (Blueprint $table) {
        $table->dropColumn('caption');
    });
}

};
