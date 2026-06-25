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
        // 1. Drop foreign key constraints referencing idreports
        try {
            Schema::table('pictures', function (Blueprint $table) {
                $table->dropForeign(['reports_idreports']);
            });
        } catch (\Exception $e) {
            // Foreign key might not exist or have a custom name
            try {
                DB::statement('ALTER TABLE pictures DROP FOREIGN KEY fk_pictures_reports1');
            } catch (\Exception $ex) {
                // Ignore if it doesn't exist
            }
        }

        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['reports_idreports']);
            });
        } catch (\Exception $e) {
            // Ignore if it doesn't exist
        }

        // 2. Rename idreports to id_jadwal in jadwal table
        Schema::table('jadwal', function (Blueprint $table) {
            $table->renameColumn('idreports', 'id_jadwal');
        });

        // 3. Re-add foreign key constraints referencing id_jadwal
        try {
            Schema::table('pictures', function (Blueprint $table) {
                $table->foreign('reports_idreports', 'fk_pictures_reports1')
                      ->references('id_jadwal')
                      ->on('jadwal')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Ignore if already exists
        }

        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->foreign('reports_idreports')
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
        // Drop foreign keys referencing id_jadwal
        try {
            Schema::table('pictures', function (Blueprint $table) {
                $table->dropForeign(['reports_idreports']);
            });
        } catch (\Exception $e) {
            try {
                DB::statement('ALTER TABLE pictures DROP FOREIGN KEY fk_pictures_reports1');
            } catch (\Exception $ex) {
                // Ignore
            }
        }

        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['reports_idreports']);
            });
        } catch (\Exception $e) {
            // Ignore
        }

        // Rename id_jadwal to idreports
        Schema::table('jadwal', function (Blueprint $table) {
            $table->renameColumn('id_jadwal', 'idreports');
        });

        // Re-add foreign keys referencing idreports
        try {
            Schema::table('pictures', function (Blueprint $table) {
                $table->foreign('reports_idreports', 'fk_pictures_reports1')
                      ->references('idreports')
                      ->on('jadwal')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Ignore
        }

        try {
            Schema::table('laporan', function (Blueprint $table) {
                $table->foreign('reports_idreports')
                      ->references('idreports')
                      ->on('jadwal')
                      ->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Ignore
        }
    }
};
