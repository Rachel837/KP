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
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_telepon_penanggung_jawab' => 'required|string|max:255',
            'tanggal_lahir_jenazah' => 'required|date',
            'tempat_lahir_jenazah' => 'required|string|max:255',
            'nama_jenazah' => 'required|string|max:255',
            'usia_jenazah' => 'required|integer|min:0',
            'alamat' => 'nullable|string|max:255',
        ]);

        // Create PelangganKremasi record
        $pelanggan = PelangganKremasi::create([
            'nama' => $request->nama_jenazah,
            'usia' => $request->usia_jenazah,
            'penannggung_jawab' => $request->nama_penanggung_jawab,
            'no_telepon' => $request->no_telepon_penanggung_jawab,
            'tanggal_lahir' => $request->tanggal_lahir_jenazah,
            'tempat_lahir' => $request->tempat_lahir_jenazah,
        ]);

        $data = $request->only(['date', 'jam_awal', 'ruangan_id', 'alamat']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;
        $data['nama_pelanggan'] = $pelanggan->nama;
        $data['umur'] = $pelanggan->usia;
        $data['user_iduser'] = auth()->user()->iduser;
        $data['waktu_tiba'] = '00:00';
        $data['jam_akhir'] = '00:00';
        $data['jumlah_solar'] = 0;
        $data['lama_pembakaran'] = null;

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
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_telepon_penanggung_jawab' => 'required|string|max:255',
            'tanggal_lahir_jenazah' => 'required|date',
            'tempat_lahir_jenazah' => 'required|string|max:255',
            'nama_jenazah' => 'required|string|max:255',
            'usia_jenazah' => 'required|integer|min:0',
            'alamat' => 'nullable|string|max:255',
            'status' => 'required|in:Terjadwal,Selesai',
        ]);

        $jadwal = Jadwal::findOrFail($id);

        // Update or create PelangganKremasi record
        $pelangganId = $jadwal->{'pelanggan kremasi_id'} ?? $jadwal->pelanggan_kremasi_id;
        $pelanggan = null;
        if ($pelangganId) {
            $pelanggan = PelangganKremasi::find($pelangganId);
        }

        if ($pelanggan) {
            $pelanggan->update([
                'nama' => $request->nama_jenazah,
                'usia' => $request->usia_jenazah,
                'penannggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir' => $request->tanggal_lahir_jenazah,
                'tempat_lahir' => $request->tempat_lahir_jenazah,
            ]);
        } else {
            $pelanggan = PelangganKremasi::create([
                'nama' => $request->nama_jenazah,
                'usia' => $request->usia_jenazah,
                'penannggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir' => $request->tanggal_lahir_jenazah,
                'tempat_lahir' => $request->tempat_lahir_jenazah,
            ]);
        }

        $data = $request->only(['date', 'jam_awal', 'ruangan_id', 'alamat']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;
        $data['nama_pelanggan'] = $pelanggan->nama;
        $data['umur'] = $pelanggan->usia;

        if ($request->status === 'Selesai') {
            // Calculate if we have jam_akhir, otherwise keep existing or set 'Selesai'
            if ($jadwal->jam_akhir && $jadwal->jam_akhir !== '00:00') {
                $jamAwal = Carbon::parse($request->jam_awal);
                $jamAkhir = Carbon::parse($jadwal->jam_akhir);
                $data['lama_pembakaran'] = $jamAwal->diffInMinutes($jamAkhir);
            } else {
                $data['lama_pembakaran'] = 'Selesai';
            }
        } else {
            $data['lama_pembakaran'] = null;
            $data['waktu_tiba'] = '00:00';
            $data['jam_akhir'] = '00:00';
            $data['jumlah_solar'] = 0;
            
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
