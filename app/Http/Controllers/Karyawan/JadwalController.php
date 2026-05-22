<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan'])
            ->orderBy('date', 'desc')
            ->get();
            
        return view('users.karyawan.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('users.karyawan.jadwal.create', compact('ruangans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'jam_awal' => 'required',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'umur' => 'nullable|string|max:50',
        ]);

        $data = $request->all();
        $data['user_iduser'] = auth()->user()->iduser;
        
        // Assign default values for required DB columns not in the simplified form
        $data['waktu_tiba'] = '00:00';
        $data['jam_akhir'] = '00:00';
        $data['jumlah_solar'] = 0;

        Jadwal::create($data);

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['user', 'ruangan', 'pelanggan'])->findOrFail($id);
        return view('users.karyawan.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('users.karyawan.jadwal.edit', compact('jadwal', 'ruangans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'jam_awal' => 'required',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'umur' => 'nullable|string|max:50',
            'status' => 'required|in:Terjadwal,Selesai',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $data = $request->only(['date', 'jam_awal', 'ruangan_id', 'nama_pelanggan', 'alamat', 'umur']);

        if ($request->status === 'Selesai') {
            if (empty($jadwal->lama_pembakaran)) {
                $data['lama_pembakaran'] = 'Selesai';
            }
        } else {
            $data['lama_pembakaran'] = null;
            
            // Clean up old photo files if reverting status to Terjadwal
            $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
            foreach ($photoFields as $field) {
                if ($jadwal->$field && Storage::disk('public')->exists($jadwal->$field)) {
                    Storage::disk('public')->delete($jadwal->$field);
                }
                $data[$field] = null;
            }
        }

        $jadwal->update($data);

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        // Cleanup photos on delete
        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        foreach ($photoFields as $field) {
            if ($jadwal->$field && Storage::disk('public')->exists($jadwal->$field)) {
                Storage::disk('public')->delete($jadwal->$field);
            }
        }

        $jadwal->delete();

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
