<?php

namespace App\Services;

use App\Models\User;
use App\Models\Pengunjung;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PengunjungService
{
    public function processTamu(Request $request)
    {
        $rfidData = $request->input('rfid');
        $user = User::where('rfid', $rfidData)->first();

        if ($user && $user->role === 'siswa') {
            Pengunjung::create([
                'user_id' => $user->id,
                'waktu_kunjungan' => Carbon::now(),
            ]);

            return response()->json(['success' => true, 'redirect' => '/home']);
        } else {
            return response()->json(['success' => false, 'message' => 'RFID tidak dikenal atau bukan siswa']);
        }
    }

    public function getPengunjungData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Pengunjung::with(['user'])
            ->orderBy('waktu_kunjungan', 'desc');

        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('waktu_kunjungan', [$startDate, $endDate]);
        }

        $perPage = 10;
        $pengunjung = $query->paginate($perPage);

        return [
            'pengunjung' => $pengunjung,
            'start_date' => $startDate ? $startDate->format('Y-m-d') : null,
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null
        ];
    }

    public function generatePDF($start_date, $end_date)
    {
        $pengunjung = Pengunjung::whereBetween('waktu_kunjungan', [$start_date, $end_date])->get();
        $pdf = PDF::loadView('pengunjung.pdf', [
            'pengunjung' => $pengunjung,
            'start_date' => Carbon::parse($start_date)->format('d-m-Y'),
            'end_date' => Carbon::parse($end_date)->format('d-m-Y')
        ])->setPaper('a4', 'landscape');
        return $pdf->download('pengunjung.pdf');
    }
}
