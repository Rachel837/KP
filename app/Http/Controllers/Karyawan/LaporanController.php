<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use App\Models\Picture;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{

    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan', 'laporan'])
            ->where(function($query) {
                $query->whereHas('laporan', function($q) {
                    $q->whereNotNull('lama_pembakaran')->where('lama_pembakaran', '!=', 'Selesai');
                })->orWhereHas('picture', function($q) {
                    $q->whereNotNull('foto_abu');
                });
            })
            ->orderBy('id_jadwal', 'desc')
            ->get()
            ->groupBy('date');
            
        return view('users.karyawan.laporan.index', compact('jadwals'));
    }

    public function create(Request $request)
    {
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        
        // Fetch schedules that are not yet reported but already Selesai
        $jadwals = Jadwal::whereHas('laporan', function($q) {
                $q->where('lama_pembakaran', 'Selesai');
            })
            ->where(function($query) {
                $query->whereDoesntHave('picture')
                      ->orWhereHas('picture', function($q) {
                          $q->whereNull('foto_abu');
                      });
            })
            ->orderBy('date', 'desc')
            ->get();

        $selectedJadwal = null;
        if ($request->filled('jadwal_id')) {
            $selectedJadwal = Jadwal::with('laporan')->find($request->jadwal_id);
        }
            
        return view('users.karyawan.laporan.create', compact('ruangans', 'pelanggans', 'jadwals', 'selectedJadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'nullable|exists:jadwal,id_jadwal',
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request->waktu_tiba && strtotime($value) < strtotime($request->waktu_tiba)) {
                    $fail('Jam mulai kremasi tidak boleh lebih awal dari waktu tiba.');
                }
                if ($request->jam_akhir && strtotime($value) > strtotime($request->jam_akhir)) {
                    $fail('Jam mulai kremasi tidak boleh lebih lambat dari jam selesai kremasi.');
                }
            }],
            'jam_akhir' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request->waktu_tiba && strtotime($value) < strtotime($request->waktu_tiba)) {
                    $fail('Jam selesai kremasi tidak boleh lebih awal dari waktu tiba.');
                }
                if ($request->jam_awal && strtotime($value) < strtotime($request->jam_awal)) {
                    $fail('Jam selesai kremasi tidak boleh lebih awal dari jam mulai kremasi.');
                }
            }],
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
            $jadwal = Jadwal::findOrFail($request->jadwal_id);

            // Update or create PelangganKremasi record
            $pelangganId = $jadwal->{'pelanggan kremasi_id'} ?? $jadwal->pelanggan_kremasi_id;
            $pelanggan = null;
            if ($pelangganId) {
                $pelanggan = PelangganKremasi::find($pelangganId);
            }

            if ($pelanggan) {
                $pelanggan->update([
                    'nama_jenazah' => $request->nama_jenazah,
                    'usia_jenazah' => $request->usia_jenazah,
                    'penanggung_jawab' => $request->nama_penanggung_jawab,
                    'no_telepon' => $request->no_telepon_penanggung_jawab,
                    'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
                    'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
                    'alamat_jenazah' => $request->alamat,
                ]);
            } else {
                $pelanggan = PelangganKremasi::create([
                    'nama_jenazah' => $request->nama_jenazah,
                    'usia_jenazah' => $request->usia_jenazah,
                    'penanggung_jawab' => $request->nama_penanggung_jawab,
                    'no_telepon' => $request->no_telepon_penanggung_jawab,
                    'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
                    'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
                    'alamat_jenazah' => $request->alamat,
                ]);
            }

            // Calculate lama_pembakaran (jam_akhir - jam_awal in minutes)
            $jamAwal = Carbon::parse($request->jam_awal);
            $jamAkhir = Carbon::parse($request->jam_akhir);
            $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

            $data = $request->only(['date', 'ruangan_id']);
            $data['pelanggan kremasi_id'] = $pelanggan->id;

            // Retrieve or create the Laporan record
            $laporan = Laporan::firstOrCreate(['id_jadwal' => $jadwal->id_jadwal]);
            $laporan->update([
                'waktu_tiba' => $request->waktu_tiba,
                'jam_awal' => $request->jam_awal,
                'jam_akhir' => $request->jam_akhir,
                'jumlah_solar' => $request->jumlah_solar,
                'lama_pembakaran' => $diffInMinutes,
            ]);

            $picture = Picture::firstOrCreate(['reports_idreports' => $jadwal->id_jadwal]);
            foreach ($photoFields as $field) {
                if ($request->hasFile($field)) {
                    if ($picture->$field && Storage::disk('public')->exists($picture->$field)) {
                        Storage::disk('public')->delete($picture->$field);
                    }
                    $storedPath = $request->file($field)->store('laporan', 'public');
                    $picture->$field = $storedPath;
                }
            }
            $picture->save();

            $jadwal->update($data);
        } else {
            // Manual input / new schedule created from reports
            $pelanggan = PelangganKremasi::create([
                'nama_jenazah' => $request->nama_jenazah,
                'usia_jenazah' => $request->usia_jenazah,
                'penanggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
                'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
                'alamat_jenazah' => $request->alamat,
            ]);

            // Calculate lama_pembakaran
            $jamAwal = Carbon::parse($request->jam_awal);
            $jamAkhir = Carbon::parse($request->jam_akhir);
            $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

            $data = $request->only(['date', 'ruangan_id']);
            $data['pelanggan kremasi_id'] = $pelanggan->id;
            $data['user_iduser'] = auth()->user()->iduser;

            $jadwal = Jadwal::create($data);

            // Create Laporan record
            Laporan::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'waktu_tiba' => $request->waktu_tiba,
                'jam_awal' => $request->jam_awal,
                'jam_akhir' => $request->jam_akhir,
                'jumlah_solar' => $request->jumlah_solar,
                'lama_pembakaran' => $diffInMinutes,
            ]);

            $picture = Picture::firstOrCreate(['reports_idreports' => $jadwal->id_jadwal]);
            foreach ($photoFields as $field) {
                if ($request->hasFile($field)) {
                    $storedPath = $request->file($field)->store('laporan', 'public');
                    $picture->$field = $storedPath;
                }
            }
            $picture->save();
        }

        return redirect()->route('karyawan.laporan.index')->with('success', 'Laporan jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $laporan = Jadwal::with('laporan')->findOrFail($id);
        $ruangans = Ruangan::all();
        $pelanggans = PelangganKremasi::all();
        return view('users.karyawan.laporan.edit', compact('laporan', 'ruangans', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'waktu_tiba' => 'required',
            'jam_awal' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request->waktu_tiba && strtotime($value) < strtotime($request->waktu_tiba)) {
                    $fail('Jam mulai kremasi tidak boleh lebih awal dari waktu tiba.');
                }
                if ($request->jam_akhir && strtotime($value) > strtotime($request->jam_akhir)) {
                    $fail('Jam mulai kremasi tidak boleh lebih lambat dari jam selesai kremasi.');
                }
            }],
            'jam_akhir' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request->waktu_tiba && strtotime($value) < strtotime($request->waktu_tiba)) {
                    $fail('Jam selesai kremasi tidak boleh lebih awal dari waktu tiba.');
                }
                if ($request->jam_awal && strtotime($value) < strtotime($request->jam_awal)) {
                    $fail('Jam selesai kremasi tidak boleh lebih awal dari jam mulai kremasi.');
                }
            }],
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

        $jadwal = Jadwal::findOrFail($id);

        // Update or create PelangganKremasi record
        $pelangganId = $jadwal->{'pelanggan kremasi_id'} ?? $jadwal->pelanggan_kremasi_id;
        $pelanggan = null;
        if ($pelangganId) {
            $pelanggan = PelangganKremasi::find($pelangganId);
        }

        if ($pelanggan) {
            $pelanggan->update([
                'nama_jenazah' => $request->nama_jenazah,
                'usia_jenazah' => $request->usia_jenazah,
                'penanggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
                'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
                'alamat_jenazah' => $request->alamat,
            ]);
        } else {
            $pelanggan = PelangganKremasi::create([
                'nama_jenazah' => $request->nama_jenazah,
                'usia_jenazah' => $request->usia_jenazah,
                'penanggung_jawab' => $request->nama_penanggung_jawab,
                'no_telepon' => $request->no_telepon_penanggung_jawab,
                'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
                'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
                'alamat_jenazah' => $request->alamat,
            ]);
        }

        // Calculate lama_pembakaran (jam_akhir - jam_awal in minutes)
        $jamAwal = Carbon::parse($request->jam_awal);
        $jamAkhir = Carbon::parse($request->jam_akhir);
        $diffInMinutes = $jamAwal->diffInMinutes($jamAkhir);

        $data = $request->only(['date', 'ruangan_id']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;

        // Retrieve or create the Laporan record
        $laporan = Laporan::firstOrCreate(['id_jadwal' => $jadwal->id_jadwal]);
        $laporan->update([
            'waktu_tiba' => $request->waktu_tiba,
            'jam_awal' => $request->jam_awal,
            'jam_akhir' => $request->jam_akhir,
            'jumlah_solar' => $request->jumlah_solar,
            'lama_pembakaran' => $diffInMinutes,
        ]);

        $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
        $picture = Picture::firstOrCreate(['reports_idreports' => $jadwal->id_jadwal]);
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($picture->$field && Storage::disk('public')->exists($picture->$field)) {
                    Storage::disk('public')->delete($picture->$field);
                }
                $storedPath = $request->file($field)->store('laporan', 'public');
                $picture->$field = $storedPath;
            }
        }
        $picture->save();

        $jadwal->update($data);

        return redirect()->route('karyawan.laporan.index')->with('success', 'Laporan jadwal berhasil diperbarui.');
    }

    public function show($id)
    {
        $laporan = Jadwal::with(['user', 'ruangan', 'pelanggan', 'laporan'])->findOrFail($id);
        return view('users.karyawan.laporan.show', compact('laporan'));
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        // Cleanup photos from storage and DB
        $picture = $jadwal->picture;
        if ($picture) {
            $allPhotoFields = ['foto_jenazah', 'foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
            foreach ($allPhotoFields as $field) {
                if ($picture->$field && Storage::disk('public')->exists($picture->$field)) {
                    Storage::disk('public')->delete($picture->$field);
                }
            }
            $picture->delete();
        }

        if ($jadwal->laporan) {
            $jadwal->laporan->delete();
        }

        $jadwal->delete();

        return redirect()->route('karyawan.laporan.index')->with('success', 'Data laporan dan jadwal berhasil dihapus sepenuhnya.');
    }
}
