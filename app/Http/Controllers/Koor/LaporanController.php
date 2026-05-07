<?php

namespace App\Http\Controllers\Koor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan'])->orderBy('date', 'desc')->get();
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
            'jam_meninggal' => 'nullable',
            'tanggal_meninggal' => 'nullable|date',
            'pemakaian_listrik' => 'nullable|numeric',
            'ruangan_id' => 'required|exists:ruangan,id',
            'pelanggan_kremasi_id' => 'required|exists:pelanggan_kremasi,id'
        ]);

        $data = $request->all();
        $data['user_iduser'] = auth()->user()->iduser;

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
            'jam_meninggal' => 'nullable',
            'tanggal_meninggal' => 'nullable|date',
            'pemakaian_listrik' => 'nullable|numeric',
            'ruangan_id' => 'required|exists:ruangan,id',
            'pelanggan_kremasi_id' => 'required|exists:pelanggan_kremasi,id'
        ]);

        $laporan = Jadwal::findOrFail($id);
        $laporan->update($request->all());

        return redirect()->route('laporan.index')->with('success', 'Laporan jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = Jadwal::findOrFail($id);
        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan jadwal berhasil dihapus.');
    }
}
