<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuestDashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $selectedDate = $request->input('date', $today);
        $searchQuery = $request->input('search');

        $query = Jadwal::with(['ruangan'])
            ->whereDate('date', $selectedDate);

        if ($searchQuery) {
            $query->where('nama_pelanggan', 'like', '%' . $searchQuery . '%');
        }

        $jadwals = $query->orderBy('jam_awal', 'asc')->get();

        return view('guest_dashboard', compact('jadwals', 'selectedDate', 'searchQuery', 'today'));
    }
}
