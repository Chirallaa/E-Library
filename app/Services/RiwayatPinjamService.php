<?php

namespace App\Services;

use PDF;
use App\Models\Buku;
use App\Models\User;
use App\Models\Profile;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RiwayatPinjamService
{
    public function getIndexData(Request $request)
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
        
        $query = Peminjaman::with(['user', 'buku'])
            ->orderBy('tanggal_pinjam', 'desc');

        if (Auth::user()->role != 'petugas') {
            $query->where('user_id', $iduser);
        }

        if ($startDate && $endDate) {
            $query->whereBetween('tanggal_pinjam', [$startDate, $endDate]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('buku', function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        $perPage = 10;
        $peminjam = $query->paginate($perPage);

        return [
            'profile' => $profile,
            'peminjam' => $peminjam,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'search' => $search
        ];
    }

    public function storePeminjaman(Request $request, $id)
    {
        $userId = Auth::id();
        $buku = Buku::find($id);

        if ($buku->stok <= 0) {
            return ['success' => false, 'message' => 'Gagal, Buku Tidak Tersedia'];
        }

        $jumlahPinjaman = Peminjaman::where('user_id', $userId)
            ->whereNull('tanggal_pengembalian')
            ->count();

        if ($jumlahPinjaman >= 2) {
            return ['success' => false, 'message' => 'Jumlah Maksimal Peminjaman 2 buku'];
        }

        $bukuDipinjam = Peminjaman::where('user_id', $userId)
            ->where('buku_id', $id)
            ->whereNull('tanggal_pengembalian')
            ->exists();

        if ($bukuDipinjam) {
            return ['success' => false, 'message' => 'Anda Telah meminjam buku ini'];
        }

        if ($buku->stok > 0) {
            $buku->stok -= 1;
            $buku->borrowed_count += 1;
            $buku->save();

            $tanggalWajibKembali = now()->addDays(3);

            Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $id,
                'tanggal_pinjam' => now(),
                'tanggal_wajib_kembali' => $tanggalWajibKembali,
                'tanggal_pengembalian' => null,
            ]);

            return ['success' => true];
        }

        return ['success' => false, 'message' => 'Stok buku tidak tersedia'];
    }

    public function getShowData()
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();

        $query = Peminjaman::with(['user', 'buku'])->orderBy('updated_at', 'desc');

        if (Auth::user()->role != 'petugas') {
            $query->where('user_id', $iduser);
        }

        $perPage = 10;
        $peminjam = $query->paginate($perPage);

        $pinjamanUser = Peminjaman::where('user_id', $iduser)->get();

        return [
            'profile' => $profile,
            'peminjam' => $peminjam,
            'pinjamanUser' => $pinjamanUser
        ];
    }

    public function generatePDF($start_date, $end_date)
    {
        $peminjaman = Peminjaman::whereBetween('tanggal_pinjam', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('peminjaman.pdf', [
            'peminjaman' => $peminjaman,
            'start_date' => $start_date,
            'end_date' => $end_date
        ])->setPaper('a4', 'landscape');
        return $pdf->download('peminjaman.pdf');
    }
}
