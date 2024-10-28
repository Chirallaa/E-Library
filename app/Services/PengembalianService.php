<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\User;
use App\Models\Profile;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tanggal_kembali' => now(),
            'kondisi' => $kondisi,
            'denda_manual' => $dendaManual,
        ]);

        $buku = Buku::find($peminjaman->buku_id);

        if ($kondisi === 'baik') {
            $buku->stok += 1;
        } elseif ($kondisi === 'rusak' || $kondisi === 'hilang') {
            $buku->stok -= 1;
        }

        $buku->save();

        $peminjaman->tanggal_pengembalian = now();
        $peminjaman->save();
    }

    public function updateDendaManual(Request $request, $id)
    {
        $pengembalian = Pengembalian::find($id);
        $pengembalian->denda_manual = $request->denda_manual;
        $pengembalian->save();
    }
}
