@extends('layouts.master')


@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Riwayat Pengunjung</h1>
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
    @if (Auth::user()->role == 'petugas')
    <div class="container">
        <form method="GET" action="{{ route('pengunjung.index') }}">
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
                        <a href="" onclick="this.href='/pengunjung/download-pdf/'+document.getElementById('start_date').value+'/'+document.getElementById('end_date').value"
                        target="_blank" class="btn btn-primary">Download PDF</a>
                    @endif
                </div>
            </div>            
        </form>        
    </div>
    @endif
    <!-- Table-->
    <div class="col-lg-auto">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center justify-content-center table-flush table-hover" id="dataTableHover" style="font-size:.7rem">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">No Telp</th>
                            <th scope="col">Waktu Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengunjung as $item )
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->profile->kelas }}</td>
                            <td>{{ $item->user->profile->alamat }}</td>
                            <td>{{ $item->user->profile->noTelp }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->waktu_kunjungan)->format('d-m-Y') }}</td>
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