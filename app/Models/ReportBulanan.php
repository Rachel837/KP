<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportBulanan extends Model
{
    protected $table = 'report_bulanan';
    protected $primaryKey = 'id';
    
    public $timestamps = false;

    protected $fillable = [
        'ruangan_id',
        'bulan',
        'tahun',
        'total_pemakaian_solar',
        'total_pemakaian_listrik',
        'biaya_solar',
        'biaya_listrik',
        'total_biaya',
        'rata_rata_pemakaian_solar',
        'rata_rata_pemakaian_listrik'
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }
}
