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
        // 1. Drop the foreign key on laporan referencing jadwal(id_jadwal)
        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['reports_idreports']);
            });
        } catch (\Exception $e) {
            // Ignore if it doesn't exist
        }

        // 2. Rename reports_idreports to id_jadwal
        Schema::table('laporan', function (Blueprint $table) {
            $table->renameColumn('reports_idreports', 'id_jadwal');
        });

        // 3. Re-add foreign key referencing id_jadwal in jadwal table
        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->foreign('id_jadwal')
                      ->references('id_jadwal')
                      ->on('jadwal')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Ignore if already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key referencing id_jadwal
        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['id_jadwal']);
            });
        } catch (\Exception $e) {
            // Ignore
        }

        // Rename id_jadwal back to reports_idreports
        Schema::table('laporan', function (Blueprint $table) {
            $table->renameColumn('id_jadwal', 'reports_idreports');
        });

        // Re-add foreign key referencing id_jadwal (which is now reports_idreports again)
        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->foreign('reports_idreports')
                      ->references('id_jadwal')
                      ->on('jadwal')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Ignore
        }
    }
};
