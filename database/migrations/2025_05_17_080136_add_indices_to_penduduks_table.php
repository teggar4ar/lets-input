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
            // Add indices for commonly searched and filtered columns
            $table->index('no_kk');
            $table->index('nik');
            $table->index('nama');
            $table->index('jk');
            $table->index('tgl_lahir');
            $table->index('agamas_id');
            $table->index('pendidikans_id');
            $table->index('pekerjaans_id');
            $table->index('stat_kawins_id');
            $table->index('stat_hub_keluargas_id');
            $table->index('stat_dasars_id');
            $table->index('alamats_id');
            $table->index('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduks', function (Blueprint $table) {
            // Drop all indices added in the up method
            $table->dropIndex(['no_kk']);
            $table->dropIndex(['nik']);
            $table->dropIndex(['nama']);
            $table->dropIndex(['jk']);
            $table->dropIndex(['tgl_lahir']);
            $table->dropIndex(['agamas_id']);
            $table->dropIndex(['pendidikans_id']);
            $table->dropIndex(['pekerjaans_id']);
            $table->dropIndex(['stat_kawins_id']);
            $table->dropIndex(['stat_hub_keluargas_id']);
            $table->dropIndex(['stat_dasars_id']);
            $table->dropIndex(['alamats_id']);
            $table->dropIndex(['updated_at']);
        });
    }
};
