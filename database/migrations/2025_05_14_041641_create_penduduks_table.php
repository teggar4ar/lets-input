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
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alamats_id')->constrained();
            $table->string('no_kk', 16);
            $table->string('nik', 16)->unique();
            $table->string('nama', 255);
            $table->enum('jk', ['laki-laki', 'perempuan']);
            $table->string('tmp_lahir', 100);
            $table->date('tgl_lahir');
            $table->foreignId('agamas_id')->constrained();
            $table->foreignId('pendidikans_id')->constrained();
            $table->foreignId('pendidikan_sedangs_id')->nullable()->constrained();
            $table->foreignId('pekerjaans_id')->constrained();
            $table->foreignId('stat_kawins_id')->constrained();
            $table->foreignId('stat_hub_keluargas_id')->constrained();
            $table->enum('kewarganegaraan', ['wni', 'wna', 'dua kewarganegaraan'])->default('wni');
            $table->string('ayah_nik', 16)->nullable();
            $table->boolean('jamkesnas')->nullable();
            $table->string('ayah_nama', 255)->nullable();
            $table->string('ibu_nik', 16)->nullable();
            $table->string('ibu_nama', 255)->nullable();
            $table->foreignId('gol_darahs_id')->nullable()->constrained();
            $table->date('akta_lahir')->nullable();
            $table->string('dok_passport', 20)->nullable();
            $table->date('tgl_akhir_passport')->nullable();
            $table->string('dok_kitas', 20)->nullable();
            $table->string('akta_perkawinan', 20)->nullable();
            $table->date('tgl_perkawinan')->nullable();
            $table->string('akta_perceraian', 20)->nullable();
            $table->date('tgl_perceraian')->nullable();
            $table->foreignId('cacats_id')->nullable()->constrained();
            $table->foreignId('cara_kbs_id')->nullable()->constrained();
            $table->boolean('hamil')->default(false);
            $table->boolean('ktp_el')->default(false);
            $table->foreignId('stat_rekams_id')->nullable()->constrained();
            $table->foreignId('stat_dasars_id')->constrained();
            $table->string('suku', 100)->nullable();
            $table->string('tag_id_card', 15)->nullable();
            $table->foreignId('asuransis_id')->nullable()->constrained('asuransis');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};
