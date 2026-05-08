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
        'lama_pembakaran',
        'user_iduser',
        'ruangan_id',
        'pelanggan_kremasi_id',
        'nama_pelanggan',
        'alamat',
        'umur',
        'foto_permohonan',
        'foto_tiba',
        'foto_awal',
        'foto_akhir',
        'foto_tulang',
        'foto_abu'
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