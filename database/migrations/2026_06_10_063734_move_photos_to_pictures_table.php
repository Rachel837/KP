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
        // 1. Add photo columns to pictures table
        Schema::table('pictures', function (Blueprint $table) {
            $table->string('foto_jenazah')->nullable();
            $table->string('foto_permohonan')->nullable();
            $table->string('foto_tiba')->nullable();
            $table->string('foto_awal')->nullable();
            $table->string('foto_akhir')->nullable();
            $table->string('foto_tulang')->nullable();
            $table->string('foto_abu')->nullable();
        });

        // 2. Migrate existing data
        $jadwals = DB::table('jadwal')->get();
        foreach ($jadwals as $jadwal) {
            // Find existing foto_jenazah path in pictures (where filepath column starts with foto_jenazah/)
            $oldFotoJenazah = DB::table('pictures')
                ->where('reports_idreports', $jadwal->idreports)
                ->where('filepath', 'like', 'foto_jenazah/%')
                ->first();

            // Create or update single pictures record per schedule
            DB::table('pictures')->updateOrInsert(
                ['reports_idreports' => $jadwal->idreports],
                [
                    'foto_jenazah' => $oldFotoJenazah ? $oldFotoJenazah->filepath : null,
                    'foto_permohonan' => $jadwal->foto_permohonan,
                    'foto_tiba' => $jadwal->foto_tiba,
                    'foto_awal' => $jadwal->foto_awal,
                    'foto_akhir' => $jadwal->foto_akhir,
                    'foto_tulang' => $jadwal->foto_tulang,
                    'foto_abu' => $jadwal->foto_abu,
                ]
            );
        }

        // Clean up old redundant rows from pictures table where filepath is not null
        DB::table('pictures')->whereNotNull('filepath')->delete();

        // 3. Drop filepath column from pictures
        Schema::table('pictures', function (Blueprint $table) {
            $table->dropColumn('filepath');
        });

        // 4. Drop photo columns from jadwal table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn([
                'foto_permohonan',
                'foto_tiba',
                'foto_awal',
                'foto_akhir',
                'foto_tulang',
                'foto_abu'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add photo columns to jadwal table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->string('foto_permohonan')->nullable();
            $table->string('foto_tiba')->nullable();
            $table->string('foto_awal')->nullable();
            $table->string('foto_akhir')->nullable();
            $table->string('foto_tulang')->nullable();
            $table->string('foto_abu')->nullable();
        });

        // Re-add filepath to pictures
        Schema::table('pictures', function (Blueprint $table) {
            $table->string('filepath')->nullable();
        });

        // Copy back
        $pictures = DB::table('pictures')->get();
        foreach ($pictures as $pic) {
            DB::table('jadwal')
                ->where('idreports', $pic->reports_idreports)
                ->update([
                    'foto_permohonan' => $pic->foto_permohonan,
                    'foto_tiba' => $pic->foto_tiba,
                    'foto_awal' => $pic->foto_awal,
                    'foto_akhir' => $pic->foto_akhir,
                    'foto_tulang' => $pic->foto_tulang,
                    'foto_abu' => $pic->foto_abu,
                ]);

            if ($pic->foto_jenazah) {
                // Insert old generic row structure back
                DB::table('pictures')->insert([
                    'reports_idreports' => $pic->reports_idreports,
                    'filepath' => $pic->foto_jenazah
                ]);
            }
        }

        // Drop new photo columns from pictures table
        Schema::table('pictures', function (Blueprint $table) {
            $table->dropColumn([
                'foto_jenazah',
                'foto_permohonan',
                'foto_tiba',
                'foto_awal',
                'foto_akhir',
                'foto_tulang',
                'foto_abu'
            ]);
        });
    }
};
