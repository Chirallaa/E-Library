<?php

namespace App\Http\Controllers;

use App\Services\AnggotaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AnggotaController extends Controller
{
    protected $anggotaService;

    public function __construct(AnggotaService $anggotaService)
    {
        $this->anggotaService = $anggotaService;
    }

    public function index()
    {
        $iduser = Auth::id();
        $siswa = $this->anggotaService->getAllSiswa();
        $profile = $this->anggotaService->getProfileByUserId($iduser);
        return view('anggota.tampil', ['siswa' => $siswa, 'profile' => $profile]);
    }

    public function create()
    {
        $iduser = Auth::id();
        $profile = $this->anggotaService->getProfileByUserId($iduser);
        return view('anggota.tambah', ['profile' => $profile]);
    }

    public function show($id)
    {
        $data = $this->anggotaService->getAnggotaDetails($id);
        return view('anggota.detail', $data);
    }

    public function edit($id)
    {
        $user = $this->anggotaService->getAnggotaDetails($id);
        return view('anggota.edit', $user);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'kelas' => 'required',
        'jk' => 'required',
        'alamat' => 'required',
        'noTelp' => 'required',
        'photoProfile' => 'mimes:jpg,jpeg,png',
    ]);

    // Panggil updateAnggota dengan Request dan ID
    $this->anggotaService->updateAnggota($request, $id);

    return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diupdate');
}

    public function destroy($id)
    {
        $success = $this->anggotaService->deleteAnggota($id);
        return response()->json(['success' => $success]);
    }
}
