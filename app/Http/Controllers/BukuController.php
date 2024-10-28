<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BukuService;
use RealRashid\SweetAlert\Facades\Alert;

class BukuController extends Controller
{
    protected $bukuService;

    public function __construct(BukuService $bukuService)
    {
        $this->bukuService = $bukuService;
    }

    public function index(Request $request)
    {
        $data = $this->bukuService->index($request);
        return view('buku.tampil', $data);
    }

    public function create()
    {
        $data = $this->bukuService->create();
        return view('buku.tambah', $data);
    }

    public function store(Request $request)
    {
        $this->bukuService->store($request);
        Alert::success('Berhasil', 'Berhasil Menambahkan Data Buku');
        return redirect('/buku');
    }

    public function show($id)
    {
        $data = $this->bukuService->show($id);
        if (!$data) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan');
        }
        return view('buku.detail', $data);
    }

    public function pinjam($id)
    {
        $this->bukuService->pinjam($id);
        return redirect()->back()->with('success', 'Buku berhasil dipinjam');
    }

    public function edit($id)
    {
        $data = $this->bukuService->edit($id);
        return view('buku.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->bukuService->update($request, $id);
        Alert::success('Berhasil', 'Update Berhasil');
        return redirect('/buku');
    }

    public function destroy($id)
    {
        $this->bukuService->destroy($id);
        Alert::success('Berhasil', 'Buku Berhasil Terhapus');
        return redirect('buku');
    }
}