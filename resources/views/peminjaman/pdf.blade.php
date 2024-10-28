<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Peminjaman</title>
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
            background-color: #f2f2f2;
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
        .still-borrowed td {
            background-color: #ffeb3b; /* Yellow */
        }
        .damaged td {
            background-color: #f44336; /* Red */
        }
        .lost td {
            background-color: #ff9800; /* Orange */
        }
    </style>
</head>
<body>
<div class="header">
           <img src="{{ public_path('img/logos.png') }}" alt="Logo">
           <h1>PERPUSTAKAAN UPT SMP NEGERI 13 UJUNG PANGKAH GRESIK</h1>
           <p> Jalan Raya Ujungpangkah, Pangkah Kulon, Kec. Ujung Pangkah, Kab. Gresik Prov. Jawa Timur </p>
           <h2>LAPORAN DATA RIWAYAT PEMINJAMAN BUKU</h2>
           <h3>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d-F-Y') }} sampai {{ \Carbon\Carbon::parse($end_date)->format('d-F-Y') }}</h3>
        </div>
        @if($peminjaman->isEmpty())
    <p>Tidak ada data peminjaman pada periode {{ $start_date }} sampai {{ $end_date }}</p>
@else
    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Judul Buku</th>
                <th>Kode Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Wajib Pengembalian</th>
                <th>Tanggal Pengembalian</th>
                <th>Kondisi Buku</th>
                <th>Total Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $index => $pinjam)
            <tr class="{{ !$pinjam->pengembalian ? 'still-borrowed' : ($pinjam->pengembalian->kondisi == 'rusak' ? 'damaged' : ($pinjam->pengembalian->kondisi == 'hilang' ? 'lost' : '')) }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $pinjam->user->name }}</td>
                <td>{{ $pinjam->buku->judul }}</td>
                <td>{{ $pinjam->buku->kode_buku }}</td>
                <td>{{ $pinjam->tanggal_pinjam }}</td>
                <td>{{ $pinjam->tanggal_wajib_kembali }}</td>
                <td>{{ $pinjam->pengembalian ? $pinjam->pengembalian->tanggal_kembali : 'Belum dikembalikan' }}</td>
                <td>{{ $pinjam->pengembalian ? $pinjam->pengembalian->kondisi : 'tidak diketahui'}}</td>
                <td>Rp {{ $pinjam->pengembalian ? $pinjam->pengembalian->hitungTotalDenda() : '0' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="8" style="text-align: right;"><strong>Total:</strong></td>
                <td>Rp {{ $peminjaman->sum(function($pinjam) { return ($pinjam->pengembalian ? $pinjam->pengembalian->hitungDendaKeterlambatan() : 0) + ($pinjam->pengembalian ? $pinjam->pengembalian->denda_manual : 0); }) }}</td>
            </tr>
        </tbody>
    </table>
    @endif
    <div class="footer">
        <p>Ujung Pangkah Gresik {{ \Carbon\Carbon::now()->format('d-F-Y') }}</p>
        <p>MENGETAHUI</p>
        <p>Kepala Perpustakaan</p>
        <br><br>
        <p></p>
        <p>NIP. 197006102003121002</p>
        <p>H. M. SUTRISNO</p>
    </div>
</body>
</html>