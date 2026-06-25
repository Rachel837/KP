<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelangganKremasi extends Model
{
    protected $table = 'pelanggan kremasi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama_jenazah',
        'usia_jenazah',
        'penanggung_jawab',
        'no_telepon',
        'tanggal_lahir_jenazah',
        'tempat_lahir_jenazah',
        'berat_badan',
        'alamat_jenazah'
    ];

    public function getTanggalLahirAttribute()
    {
        return $this->tanggal_lahir_jenazah;
    }

    public function getTempatLahirAttribute()
    {
        return $this->tempat_lahir_jenazah;
    }

    public function getAlamatAttribute()
    {
        return $this->alamat_jenazah;
    }

    public function getNamaAttribute()
    {
        return $this->nama_jenazah;
    }

    public function getUsiaAttribute()
    {
        return $this->usia_jenazah;
    }

    public function getPenannggungJawabAttribute()
    {
        return $this->penanggung_jawab;
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'pelanggan kremasi_id', 'id');
    }
}