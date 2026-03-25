<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nama'
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'ruangan_id', 'id');
    }
}