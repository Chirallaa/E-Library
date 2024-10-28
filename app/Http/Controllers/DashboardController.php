<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->middleware('auth');
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();
        
        if ($data['userRole'] == 'petugas') {
            return view('Dashboard/AdminDashboard', $data);
        } else {
            return view('Dashboard/AnggotaDashboard', $data);
        }
    }
}