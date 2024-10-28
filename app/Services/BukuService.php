<?php

namespace App\Services;

use File;
use App\Models\Buku;
use App\Models\Profile;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuService
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $buku = Buku::where('judul','like','%'.$request->search.'%')->where('stok', '>', 0)->paginate(6);
        }
        else{
            $buku = Buku::where('stok', '>', 0)->paginate(6);
        }
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        $kategoriList = Kategori::all();
        return ['buku' => $buku, 'profile' => $profile, 'kategoriList' => $kategoriList];
    }

    public function create()
    {
        $kategori = Kategori::all();
        $buku = Buku::all();
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        return ['buku' => $buku, 'profile' => $profile, 'kategori' => $kategori];
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'halaman' => 'required',
            'isbn' => 'required',
            'kode_buku'=>'required|unique:buku',
            'kategori_buku'=>'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $nama_gambar = $this->handleImage($request->gambar);
            $validatedData['gambar'] = $nama_gambar;
        }

        $buku = Buku::create($validatedData);
        $buku->kategori_buku()->sync($request->kategori_buku);

        return $buku;
    }

    public function show($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return null;
        }

        $buku->increment('views');
        $iduser = Auth::id();
        $profile = Profile::where('user_id', $iduser)->first();
        return ['buku' => $buku, 'profile' => $profile];
    }

    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->increment('borrowed_count');
        return $buku;
    }

    public function edit($id)
    {
        $iduser = Auth::id();
        $kategori = Kategori::all();
        $profile = Profile::where('user_id', $iduser)->first();
        $buku = Buku::find($id);
        return ['buku' => $buku, 'profile' => $profile, 'kategori' => $kategori];
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        $validatedData = $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'halaman' => 'required',
            'isbn' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('gambar')) {
            $this->deleteOldImage($buku->gambar);
            $nama_gambar = $this->handleImage($request->gambar);
            $validatedData['gambar'] = $nama_gambar;
        }

        $buku->update($validatedData);
        $buku->kategori_buku()->sync($request->kategori_buku);

        return $buku;
    }

    public function destroy($id)
    {
        $buku = Buku::find($id);
        $buku->delete();
        return $buku;
    }

    private function handleImage($image)
    {
        $nama_gambar = time() . '.' . $image->extension();
        $image->move(public_path('images'), $nama_gambar);
        return $nama_gambar;
    }

    private function deleteOldImage($imageName)
    {
        $path = 'images/';
        File::delete($path . $imageName);
    }
}
