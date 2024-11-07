<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\User;
use App\Models\Profile;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianService
{
    public function getIndexData()
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $users = User::all();
        return compact('users', 'profile');
    }

    public function searchPeminjaman(Request $request)
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $userId = $request->input('user_id');
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->where('user_id', $userId)
            ->whereDoesntHave('pengembalian')
            ->get();
        $users = User::where('role', 'siswa')->get();
        return compact('peminjaman', 'users', 'userId', 'profile');
    }

    public function processBookReturn(Request $request)
    {
        $peminjaman = Peminjaman::find($request->input('peminjaman_id'));
        $kondisi = $request->input('kondisi', 'baik');
        $dendaManual = $request->input('denda_manual', 0);

        //detail pengembalian
        $tanggalWajibKembali = Carbon::parse($peminjaman->tanggal_wajib_kembali);
        $tanggalKembali = now();
        $status = 'dikembalikan'; // Default status

        if ($tanggalKembali->gt($tanggalWajibKembali)) {
            $status = 'terlambat';
        }
    
        if ($kondisi === 'rusak') {
            $status = 'dikembalikan';
        } elseif ($kondisi === 'hilang') {
            $status = 'dikembalikan';
        }

        // Hitung jumlah hari terlambat
        $dendaKeterlambatan = 0;
        if ($status === 'terlambat') {
            $jumlahHariTerlambat = $tanggalKembali->diffInDays($tanggalWajibKembali);
            // Misalkan denda per hari adalah Rp 1000
            $dendaKeterlambatan = $jumlahHariTerlambat * 1000;
        }

        // Hitung total denda (denda keterlambatan + denda manual)
        $totalDenda = $dendaKeterlambatan + $dendaManual;


        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => now(),
            'kondisi' => $kondisi,
            'denda_manual' => $dendaManual,
        ]);

        $detail = DetailPeminjaman::where('peminjaman_id', $peminjaman->id)
        ->update([
            'pengembalian_id' => $pengembalian->id,
            'status' => $status
        ]);

        $buku = Buku::find($peminjaman->buku_id);

        if ($kondisi === 'baik') {
            $buku->stok += 1;
        } elseif ($kondisi === 'rusak' || $kondisi === 'hilang') {
            $buku->stok -= 1;
        }

        $buku->save();

        $peminjaman->tanggal_pengembalian = now();
        $peminjaman->denda = $totalDenda;
        $peminjaman->save();

        return [
            'status' => $status,
            'denda_keterlambatan' => $dendaKeterlambatan,
            'denda_manual' => $dendaManual,
            'total_denda' => $totalDenda,
            'hari_terlambat' => $status === 'terlambat' ? $jumlahHariTerlambat : 0
        ];
    }
}
