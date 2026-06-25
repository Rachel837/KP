<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'user_iduser',
        'ruangan_id',
        'pelanggan_kremasi_id',
        'pelanggan kremasi_id'
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
        return $this->belongsTo(PelangganKremasi::class, 'pelanggan kremasi_id', 'id');
    }

    public function getNamaPelangganAttribute()
    {
        return $this->pelanggan->nama_jenazah ?? '-';
    }

    public function getAlamatAttribute()
    {
        return $this->pelanggan->alamat_jenazah ?? '-';
    }

    public function getUmurAttribute()
    {
        return $this->pelanggan->usia_jenazah ?? null;
    }

    public function picture()
    {
        return $this->hasOne(Picture::class, 'reports_idreports', 'id_jadwal');
    }

    public function laporan()
    {
        return $this->hasOne(Laporan::class, 'id_jadwal', 'id_jadwal');
    }
}