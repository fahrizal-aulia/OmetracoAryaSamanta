<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
    
    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->date('deadline')->nullable(); // bisa nullable untuk jaga-jaga rollback
        });
    }
    
};
