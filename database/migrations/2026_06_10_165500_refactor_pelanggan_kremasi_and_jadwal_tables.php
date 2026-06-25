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
        // 1. Rename columns and add 'alamat' in 'pelanggan kremasi' table
        Schema::table('pelanggan kremasi', function (Blueprint $table) {
            $table->renameColumn('nama', 'nama_jenazah');
            $table->renameColumn('usia', 'usia_jenazah');
            $table->renameColumn('penannggung_jawab', 'penanggung_jawab');
            $table->string('alamat')->nullable();
        });

        // 2. Migrate existing 'alamat' values from 'jadwal' to 'pelanggan kremasi'
        $jadwals = DB::table('jadwal')->get();
        foreach ($jadwals as $jadwal) {
            $pelangganId = $jadwal->{'pelanggan kremasi_id'};
            if ($pelangganId && !empty($jadwal->alamat)) {
                DB::table('pelanggan kremasi')
                    ->where('id', $pelangganId)
                    ->update(['alamat' => $jadwal->alamat]);
            }
        }

        // 3. Drop columns on 'jadwal' table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'umur', 'nama_pelanggan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Re-add columns on 'jadwal' table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->integer('umur')->nullable();
            $table->string('nama_pelanggan')->nullable();
        });

        // 2. Migrate data back from 'pelanggan kremasi' to 'jadwal'
        $jadwals = DB::table('jadwal')->get();
        foreach ($jadwals as $jadwal) {
            $pelangganId = $jadwal->{'pelanggan kremasi_id'};
            if ($pelangganId) {
                $pelanggan = DB::table('pelanggan kremasi')->where('id', $pelangganId)->first();
                if ($pelanggan) {
                    DB::table('jadwal')
                        ->where('id_jadwal', $jadwal->id_jadwal)
                        ->update([
                            'alamat' => $pelanggan->alamat,
                            'umur' => $pelanggan->usia_jenazah,
                            'nama_pelanggan' => $pelanggan->nama_jenazah
                        ]);
                }
            }
        }

        // 3. Rename and drop columns on 'pelanggan kremasi' table
        Schema::table('pelanggan kremasi', function (Blueprint $table) {
            $table->renameColumn('nama_jenazah', 'nama');
            $table->renameColumn('usia_jenazah', 'usia');
            $table->renameColumn('penanggung_jawab', 'penannggung_jawab');
            $table->dropColumn('alamat');
        });
    }
};
