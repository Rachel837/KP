<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $jadwals = Jadwal::with(['ruangan', 'picture', 'pelanggan', 'laporan'])
            ->join('laporan', 'jadwal.id_jadwal', '=', 'laporan.id_jadwal')
            ->whereDate('jadwal.date', $today)
            ->orderBy('laporan.jam_awal', 'desc')
            ->select('jadwal.*')
            ->get();

        return view('guest_dashboard', compact('jadwals', 'today'));
    }
}
