<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::with(['pelanggan', 'ruangan'])
            ->orderBy('date')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->date)->translatedFormat('l, d F Y');
            });

        return view('jadwal', compact('jadwal'));
    }
}