<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Storage;

class AnggotaService
{
    public function getAllSiswa()
    {
        return User::where('role', 'siswa')->get();
    }

    public function getProfileByUserId($userId)
    {
        return Profile::where('user_id', $userId)->first();
    }

    public function createAnggota($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'rfid' => $data['rfid'],
            'role' => 'siswa',
        ]);

        Profile::create([
            'kelas' => $data['kelas'],
            'jabatan' => 'null',
            'alamat' => $data['alamat'],
            'noTelp' => $data['noTelp'],
            'jk' => $data['jk'],
            'user_id' => $user->id,
        ]);

        return $user;
    }

    public function getAnggotaDetails($id)
    {
        $user = User::find($id);
        $profile = $this->getProfileByUserId($id);
        $pinjamanUser = Peminjaman::where('user_id', $user->id)->get();

        return [
            'user' => $user,
            'profile' => $profile,
            'pinjamanUser' => $pinjamanUser
        ];
    }

    public function updateAnggota(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'kelas' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required',
            'jk' => 'required',
            'photoProfile' => 'mimes:jpg,jpeg,png',
        ]);
    
        $user = User::findOrFail($id);
        $profile = Profile::where('user_id', $user->id)->first();
    
        // Jika profil tidak ada, buat profil baru
        if (!$profile) {
            $profile = new Profile([
                'user_id' => $user->id,
                'kelas' => null,
            ]);
        }
    
        $user->name = $request->input('name');
        $user->save();
    
        $profile->kelas = $request->input('kelas');
        $profile->alamat = $request->input('alamat');
        $profile->noTelp = $request->input('noTelp');
        $profile->jk = $request->input('jk');
        
        if ($request->has('photoProfile')) {
            $path = 'images/photoProfile';
            // Hapus foto lama jika ada
            if ($profile->photoProfile) {
                Storage::delete(public_path($profile->photoProfile)); // Pastikan path yang benar
            }
            $namaGambar = time() . '.' . $request->photoProfile->extension();
            $request->photoProfile->move(public_path($path), $namaGambar);
            $profile->photoProfile = $path . '/' . $namaGambar;
        }
    
        $profile->save();
    }

    public function deleteAnggota($id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'siswa') {
            $user->delete();
            return true;
        }
        return false;
    }
}
