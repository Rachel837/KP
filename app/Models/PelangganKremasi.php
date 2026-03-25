<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganKremasi extends Model
{
    protected $table = 'pelanggan_kremasi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'usia',
        'penanggung_jawab',
        'no_telepon',
        'tanggal_lahir',
        'tempat_lahir',
        'berat_badan'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'pelanggan_kremasi_id', 'id');
    }
}