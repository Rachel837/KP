<?php

namespace App\Http\Controllers\Koor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function bulanan(Request $request)
    {
        $ruangans = Ruangan::all();
        $selected_ruangan = null;
        $reports = collect();

        if ($request->has('ruangan_id')) {
            $selected_ruangan = Ruangan::findOrFail($request->ruangan_id);
            $reports = Jadwal::with(['pelanggan', 'ruangan'])
                ->where('ruangan_id', $request->ruangan_id)
                ->orderBy('date', 'desc')
                ->get();
        }

        return view('users.koor.laporan.bulanan', compact('reports', 'ruangans', 'selected_ruangan'));
    }
}
