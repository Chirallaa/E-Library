<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Http\Request;

class HomeService
{
    public function getHomeData(Request $request)
    {
        $query = $request->input('query');
        $kategori_nama = $request->input('kategori_nama');
        $tahun = $request->input('tahun');
        $pengarang = $request->input('pengarang');

        $kategoriList = Kategori::all();
        $bukuList = Buku::all();
        $pengarangList = Buku::select('pengarang')->distinct()->get();
        $tahunList = Buku::select('tahun_terbit')->distinct()->orderBy('tahun_terbit', 'desc')->get();

        $searchResults = $this->getSearchResults($query, $kategori_nama, $tahun, $pengarang);

        return compact('searchResults', 'query', 'kategori_nama', 'tahun', 'pengarang', 'kategoriList', 'pengarangList', 'tahunList', 'bukuList');
    }

    private function getSearchResults($query, $kategori_nama, $tahun, $pengarang)
    {
        $searchResults = Buku::query();
        if ($query) {
            $searchResults->where(function($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhereHas('kategori', function($subQ) use ($query) {
                      $subQ->where('nama', 'LIKE', "%{$query}%");
                  })
                  ->orWhere('tahun_terbit', 'LIKE', "%{$query}%")
                  ->orWhere('pengarang', 'LIKE', "%{$query}%");
            });
        }

        return $searchResults->paginate(12);
    }

    public function getDetailData($id)
    {
        $buku = Buku::findorFail($id);
        $kategori = Kategori::findorFail($id);
        return compact('buku', 'kategori');
    }

    public function getPetugasData()
    {
        return User::where('role', 'petugas')->with('profile')->get();
    }
}
