<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PengunjungService;

class PengunjungController extends Controller
{
    protected $pengunjungService;

    public function __construct(PengunjungService $pengunjungService)
    {
        $this->pengunjungService = $pengunjungService;
    }

    public function scanRfid()
    {
        return view('Landing Page.tamu');
    }

    public function tamu(Request $request)
    {
        return $this->pengunjungService->processTamu($request);
    }

    public function index(Request $request)
    {
        $data = $this->pengunjungService->getPengunjungData($request);
        return view('pengunjung.tampil', $data);
    }

    public function downloadPDF($start_date, $end_date)
    {
        return $this->pengunjungService->generatePDF($start_date, $end_date);
    }
}

