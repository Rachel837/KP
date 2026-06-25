<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Melihat jadwal kremasi selama 1 minggu ke depan
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(7)->endOfDay();
        
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan', 'picture', 'laporan'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('id_jadwal', 'desc')
            ->get();
            
        return view('users.karyawan.dashboard', compact('jadwals', 'startDate', 'endDate'));
    }
}
