<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';
    protected $primaryKey = 'idpictures';
    public $timestamps = false;

    protected $fillable = [
        'reports_idreports',
        'foto_jenazah',
        'foto_permohonan',
        'foto_tiba',
        'foto_awal',
        'foto_akhir',
        'foto_tulang',
        'foto_abu'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'reports_idreports', 'id_jadwal');
    }
}