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
        try {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE report_bulanan MODIFY id INT AUTO_INCREMENT');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::statement('ALTER TABLE report_bulanan MODIFY id BIGINT AUTO_INCREMENT');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 
    }
};
