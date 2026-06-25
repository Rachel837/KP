<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Ruangan;
use App\Models\PelangganKremasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Picture;
use App\Models\Laporan;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['user', 'ruangan', 'pelanggan', 'picture', 'laporan'])
            ->where(function ($query) {
                $query->whereDoesntHave('laporan')
                      ->orWhereHas('laporan', function ($q) {
                          $q->whereNull('lama_pembakaran');
                      });
            })
            ->where(function ($query) {
                $query->whereDoesntHave('picture')
                      ->orWhereHas('picture', function ($q) {
                          $q->whereNull('foto_abu');
                      });
            })
            ->orderBy('id_jadwal', 'desc')
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
            'foto_jenazah' => 'nullable|image|max:2048',
        ]);

        // Create PelangganKremasi record
        $pelanggan = PelangganKremasi::create([
            'nama_jenazah' => $request->nama_jenazah,
            'usia_jenazah' => $request->usia_jenazah,
            'penanggung_jawab' => $request->nama_penanggung_jawab,
            'no_telepon' => $request->no_telepon_penanggung_jawab,
            'tanggal_lahir_jenazah' => $request->tanggal_lahir_jenazah,
            'tempat_lahir_jenazah' => $request->tempat_lahir_jenazah,
            'alamat_jenazah' => $request->alamat,
        ]);

        $data = $request->only(['date', 'ruangan_id']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;
        $data['user_iduser'] = auth()->user()->iduser;

        $jadwal = Jadwal::create($data);

        // Create associated Laporan record
        Laporan::create([
            'id_jadwal' => $jadwal->id_jadwal,
            'jam_awal' => $request->jam_awal,
            'waktu_tiba' => '00:00',
            'jam_akhir' => '00:00',
            'jumlah_solar' => 0,
            'lama_pembakaran' => null,
        ]);

        if ($request->hasFile('foto_jenazah')) {
            $storedPath = $request->file('foto_jenazah')->store('foto_jenazah', 'public');
            Picture::create([
                'foto_jenazah' => $storedPath,
                'reports_idreports' => $jadwal->id_jadwal,
            ]);
        }

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['user', 'ruangan', 'pelanggan', 'laporan'])->findOrFail($id);
        return view('users.karyawan.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::with('laporan')->findOrFail($id);
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
            'foto_jenazah' => 'nullable|image|max:2048',
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

        $data = $request->only(['date', 'ruangan_id']);
        $data['pelanggan kremasi_id'] = $pelanggan->id;

        $laporan = Laporan::firstOrCreate(
            ['id_jadwal' => $jadwal->id_jadwal],
            [
                'waktu_tiba' => '00:00',
                'jam_akhir' => '00:00',
                'jumlah_solar' => 0,
                'lama_pembakaran' => null,
            ]
        );

        $laporan->jam_awal = $request->jam_awal;

        if ($request->status === 'Selesai') {
            // Calculate if we have jam_akhir, otherwise keep existing or set 'Selesai'
            if ($laporan->jam_akhir && substr($laporan->jam_akhir, 0, 5) !== '00:00') {
                $jamAwal = Carbon::parse($request->jam_awal);
                $jamAkhir = Carbon::parse($laporan->jam_akhir);
                $laporan->lama_pembakaran = $jamAwal->diffInMinutes($jamAkhir);
            } else {
                $laporan->lama_pembakaran = $laporan->lama_pembakaran === null ? 'Selesai' : $laporan->lama_pembakaran;
            }
        } else {
            $laporan->lama_pembakaran = null;
            $laporan->waktu_tiba = '00:00';
            $laporan->jam_akhir = '00:00';
            $laporan->jumlah_solar = 0;
            
            // Clean up old photo files if reverting status to Terjadwal
            $photoFields = ['foto_permohonan', 'foto_tiba', 'foto_awal', 'foto_akhir', 'foto_tulang', 'foto_abu'];
            $picture = $jadwal->picture;
            if ($picture) {
                foreach ($photoFields as $field) {
                    if ($picture->$field && Storage::disk('public')->exists($picture->$field)) {
                        Storage::disk('public')->delete($picture->$field);
                    }
                    $picture->$field = null;
                }
                $picture->save();
            }
        }
        $laporan->save();

        if ($request->hasFile('foto_jenazah')) {
            $picture = Picture::firstOrCreate(['reports_idreports' => $jadwal->id_jadwal]);

            if ($picture->foto_jenazah && Storage::disk('public')->exists($picture->foto_jenazah)) {
                Storage::disk('public')->delete($picture->foto_jenazah);
            }

            $storedPath = $request->file('foto_jenazah')->store('foto_jenazah', 'public');
            $picture->foto_jenazah = $storedPath;
            $picture->save();
        }

        $jadwal->update($data);

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        // Cleanup all photo files from storage and DB
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

        $jadwal->delete();

        return redirect()->route('karyawan.jadwal.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function getBookedSlots(Request $request)
    {
        $date = $request->query('date');
        $ruangan_id = $request->query('ruangan_id');

        if (!$date || !$ruangan_id) {
            return response()->json([]);
        }

        // Get all schedules for the specified date and machine
        $booked = Jadwal::where('date', $date)
            ->where('ruangan_id', $ruangan_id)
            ->with('laporan')
            ->get()
            ->map(function ($jadwal) {
                // Return the start time (first 5 chars, e.g., '09:30')
                return $jadwal->laporan ? substr($jadwal->laporan->jam_awal, 0, 5) : null;
            })
            ->filter()
            ->values();

        return response()->json($booked);
    }
}
