<?php

namespace App\Http\Controllers\Koor;

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
        
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc')
            ->get();
            
        return view('admin.koor.dashboard', compact('jadwals', 'startDate', 'endDate'));
    }
}
