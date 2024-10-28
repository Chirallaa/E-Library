<?php

namespace App\Http\Controllers;

use App\Services\PengembalianService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengembalianController extends Controller
{
    protected $pengembalianService;

    public function __construct(PengembalianService $pengembalianService)
    {
        $this->pengembalianService = $pengembalianService;
    }

    public function index()
    {
        $data = $this->pengembalianService->getIndexData();
        return view('pengembalian.index', $data);
    }

    public function search(Request $request)
    {
        $data = $this->pengembalianService->searchPeminjaman($request);
        return view('pengembalian.index', $data);
    }

    public function returnBook(Request $request)
    {
        $this->pengembalianService->processBookReturn($request);
        Alert::success('Berhasil', 'Buku berhasil dikembalikan');
        return redirect()->back();
    }

    public function updateDendaManual(Request $request, $id)
    {
        $this->pengembalianService->updateDendaManual($request, $id);
        return redirect()->back();
    }
}