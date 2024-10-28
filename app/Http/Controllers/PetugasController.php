<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PetugasService;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    protected $petugasService;

    public function __construct(PetugasService $petugasService)
    {
        $this->petugasService = $petugasService;
    }

    public function index()
    {
        $data = $this->petugasService->getIndexData();
        return view('petugas.tampil', $data);
    }

    public function show()
    {
        $data = $this->petugasService->getShowData();
        return view('petugas.index', $data);
    }

    public function create()
    {
        $data = $this->petugasService->getCreateData();
        return view('petugas.tambah', $data);
    }

    public function store(Request $request)
    {
        $this->petugasService->storePetugas($request);
        Alert::success('Success', 'Berhasil Menambah Petugas');
        return redirect('/petugas');
    }

    public function edit($id)
    {
        $data = $this->petugasService->getEditData($id);
        return view('petugas.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->petugasService->updatePetugas($request, $id);
        Alert::success('Success', 'Berhasil Mengubah Profile');
        return redirect('/profile');
    }

    public function destroy($id)
    {
        $result = $this->petugasService->deletePetugas($id);
        return response()->json($result);
    }
}
