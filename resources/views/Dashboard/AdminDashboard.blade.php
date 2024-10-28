@extends('layouts.master')


@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Dashboard</h1>
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
    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/buku" class="text-decoration-none">
                <div class="card h-100 bg-gradient-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-sm font-weight-bold text-uppercase mb-1 text-light">Buku</div>
                                <div class="text-sm text-light h5 mb-0 font-weight-bold">{{ $buku }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-book fa-3x text-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/kategori" class="text-decoration-none">
                <div class="card h-100 bg-gradient-info">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col mr-2">
                                <div class="text-sm text-light font-weight-bold text-uppercase mb-1">Katalog</div>
                                <div class="text-sm text-light h5 mb-0 font-weight-bold">{{ $kategori }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-bookmark fa-3x text-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/anggota" class="text-decoration-none">
                <div class="card h-100 bg-gradient-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-sm text-light font-weight-bold text-uppercase mb-1">Anggota</div>
                                <div class="h5 mb-0 mr-3 font-weight-bold text-light">{{ $user }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-3x text-light"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/peminjaman" class="text-decoration-none">
            <div class="card h-100 bg-gradient-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm text-light font-weight-bold text-uppercase mb-1" style="font-size:.8rem;">Riwayat Peminjamam</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-light">{{ $jumlah_riwayat }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Pengunjung Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
        <a href="/pengunjung" class="text-decoration-none">
            <div class="card h-100 bg-gradient-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm text-light font-weight-bold text-uppercase mb-1" style="font-size:.8rem;"> Pengunjung</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-light">{{ $jumlah_pengunjung }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Buku Rusak Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/buku/rusak" class="text-decoration-none">
            <div class="card h-100 bg-gradient-danger">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm text-light font-weight-bold text-uppercase mb-1" style="font-size:.8rem;">Buku Rusak</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-light">{{ $jumlah_buku_rusak }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-dead fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumlah Buku Hilang Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="/buku/hilang" class="text-decoration-none">
            <div class="card h-100 bg-gradient-danger">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-sm text-light font-weight-bold text-uppercase mb-1" style="font-size:.8rem;">Buku Hilang</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-light">{{ $jumlah_buku_hilang }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book-medical fa-3x text-light"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Table-->
    <h1 class="text-primary"> Riwayat Peminjaman</h1>
    <div class="col-lg-auto">
        <div class="card mb-2">
            <div class="table-responsive">
                <table class="table align-items-center justify-content-center table-flush table-hover" id="dataTableHover" style="font-size:.7rem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Kode Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Wajib Pengembalian</th>
                            <th scope="col">Tanggal Pengembalian</th>
                            <th scope="col">Denda Pengembalian</th>
                            <th scope="col">Kondisi Buku</th>
                            <th scope="col">Denda Kondisi Buku</th>
                            <th scope="col">Total Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat_pinjam as $item )
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
                            <td>{{ $item->tanggal_wajib_kembali }} </td>
                            <td>{{ $item->pengembalian ? $item->pengembalian->tanggal_kembali : 'Belum dikembalikan' }}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungDendaKeterlambatan() : '0' }}</td>
                            <td>{{ $item->pengembalian ? $item->pengembalian->kondisi : 'Belum dikembalikan' }}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->denda_manual : '0' }}</td>
                            <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungTotalDenda() : '0' }}</td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="12">Tidak ada data peminjaman yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection