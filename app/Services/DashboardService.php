<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\Pengembalian;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDashboardData()
    {
        $iduser = Auth::id();
        $userRole = Auth::user()->role;

        $data = [
            'profile' => Profile::where('user_id', $iduser)->first(),
            'kategori' => Kategori::count(),
            'buku' => Buku::count(),
            'user' => User::where('role', 'siswa')->count(),
            'riwayat_pinjam' => Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc')->get(),
            'jumlah_riwayat' => Peminjaman::count(),
            'pinjamanUser' => Peminjaman::where('user_id', $iduser)->where('tanggal_pengembalian', null)->count(),
            'userRole' => $userRole,
        ];

        if ($userRole == 'petugas') {
            $data += [
                'jumlah_pengunjung' => Pengunjung::count(),
                'jumlah_buku_rusak' => Pengembalian::where('kondisi', 'rusak')->count(),
                'jumlah_buku_hilang' => Pengembalian::where('kondisi', 'hilang')->count(),
                'jumlah_buku_baru' => Buku::where('created_at', '>=', now()->subMonth())->count(),
                'denda' => Peminjaman::where('denda', '>', 0)->sum('denda'),
            ];
        }

        return $data;
    }
}
