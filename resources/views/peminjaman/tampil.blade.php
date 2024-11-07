@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Riwayat Peminjaman</h1>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/dt-1.12.1/date-1.1.2/fc-4.1.0/r-2.3.0/sc-2.0.7/datatables.min.css" />
@endpush


@push('scripts')
    <script src="{{ '/template/vendor/datatables/jquery.dataTables.min.js' }}"></script>
    <script src="{{ '/template/vendor/datatables/dataTables.bootstrap4.min.js' }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable(); // ID From dataTable with Hover
        });
    </script>
@endpush

@section('content')

<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

    @if (Auth::user()->role == 'petugas')
    <div class="container">
        <form method="GET" action="{{ route('peminjaman.tampil') }}">
            <div class="form-row align-items-end">
                <div class="col-auto">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" id="start_date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                </div>
                <div class="col-auto">
                    <label for="end_date">Tanggal Akhir</label>
                    <input type="date" id="end_date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if(request('start_date') && request('end_date'))
                        <a href="" onclick="this.href='/peminjaman/download-pdf/'+document.getElementById('start_date').value+'/'+document.getElementById('end_date').value"
                        target="_blank" class="btn btn-primary">Download PDF</a>
                    @endif
                </div>
            </div>            
        </form>        
    </div>
    @endif

    <div class="col-lg-auto">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center justify-content-center table-flush table-hover" id="dataTableHover" style="font-size: .7rem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Kode Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Wajib Pengembalian</th>
                            <th scope="col">Tanggal Pengembalian</th>
                            <th scope="col">Status Peminjaman</th>
                            <th scope="col">Kondisi Buku </th>
                            <th scope="col">Total Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjam as $item )
                            <tr class="{{ $item->pengembalian ? ($item->pengembalian->kondisi == 'rusak' ? 'table-danger' : ($item->pengembalian->kondisi == 'hilang' ? 'table-warning' : '')) : 'table-info' }}">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    @if ($item->user)
                                        {{ $item->user->name }}
                                    @else
                                        User tidak ditemukan
                                    @endif
                                </td>
                                <td>{{ $item->buku ? $item->buku->judul : 'Buku tidak ditemukan' }}</td>
                                <td>{{ $item->buku ? $item->buku->kode_buku : 'Kode buku tidak ditemukan' }}</td>
                                <td>{{ $item->tanggal_pinjam }}</td>
                                <td>{{ $item->tanggal_wajib_kembali }}</td>
                                <td>{{ $item->pengembalian ? $item->pengembalian->tanggal_kembali : 'Belum dikembalikan' }}</td>
                                <td>{{ $item->detail ? $item->detail->status : 'tidak diketahui'}}</td>
                                <td>{{ $item->pengembalian ? $item->pengembalian->kondisi : 'tidak diketahui'}}</td>
                                <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungTotalDenda() : '0' }}</td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Tidak ada data peminjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Add pagination links -->
                <div class="d-flex justify-content-end">
                    {{ $peminjam->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection