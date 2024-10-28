<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(Request $request)
    {
        $data = $this->homeService->getHomeData($request);
        return view('Landing Page.home', $data);
    }

    public function detail($id)
    {
        $data = $this->homeService->getDetailData($id);
        return view('Landing Page.detail', $data);
    }

    public function showPetugas()
    {
        $petugas = $this->homeService->getPetugasData();
        return view('Landing Page.petugas', compact('petugas'));
    }
}
