<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    public function index()
    {
        $today = Carbon::today('Asia/Jakarta')->toDateString();
        $nowTime = Carbon::now('Asia/Jakarta')->toTimeString();

        // Find the first scheduled/inputted cremation of today (ordered by jam_awal)
        $firstJadwalToday = Jadwal::join('laporan', 'jadwal.id_jadwal', '=', 'laporan.id_jadwal')
            ->whereDate('jadwal.date', $today)
            ->orderBy('laporan.jam_awal', 'asc')
            ->select('jadwal.id_jadwal')
            ->first();
        $firstJadwalId = $firstJadwalToday ? $firstJadwalToday->id_jadwal : null;

        // Get all active machines/rooms
        $ruangans = \App\Models\Ruangan::all();
        $activeJadwals = collect();

        foreach ($ruangans as $ruangan) {
            // Find all candidate uncompleted schedules for today on this machine that have started
            $candidates = Jadwal::with(['picture', 'pelanggan', 'ruangan', 'laporan'])
                ->join('laporan', 'jadwal.id_jadwal', '=', 'laporan.id_jadwal')
                ->whereDate('jadwal.date', $today)
                ->where('jadwal.ruangan_id', $ruangan->id)
                ->whereNull('laporan.lama_pembakaran')
                ->where('laporan.jam_awal', '<=', $nowTime)
                ->where(function ($q) {
                    $q->whereDoesntHave('picture')
                      ->orWhereHas('picture', function ($q2) {
                          $q2->whereNull('foto_abu');
                      });
                })
                ->orderBy('laporan.jam_awal', 'asc')
                ->select('jadwal.*')
                ->get();

            // Filter candidates based on display limit (3.5h for first, 2.5h for subsequent)
            $activeForRuangan = $candidates->filter(function ($j) use ($firstJadwalId) {
                $isFirst = ($j->id_jadwal === $firstJadwalId);
                $durationHours = $isFirst ? 3.5 : 2.5;
                
                $jamAwal = Carbon::parse($j->laporan->jam_awal, 'Asia/Jakarta');
                $limitTime = $jamAwal->copy()->addMinutes($durationHours * 60);
                
                $now = Carbon::now('Asia/Jakarta');
                return $now->lessThanOrEqualTo($limitTime);
            });

            $jadwal = $activeForRuangan->first();

            if ($jadwal) {
                $activeJadwals->push($jadwal);
            }
        }

        // Map additional details
        $jadwals = $activeJadwals->map(function ($jadwal) use ($firstJadwalId) {
            $jadwal->foto_jenazah_url = ($jadwal->picture && $jadwal->picture->foto_jenazah)
                ? asset('storage/' . $jadwal->picture->foto_jenazah)
                : null;
            
            $isFirst = ($jadwal->id_jadwal === $firstJadwalId);
            $durationHours = $isFirst ? 3.5 : 2.5;
            $jamAwal = Carbon::parse($jadwal->laporan->jam_awal, 'Asia/Jakarta');
            $limitTime = $jamAwal->copy()->addMinutes($durationHours * 60);
            
            // Pass formatted time and ISO raw timestamp for frontend JS countdown
            $jadwal->batas_tampilan = $limitTime->format('H:i');
            $jadwal->batas_tampilan_raw = $limitTime->toIso8601String();
            
            return $jadwal;
        });

        return view('tv_show', compact('jadwals'));
    }
}
