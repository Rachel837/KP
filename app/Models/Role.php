<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'idrole';
    public $timestamps = false;

    protected $fillable = [
        'nama'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_idrole', 'idrole');
    }
}