<?php

namespace App\Services;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetugasService
{
    public function getIndexData()
    {
        $iduser = Auth::id();
        $user = User::where('role', 'petugas')->get();
        $profile = Profile::where('user_id', $iduser)->first();
        return ['petugas' => $user, 'profile' => $profile];
    }

    public function getShowData()
    {
        $user = User::where('role', 'petugas')->get();
        return ['petugas' => $user];
    }

    public function getCreateData()
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        return ['profile' => $profile];
    }

    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'rfid' => 'required',
        ]);

        $user = User::create([
            'name' => $request['name'],
            'rfid' => $request['rfid'],
            'role' => 'petugas',
        ]);

        Profile::create([
            'jabatan' => $request['jabatan'],
            'alamat' => $request['alamat'],
            'noTelp' => $request['noTelp'],
            'jk' => $request['jk'],
            'user_id' => $user->id,
            'kelas' => 'null',
        ]);
    }

    public function getEditData($id)
    {
        $user = User::find($id);
        $profile = Profile::where('user_id', $id)->first();
        return ['user' => $user, 'profile' => $profile];
    }

    public function updatePetugas(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'jabatan' => 'required',
            'alamat' => 'required',
            'noTelp' => 'required',
            'jk' => 'required',
            'photoProfile' => 'mimes:jpg,jpeg,png',
        ]);

        $user = User::findOrFail($id);
        $profile = Profile::where('user_id', $user->id)->first();

        $user->name = $request->input('name');
        $user->save();

        if (!$profile) {
            $profile = new Profile([
                'user_id' => $user->id,
                'kelas' => null,
            ]);
        }

        $profile->jabatan = $request->input('jabatan');
        $profile->alamat = $request->input('alamat');
        $profile->noTelp = $request->input('noTelp');
        $profile->jk = $request->input('jk');
        
        if ($request->has('photoProfile')) {
            $path = 'images/photoProfile';
            if ($profile->photoProfile) {
                Storage::delete($profile->photoProfile);
            }
            $namaGambar = time() . '.' . $request->photoProfile->extension();
            $request->photoProfile->move(public_path($path), $namaGambar);
            $profile->photoProfile = $path . '/' . $namaGambar;
        }

        $profile->save();
    }

    public function deletePetugas($id)
    {
        $user = User::find($id);
        if ($user && $user->role === 'petugas') {
            $user->delete();
            return ['success' => true];
        } else {
            return ['success' => false];
        }
    }
}
