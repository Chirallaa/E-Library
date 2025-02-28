<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profile";
    protected $fillable =[
    'kelas',
    'jk',
    'jabatan',
    'alamat',
    'noTelp',
    'photoProfile',
    'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}