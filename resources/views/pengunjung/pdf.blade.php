<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pengunjung</title>
    <style>
        body {
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
        th {
            background-color: #007fff;
            color: #000;
        }
        .header {
            text-align: center;
            position: relative;
            margin-bottom: 20px;
        }
        .header img {
            position: absolute;
            top: 0;
            left: 0;
            width: 130px;
        }
        .footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
           <img src="{{ public_path('img/logos.png') }}" alt="Logo">
           <h1>PERPUSTAKAAN UPT SMP NEGERI 13 UJUNG PANGKAH GRESIK</h1>
           <p> Jalan Raya Ujungpangkah, Pangkah Kulon, Kec. Ujung Pangkah, Kab. Gresik Prov. Jawa Timur </p>
           <h2>LAPORAN DATA RIWAYAT PENGUNJUNG</h2>
           <h3>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d-F-Y') }} sampai {{ \Carbon\Carbon::parse($end_date)->format('d-F-Y') }}</h3>
        </div>
        @if($pengunjung->isEmpty())
    <p>Tidak ada data peminjaman pada periode {{ $start_date }} sampai {{ $end_date }}</p>
@else
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>No.Telp</th>
                <th>Tanggal Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengunjung as $index => $pengunjung)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pengunjung->user->name }}</td>
                <td>{{ $pengunjung->user->profile->kelas }}</td>
                <td>{{ $pengunjung->user->profile->noTelp }}</td>
                <td>{{ \Carbon\Carbon::parse($pengunjung->waktu_kunjungan)->format('d-m-Y') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: right;"><strong>Jumlah Pengunjung</strong></td>
                <td>{{ $pengunjung->count() }}</td>
            </tr>
        </tbody>
    </table>
    @endif
    <div class="footer">
        <p>Ujung Pangkah Gresik {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
        <p>MENGETAHUI</p>
        <p>Kepala Perpustakaan</p>
        <br><br>
        <p></p>
        <p>NIP. 197006102003121002</p>
        <p>H. M. SUTRISNO</p>
    </div>
</body>
</html>