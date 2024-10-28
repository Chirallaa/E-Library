@extends('layouts.master')

@section('topbar')
    @include('part.topbar')
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('judul')
    <h1 class="text-primary">Detail Anggota</h1>
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
    <h2 class="text-primary my-4">Daftar Riwayat Pinjaman Anggota</h2>
    <div class="col-lg-auto">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center justify-content-center table-flush table-hover" id="dataTableHover" style="font-size: .7rem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Anggota</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Kode Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Wajib Pengembalian</th>
                            <th scope="col">Tanggal Pengembalian</th>
                            <th scope="col">Kondisi Buku </th>
                            <th scope="col">Denda Keterlambatan</th>
                            <th scope="col">Denda Buku</th>
                            <th scope="col">Total Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pinjamanUser as $item )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->buku ? $item->buku->judul : 'Buku tidak ditemukan' }}</td>
                            <td>{{ $item->buku ? $item->buku->kode_buku : 'Kode buku tidak ditemukan' }}</td>
                            <td>{{ $item->tanggal_pinjam }}</td>
                            <td>{{ $item->tanggal_wajib_kembali }}</td>
                            <td>{{ $item->pengembalian ? $item->pengembalian->tanggal_kembali : 'Belum dikembalikan' }}</td>
                            <td>{{ $item->pengembalian ? $item->pengembalian->kondisi : 'tidak diketahui'}}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungDendaKeterlambatan() : '0' }}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->denda_manual : '0' }}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungTotalDenda() : '0' }}</td>
                        @empty

                        @endforelse
                    </tbody>
                </table>
                <div class="edit d-flex justify-content-end my-4 mx-4">
            <a href="/anggota" class="btn btn-primary px-5">Kembali</a>
        </div>
            </div>
        </div>
    </div>
@endsection
