<?php

namespace App\Http\Controllers;

use App\Services\KategoriService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    protected $kategoriService;

    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }

    public function index()
    {
        $data = $this->kategoriService->getAllKategori();
        return view('kategori.tampil', $data);
    }

    public function create()
    {
        $data = $this->kategoriService->getCreateData();
        return view('Kategori.tambah', $data);
    }

    public function store(Request $request)
    {
        $this->kategoriService->storeKategori($request);
        Alert::success('Berhasil', 'Berhasil Menambahkan Kategori');
        return redirect('/katalog');
    }

    public function show($id)
    {
        $data = $this->kategoriService->getKategoriDetail($id);
        return view('kategori.detail', $data);
    }

    public function edit($id)
    {
        $data = $this->kategoriService->getEditData($id);
        return view('kategori.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->kategoriService->updateKategori($request, $id);
        Alert::success('Berhasil', 'Update Success');
        return redirect('/katalog');
    }

    public function destroy($id)
    {
        $this->kategoriService->deleteKategori($id);
        Alert::success('Berhasil', 'Berhasil Menghapus Kategori');
        return redirect('/katalog');
    }
}
