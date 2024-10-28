<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian'; // Pastikan nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali',
        'denda_manual',
        'kondisi',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function hitungDendaKeterlambatan()
    {
        $dendaKeterlambatan = 0;

        if ($this->tanggal_kembali && Carbon::parse($this->tanggal_kembali)->gt(Carbon::parse($this->peminjaman->tanggal_wajib_kembali))) {
            $daysLate = Carbon::parse($this->tanggal_kembali)->diffInDays(Carbon::parse($this->peminjaman->tanggal_wajib_kembali));
            $dendaKeterlambatan = $daysLate * 1000; // Rp 1000 per hari
        }

        return $dendaKeterlambatan;
    }

    public function hitungTotalDenda()
    {
        return $this->hitungDendaKeterlambatan() + $this->denda_manual;
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
