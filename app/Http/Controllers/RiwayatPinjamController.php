<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RiwayatPinjamService;
use RealRashid\SweetAlert\Facades\Alert;

class RiwayatPinjamController extends Controller
{
    protected $riwayatPinjamService;

    public function __construct(RiwayatPinjamService $riwayatPinjamService)
    {
        $this->riwayatPinjamService = $riwayatPinjamService;
    }

    public function index(Request $request)
    {
        $data = $this->riwayatPinjamService->getIndexData($request);
        return view('peminjaman.tampil', $data);
    }

    public function store(Request $request, $id)
    {
        $result = $this->riwayatPinjamService->storePeminjaman($request, $id);
        if ($result['success']) {
            Alert::success('success', 'Buku berhasil dipinjam');
        } else {
            Alert::error($result['message']);
        }
        return redirect()->back();
    }

    public function show()
    {
        $data = $this->riwayatPinjamService->getShowData();
        return view('peminjaman.tampil', $data);
    }

    public function downloadPDF($start_date, $end_date)
    {
        return $this->riwayatPinjamService->generatePDF($start_date, $end_date);
    }
}