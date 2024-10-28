<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileService
{
    public function getUserProfile()
    {
        $iduser = Auth::id();
        return Profile::where('user_id', $iduser)->first();
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'kelas' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'noTelp' => 'required|string|max:255',
            'jk' => 'required|in:laki-laki,perempuan',
            'photoProfile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $user = User::where('id', $iduser)->first();

        if ($request->has('photoProfile')) {
            $path = 'images/photoProfile';

            if ($profile->photoProfile) {
                Storage::delete($profile->photoProfile);
            }

            $namaGambar = time() . '.' . $request->photoProfile->extension();
            $request->photoProfile->move(public_path($path), $namaGambar);
            $profile->photoProfile = $path . '/' . $namaGambar;
            $profile->save();
        }

        $user->name = $request->name;
        $profile->kelas = $request->kelas;
        $profile->jabatan = $request->jabatan;
        $profile->alamat = $request->alamat;
        $profile->noTelp = $request->noTelp;
        $profile->jk = $request->jk;

        $profile->save();
        $user->save();
    }

    public function getProfileById($id)
    {
        return Profile::with('user')->find($id);
    }
}
