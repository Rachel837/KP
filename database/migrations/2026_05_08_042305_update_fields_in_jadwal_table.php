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
        Schema::table('jadwal', function (Blueprint $table) {
            $table->dropColumn(['jam_meninggal', 'tanggal_meninggal']);
            $table->string('lama_pembakaran')->nullable()->after('jumlah_solar');
            $table->dropColumn('pemakaian_listrik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal', function (Blueprint $table) {
            $table->time('jam_meninggal')->nullable();
            $table->date('tanggal_meninggal')->nullable();
            $table->decimal('pemakaian_listrik', 10, 2)->nullable();
            $table->dropColumn('lama_pembakaran');
        });
    }
};
