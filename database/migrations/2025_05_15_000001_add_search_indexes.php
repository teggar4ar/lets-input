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
        Schema::table('penduduks', function (Blueprint $table) {
            // Add index for search fields
            $table->index('nama');
            $table->index('no_kk');
            // NIK is already unique, which implies an index
        });

        Schema::table('alamats', function (Blueprint $table) {
            // Add index for filter field
            $table->index('dusun');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            $table->dropIndex(['nama']);
            $table->dropIndex(['no_kk']);
        });

        Schema::table('alamats', function (Blueprint $table) {
            $table->dropIndex(['dusun']);
        });
    }
};
