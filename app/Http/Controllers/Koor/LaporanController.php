<?php

namespace App\Http\Controllers\Koor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\ReportBulanan;
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
        $summary = collect();

        if ($request->has('ruangan_id')) {
            $selected_ruangan = Ruangan::findOrFail($request->ruangan_id);
            // Filter berdasarkan bulan dan tahun jika ada
            $filterMonth = $request->input('bulan');
            $filterYear = $request->input('tahun');

            $reportsQuery = Jadwal::with(['pelanggan', 'ruangan', 'laporan'])
                ->where('ruangan_id', $request->ruangan_id)
                ->whereNotNull('id_jadwal')
                ->whereHas('laporan');

            if ($filterMonth && $filterYear) {
                $reportsQuery->whereMonth('date', $filterMonth)
                             ->whereYear('date', $filterYear);
            }

            $reports = $reportsQuery->orderBy('date', 'desc')->get();

            // Kalkulasi per bulan
            $monthlyData = [];
            foreach ($reports as $report) {
                if ($report->date && $report->laporan) {
                    $date = Carbon::parse($report->date);
                    $month = $date->month;
                    $year = $date->year;
                    $key = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);

                    if (!isset($monthlyData[$key])) {
                        $monthlyData[$key] = [
                            'bulan' => $month,
                            'tahun' => $year,
                            'total_solar' => 0,
                            'total_listrik' => 0,
                            'count' => 0
                        ];
                    }
                    $monthlyData[$key]['total_solar'] += (float) ($report->laporan->jumlah_solar ?? 0);
                    $monthlyData[$key]['total_listrik'] += (float) ($report->laporan->pemakaian_listrik ?? 0);
                    $monthlyData[$key]['count']++;
                }
            }

            // Simpan atau update ke tabel report_bulanan
            foreach ($monthlyData as $data) {
                $biayaSolar = $data['total_solar'] * 14150;
                $biayaListrik = $data['total_listrik'] * 1500;
                $totalBiaya = $biayaSolar + $biayaListrik;
                $avgSolar = $data['count'] > 0 ? $data['total_solar'] / $data['count'] : 0;
                $avgListrik = $data['count'] > 0 ? $data['total_listrik'] / $data['count'] : 0;

                ReportBulanan::updateOrCreate(
                    [
                        'ruangan_id' => $selected_ruangan->id,
                        'bulan' => $data['bulan'],
                        'tahun' => $data['tahun']
                    ],
                    [
                        'total_pemakaian_solar' => $data['total_solar'],
                        'total_pemakaian_listrik' => $data['total_listrik'],
                        'biaya_solar' => $biayaSolar,
                        'biaya_listrik' => $biayaListrik,
                        'total_biaya' => $totalBiaya,
                        'rata_rata_pemakaian_solar' => $avgSolar,
                        'rata_rata_pemakaian_listrik' => $avgListrik
                    ]
                );
            }

            // Ambil summary dari report_bulanan untuk ditampilkan
            $summaryQuery = ReportBulanan::where('ruangan_id', $selected_ruangan->id);
            if ($filterMonth && $filterYear) {
                $summaryQuery->where('bulan', $filterMonth)->where('tahun', $filterYear);
            }
            $summary = $summaryQuery->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();
            
            // Ambil daftar tahun yang ada di database untuk filter dropdown
            $availableYears = ReportBulanan::where('ruangan_id', $selected_ruangan->id)
                ->select('tahun')
                ->distinct()
                ->orderBy('tahun', 'desc')
                ->pluck('tahun');

            // Kita juga perlu me-refresh query utama jika ingin urut sesuai id_jadwal di view
            $reportsQuery2 = Jadwal::with(['pelanggan', 'ruangan', 'laporan'])
                ->where('ruangan_id', $request->ruangan_id)
                ->whereNotNull('id_jadwal')
                ->whereHas('laporan');
            if ($filterMonth && $filterYear) {
                $reportsQuery2->whereMonth('date', $filterMonth)->whereYear('date', $filterYear);
            }
            $reports = $reportsQuery2->orderBy('id_jadwal', 'desc')->get();
        } else {
            $availableYears = collect();
        }

        return view('users.koor.laporan.bulanan', compact('reports', 'ruangans', 'selected_ruangan', 'summary', 'availableYears'));
    }
}
