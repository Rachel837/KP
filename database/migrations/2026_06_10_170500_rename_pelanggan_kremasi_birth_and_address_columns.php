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
        Schema::table('pelanggan kremasi', function (Blueprint $table) {
            $table->renameColumn('tanggal_lahir', 'tanggal_lahir_jenazah');
            $table->renameColumn('tempat_lahir', 'tempat_lahir_jenazah');
            $table->renameColumn('alamat', 'alamat_jenazah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan kremasi', function (Blueprint $table) {
            $table->renameColumn('tanggal_lahir_jenazah', 'tanggal_lahir');
            $table->renameColumn('tempat_lahir_jenazah', 'tempat_lahir');
            $table->renameColumn('alamat_jenazah', 'alamat');
        });
    }
};
