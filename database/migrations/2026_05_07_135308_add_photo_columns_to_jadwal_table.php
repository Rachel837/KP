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
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('foto_permohonan')->nullable();
            $table->string('foto_tiba')->nullable();
            $table->string('foto_awal')->nullable();
            $table->string('foto_akhir')->nullable();
            $table->string('foto_tulang')->nullable();
            $table->string('foto_abu')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu']);
        });
    }
};
