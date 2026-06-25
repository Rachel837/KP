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
            if (!Schema::hasColumn('report_bulanan', 'rata_rata_pemakaian_solar')) {
                $table->decimal('rata_rata_pemakaian_solar', 10, 2)->default(0)->after('total_biaya');
            }
            if (!Schema::hasColumn('report_bulanan', 'rata_rata_pemakaian_listrik')) {
                $table->decimal('rata_rata_pemakaian_listrik', 10, 2)->default(0)->after('rata_rata_pemakaian_solar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_bulanan', function (Blueprint $table) {
            $table->dropColumn(['rata_rata_pemakaian_solar', 'rata_rata_pemakaian_listrik']);
        });
    }
};
