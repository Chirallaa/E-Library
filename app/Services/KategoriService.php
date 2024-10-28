<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriService
{
    public function getAllKategori()
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategori = Kategori::all();
        return compact('kategori', 'profile');
    }

    public function getCreateData()
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategori = Kategori::all();
        return compact('kategori', 'profile');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:2',
        ], [
            'nama.required' => "Masukkan nama kategori",
            'nama.min' => "Minimal 2 karakter"
        ]);

        return Kategori::create($request->all());
    }

    public function getKategoriDetail($id)
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategori = Kategori::find($id);
        $buku = Buku::all();
        return compact('kategori', 'profile', 'buku');
    }

    public function getEditData($id)
    {
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategori = Kategori::find($id);
        return compact('kategori', 'profile');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:2',
        ], [
            'nama.required' => "Masukkan nama kategori",
            'nama.min' => "Minimal 2 karakter"
        ]);

        $kategori = Kategori::find($id);
        $kategori->nama = $request->nama;
        $kategori->deskripsi = $request->deskripsi;
        return $kategori->save();
    }

    public function deleteKategori($id)
    {
        $kategori = Kategori::find($id);
        return $kategori->delete();
    }
}
