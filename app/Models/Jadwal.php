<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'idreports';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'waktu_tiba',
        'jam_awal',
        'jam_akhir',
        'jumlah_solar',
        'jam_meninggal',
        'tanggal_meninggal',
        'user_iduser',
        'pemakaian_listrik',
        'ruangan_id',
        'pelanggan_kremasi_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_iduser', 'iduser');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(PelangganKremasi::class, 'pelanggan_kremasi_id', 'id');
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class, 'reports_idreports', 'idreports');
    }
}