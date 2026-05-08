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
        // Drop foreign key first to allow primary key modification
        try {
            DB::statement('ALTER TABLE pictures DROP FOREIGN KEY fk_pictures_reports1');
        } catch (\Exception $e) {
            // FK might not exist or name might be different in some environments
        }

        // Set idreports to AUTO_INCREMENT
        DB::statement('ALTER TABLE jadwal MODIFY idreports INT AUTO_INCREMENT');

        // Re-add foreign key
        try {
            DB::statement('ALTER TABLE pictures ADD CONSTRAINT fk_pictures_reports1 FOREIGN KEY (reports_idreports) REFERENCES jadwal(idreports)');
        } catch (\Exception $e) {
            // Re-adding failed, maybe it already exists or schema mismatch
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is tricky to reverse perfectly without more DBAL work, 
        // but we can try to remove auto_increment if needed.
        DB::statement('ALTER TABLE jadwal MODIFY idreports INT');
    }
};
