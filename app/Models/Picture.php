<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';
    protected $primaryKey = 'idpictures';
    public $timestamps = false;

    protected $fillable = [
        'filepath',
        'reports_idreports'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class, 'reports_idreports', 'idreports');
    }
}