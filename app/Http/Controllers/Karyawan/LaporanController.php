<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use App\Models\Picture;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan'])
            ->orderBy('date', 'desc')
            ->get()
            ->groupBy('date');
            
        return view('users.karyawan.laporan.index', compact('jadwals'));
    }

    public function create(Request $request)
    {
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        
        // Fetch schedules that are not yet reported (still Terjadwal)
        $jadwals = Jadwal::whereNull('lama_pembakaran')
            ->whereNull('foto_abu')
            ->orderBy('date', 'desc')
            ->get();

        $selectedJadwal = null;
        if ($request->filled('jadwal_id')) {
            $selectedJadwal = Jadwal::find($request->jadwal_id);
        }
            
        return view('users.karyawan.laporan.create', compact('ruangans', 'pelanggans', 'jadwals', 'selectedJadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'nullable|exists:jadwal,idreports',
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'jumlah_solar' => 'required|numeric|min:0',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_telepon_penanggung_jawab' => 'required|string|max:255',
            'tanggal_lahir_jenazah' => 'required|date',
            'tempat_lahir_jenazah' => 'required|string|max:255',
            'nama_jenazah' => 'required|string|max:255',
            'usia_jenazah' => 'required|integer|min:0',
            'alamat' => 'nullable|string|max:255',
            'foto_permohonan' => 'nullable|image|max:2048',
            'foto_tiba' => 'nullable|image|max:2048',
            'foto_awal' => 'nullable|image|max:2048',
            'foto_akhir' => 'nullable|image|max:2048',
            'foto_tulang' => 'nullable|image|max:2048',
            'foto_abu' => 'nullable|image|max:2048',
        ]);

        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];

        if ($request->filled('jadwal_id')) {
            $laporan = Jadwal::findOrFail($request->jadwal_id);

            // Update or create PelangganKremasi record
            $pelangganId = $laporan->{'pelanggan kremasi_id'} ?? $laporan->pelanggan_kremasi_id;
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

            // Calculate lama_pembakaran (jam_akhir - jam_awal in minutes)
            $jamAwal = Carbon::parse($request->jam_awal);
            $jamAkhir = Carbon::parse($request->jam_akhir);
            $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

            $data = $request->only(['date', 'waktu_tiba', 'jam_awal', 'jam_akhir', 'jumlah_solar', 'ruangan_id', 'alamat']);
            $data['pelanggan kremasi_id'] = $pelanggan->id;
            $data['nama_pelanggan'] = $pelanggan->nama;
            $data['umur'] = $pelanggan->usia;
            $data['lama_pembakaran'] = $diffInMinutes;

            foreach ($photoFields as $field) {
                if ($request->hasFile($field)) {
                    if ($laporan->$field) {
                        if (Storage::disk('public')->exists($laporan->$field)) {
                            Storage::disk('public')->delete($laporan->$field);
                        }
                        Picture::where('filepath', $laporan->$field)
                            ->where('reports_idreports', $laporan->idreports)
                            ->delete();
                    }
                    $storedPath = $request->file($field)->store('laporan', 'public');
                    $data[$field] = $storedPath;

                    Picture::create([
                        'filepath' => $storedPath,
                        'reports_idreports' => $laporan->idreports,
                    ]);
                }
            }

            $laporan->update($data);
        } else {
            // Manual input / new schedule created from reports
            $pelanggan = PelangganKremasi::create([
                'nama' => $request->nama_jenazah,
                'usia' => $request->usia_jenazah,
                'penannggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir' => $request->tanggal_lahir_jenazah,
                'tempat_lahir' => $request->tempat_lahir_jenazah,
            ]);

            // Calculate lama_pembakaran
            $jamAwal = Carbon::parse($request->jam_awal);
            $jamAkhir = Carbon::parse($request->jam_akhir);
            $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

            $data = $request->only(['date', 'waktu_tiba', 'jam_awal', 'jam_akhir', 'jumlah_solar', 'ruangan_id', 'alamat']);
            $data['pelanggan kremasi_id'] = $pelanggan->id;
            $data['nama_pelanggan'] = $pelanggan->nama;
            $data['umur'] = $pelanggan->usia;
            $data['lama_pembakaran'] = $diffInMinutes;
            $data['user_iduser'] = auth()->user()->iduser;

            foreach ($photoFields as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('laporan', 'public');
                }
            }

            $laporan = Jadwal::create($data);

            // Store uploaded photos to pictures table
            foreach ($photoFields as $field) {
                if (isset($data[$field])) {
                    Picture::create([
                        'filepath' => $data[$field],
                        'reports_idreports' => $laporan->idreports,
                    ]);
                }
            }
        }

        return redirect()->route('karyawan.laporan.index')->with('success', 'Laporan jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $laporan = Jadwal::findOrFail($id);
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('users.karyawan.laporan.edit', compact('laporan', 'ruangans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => 'required',
            'jam_akhir' => 'required',
            'jumlah_solar' => 'nullable|numeric|min:0',
            'ruangan_id' => 'required|exists:ruangan,id',
            'nama_penanggung_jawab' => 'required|string|max:255',
            'no_telepon_penanggung_jawab' => 'required|string|max:255',
            'tanggal_lahir_jenazah' => 'required|date',
            'tempat_lahir_jenazah' => 'required|string|max:255',
            'nama_jenazah' => 'required|string|max:255',
            'usia_jenazah' => 'required|integer|min:0',
            'alamat' => 'nullable|string|max:255',
            'foto_permohonan' => 'nullable|image|max:2048',
            'foto_tiba' => 'nullable|image|max:2048',
            'foto_awal' => 'nullable|image|max:2048',
            'foto_akhir' => 'nullable|image|max:2048',
            'foto_tulang' => 'nullable|image|max:2048',
            'foto_abu' => 'nullable|image|max:2048',
        ]);

        $laporan = Jadwal::findOrFail($id);

        // Update or create PelangganKremasi record
        $pelangganId = $laporan->{'pelanggan kremasi_id'} ?? $laporan->pelanggan_kremasi_id;
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

        // Calculate lama_pembakaran (jam_akhir - jam_awal in minutes)
        $jamAwal = Carbon::parse($request->jam_awal);
        $jamAkhir = Carbon::parse($request->jam_akhir);
        $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

        $data = $request->only(['date', 'waktu_tiba', 'jam_awal', 'jam_akhir', 'jumlah_solar', 'ruangan_id', 'alamat']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;
        $data['nama_pelanggan'] = $pelanggan->nama;
        $data['umur'] = $pelanggan->usia;
        $data['lama_pembakaran'] = $diffInMinutes;

        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file and old picture record if exists
                if ($laporan->$field) {
                    if (Storage::disk('public')->exists($laporan->$field)) {
                        Storage::disk('public')->delete($laporan->$field);
                    }
                    Picture::where('filepath', $laporan->$field)
                        ->where('reports_idreports', $laporan->idreports)
                        ->delete();
                }
                $storedPath = $request->file($field)->store('laporan', 'public');
                $data[$field] = $storedPath;

                Picture::create([
                    'filepath' => $storedPath,
                    'reports_idreports' => $laporan->idreports,
                ]);
            }
        }

        $laporan->update($data);

        return redirect()->route('karyawan.laporan.index')->with('success', 'Laporan jadwal berhasil diperbarui.');
    }

    public function show($id)
    {
        $laporan = Jadwal::with(['user', 'ruangan', 'pelanggan'])->findOrFail($id);
        return view('users.karyawan.laporan.show', compact('laporan'));
    }

    public function destroy($id)
    {
        $laporan = Jadwal::findOrFail($id);

        // Cleanup photos on delete
        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        foreach ($photoFields as $field) {
            if ($laporan->$field && Storage::disk('public')->exists($laporan->$field)) {
                Storage::disk('public')->delete($laporan->$field);
            }
        }

        // Cleanup picture records
        Picture::where('reports_idreports', $id)->delete();

        $laporan->delete();

        return redirect()->route('karyawan.laporan.index')->with('success', 'Laporan jadwal berhasil dihapus.');
    }
}
