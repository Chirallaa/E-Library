@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h2 class="text-primary">Daftar Katalog</h2>
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
        <a href="/katalog/create" class="btn btn-info mb-3">Tambah Katalog</a>
    @endif

    <div class="col-lg-auto">
        <div class="card mb-4">

            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Nama Katalog</th>
                            <th scope="col">Tombol Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategori as $key => $item)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $item->nama }}</td>
                                <td>

                                    @if (Auth::user()->role == 'petugas')
                                        <button class="btn btn-info"><a href="/katalog/{{ $item->id }}"
                                                style="text-decoration: none; color:white;"><i class="fa-solid fa-circle-info"></i></a></button>
                                        <button class="btn btn-warning"><a href="/katalog/{{ $item->id }}/edit"
                                                style="text-decoration: none;color:white"><i class="fa-solid fa-pen-to-square"></i></a></button>
                                        <button class="btn btn-danger delete-button" data-id="{{ $item->id }}"><i class="fa-solid fa-trash"></i></button>
                                    @endif

                                    @if (Auth::user()->role == 'siswa')
                                        <a href="/katalog/{{ $item->id }}" class="btn-sm btn-info px-3 py-2"
                                            style="text-decoration: none;color:white">Detail</a>
                                    @endif

                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const itemId = this.getAttribute('data-id');
                    fetch(`/katalog/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });
        });
    </script>
@endsection