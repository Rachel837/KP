<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop table if it exists from a previous failed run
        Schema::dropIfExists('laporan');

        // 1. Create the laporan table
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->integer('reports_idreports');
            $table->time('waktu_tiba')->nullable();
            $table->time('jam_awal')->nullable();
            $table->time('jam_akhir')->nullable();
            $table->float('jumlah_solar')->nullable();
            $table->string('lama_pembakaran')->nullable();

            $table->foreign('reports_idreports')->references('idreports')->on('jadwal')->onDelete('cascade');
        });

        // 2. Migrate existing values
        $jadwals = DB::table('jadwal')->get();
        foreach ($jadwals as $jadwal) {
            DB::table('laporan')->insert([
                'reports_idreports' => $jadwal->idreports,
                'waktu_tiba' => $jadwal->waktu_tiba ?? null,
                'jam_awal' => $jadwal->jam_awal ?? null,
                'jam_akhir' => $jadwal->jam_akhir ?? null,
                'jumlah_solar' => $jadwal->jumlah_solar ?? null,
                'lama_pembakaran' => $jadwal->lama_pembakaran ?? null,
            ]);
        }

        // 3. Drop columns from jadwal table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn([
                'waktu_tiba',
                'jam_awal',
                'jam_akhir',
                'jumlah_solar',
                'lama_pembakaran',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Re-add columns to jadwal table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->time('waktu_tiba')->nullable();
            $table->time('jam_awal')->nullable();
            $table->time('jam_akhir')->nullable();
            $table->float('jumlah_solar')->nullable();
            $table->string('lama_pembakaran')->nullable();
        });

        // 2. Copy back values from laporan to jadwal
        $laporans = DB::table('laporan')->get();
        foreach ($laporans as $lap) {
            DB::table('jadwal')
                ->where('idreports', $lap->reports_idreports)
                ->update([
                    'waktu_tiba' => $lap->waktu_tiba,
                    'jam_awal' => $lap->jam_awal,
                    'jam_akhir' => $lap->jam_akhir,
                    'jumlah_solar' => $lap->jumlah_solar,
                    'lama_pembakaran' => $lap->lama_pembakaran,
                ]);
        }

        // 3. Drop laporan table
        Schema::dropIfExists('laporan');
    }
};
