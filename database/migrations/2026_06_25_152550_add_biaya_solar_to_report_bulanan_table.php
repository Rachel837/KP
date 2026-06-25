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
        Schema::table('report_bulanan', function (Blueprint $table) {
            if (!Schema::hasColumn('report_bulanan', 'biaya_solar')) {
                $table->decimal('biaya_solar', 15, 2)->default(0)->after('total_pemakaian_listrik');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_bulanan', function (Blueprint $table) {
            $table->dropColumn('biaya_solar');
        });
    }
};
