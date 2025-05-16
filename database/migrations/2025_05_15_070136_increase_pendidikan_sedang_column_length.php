<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pendidikan_sedangs', function (Blueprint $table) {
            $table->string('nama_pendidikan_sedangs', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendidikan_sedangs', function (Blueprint $table) {
            $table->string('nama_pendidikan_sedangs', 100)->change();
        });
    }
};
