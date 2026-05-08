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

        return view('admin.koor.laporan.bulanan', compact('reports', 'ruangans', 'selected_ruangan'));
    }

    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan'])
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');
            
        return view('admin.koor.laporan.index', compact('jadwals'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('admin.koor.laporan.create', compact('ruangans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'jumlah_solar' => 'nullable|numeric',
            'lama_pembakaran' => 'nullable|string|max:100',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'umur' => 'nullable|string|max:50',
            'foto_permohonan' => 'nullable|image|max:2048',
            'foto_tiba' => 'nullable|image|max:2048',
            'foto_awal' => 'nullable|image|max:2048',
            'foto_akhir' => 'nullable|image|max:2048',
            'foto_tulang' => 'nullable|image|max:2048',
            'foto_abu' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['user_iduser'] = auth()->user()->iduser;

        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('laporan', 'public');
            }
        }

        Jadwal::create($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $laporan = Jadwal::findOrFail($id);
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('admin.koor.laporan.edit', compact('laporan', 'ruangans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'jumlah_solar' => 'nullable|numeric',
            'lama_pembakaran' => 'nullable|string|max:100',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'umur' => 'nullable|string|max:50',
            'foto_permohonan' => 'nullable|image|max:2048',
            'foto_tiba' => 'nullable|image|max:2048',
            'foto_awal' => 'nullable|image|max:2048',
            'foto_akhir' => 'nullable|image|max:2048',
            'foto_tulang' => 'nullable|image|max:2048',
            'foto_abu' => 'nullable|image|max:2048',
        ]);

        $laporan = Jadwal::findOrFail($id);
        $data = $request->all();

        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($laporan->$field && \Storage::disk('public')->exists($laporan->$field)) {
                    \Storage::disk('public')->delete($laporan->$field);
                }
                $data[$field] = $request->file($field)->store('laporan', 'public');
            }
        }

        $laporan->update($data);

        return redirect()->route('laporan.index')->with('success', 'Laporan jadwal berhasil diperbarui.');
    }

    public function show($id)
    {
        $laporan = Jadwal::with(['user', 'ruangan', 'pelanggan'])->findOrFail($id);
        return view('admin.koor.laporan.show', compact('laporan'));
    }

    public function destroy($id)
    {
        $laporan = Jadwal::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan jadwal berhasil dihapus.');
    }
}
