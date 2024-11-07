<?php

namespace App\Models;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'riwayat_pinjam';

    protected $fillable = [
      'user_id',
      'buku_id',
      'tanggal_pinjam',
      'tanggal_wajib_kembali',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function detail(): HasOne
    {
        return $this->hasOne(DetailPeminjaman::class, 'peminjaman_id');
    }
}
