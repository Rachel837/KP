<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_jadwal',
        'waktu_tiba',
        'jam_awal',
        'jam_akhir',
        'jumlah_solar',
        'lama_pembakaran'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'id_jadwal', 'id_jadwal');
    }
}
