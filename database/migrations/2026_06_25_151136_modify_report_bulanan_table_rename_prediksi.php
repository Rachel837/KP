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
            if (Schema::hasColumn('report_bulanan', 'prediksi')) {
                $table->renameColumn('prediksi', 'total_pemakaian_solar');
            } elseif (!Schema::hasColumn('report_bulanan', 'total_pemakaian_solar')) {
                $table->decimal('total_pemakaian_solar', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('report_bulanan', 'ruangan_id')) {
                $table->unsignedBigInteger('ruangan_id')->nullable();
            }

            if (!Schema::hasColumn('report_bulanan', 'bulan')) {
                $table->integer('bulan')->nullable();
            }

            if (!Schema::hasColumn('report_bulanan', 'tahun')) {
                $table->integer('tahun')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_bulanan', function (Blueprint $table) {
            if (Schema::hasColumn('report_bulanan', 'total_pemakaian_solar')) {
                $table->renameColumn('total_pemakaian_solar', 'prediksi');
            }
        });
    }
};
