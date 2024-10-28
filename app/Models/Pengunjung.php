<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pengunjung extends Model
{
    use HasFactory;

    protected $table = 'pengunjung'; // Menentukan nama tabel yang benar

    protected $fillable = ['user_id', 'waktu_kunjungan'];

    // Jika Anda ingin menonaktifkan timestamps (created_at dan updated_at)
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
