@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('content')

<head>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <form action="/buku" method="GET" class="mt-3">
                <div class="form-group">
                    <label for="kategori">Filter Katalog</label>
                    <select name="kategori" id="kategori" class="form-control">
                        <option value="">Semua Katalog</option>
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
                <a href="/buku" class="btn btn-danger mt-2">Hapus Filter</a>
            </form>
        </div>
        <div class="col-md-9">
            <form class="navbar-search mb-3" action="/buku" method="GET">
                <div class="input-group">
                    <input type="search" name="search" class="form-control bg-light border-1 small" placeholder="Cari Judul Buku"
                        aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            @if (Auth::user()->role == 'petugas')
                <a href="/buku/create" class="btn btn-info mb-3">Tambah Buku</a>
            @endif

            <div class="card container-fluid mb-3">
                <div class="row d-flex flex-wrap justify-content-start">
                    @forelse ($buku as $item)
                        <div class="col-6 col-md-6 col-lg-6 my-2">
                            <div class="card mx-2 my-2" style="min-height:18rem;">
                                @if ($item->gambar != null)
                                    <img class="card-img-top" style="height:150px; object-fit:cover;" src="{{ asset('/images/' . $item->gambar) }}">
                                @else
                                    <img class="card-img-top" style="height:150px; object-fit:cover;" src="{{ asset('/images/noImage.jpg') }}">
                                @endif
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="detail-buku">
                                        <h5 class="card-title text-primary"><a
                                                href="/buku/{{ $item->id }}"style="text-decoration: none; font-size:1rem;font-weight:bold;">
                                                {{ $item->judul }}</a></h5>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Jumlah Halaman : {{ $item->halaman }}</p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">ISBN : {{ $item->isbn }}</p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Kode Buku : {{ $item->kode_buku }}</p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Pengarang : <a href="#"
                                                style="text-decoration: none;">{{ $item->pengarang }}</a></p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Kategori : </p>
                                        <p class="text-primary" style="font-size:0.8rem;">
                                            @foreach ($item->kategori_buku as $kategori )
                                            {{ $kategori->nama }},
                                            @endforeach
                                        </p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Stok: {{ $item->stok }}</p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Dilihat: {{ $item->views }} kali</p>
                                        <p class="card-text m-0" style="font-size:0.8rem;">Dipinjam: {{ $item->borrowed_count }} kali</p>
                                    </div>
                                    @if (Auth::user()->role == 'petugas')
                                        <div class="button-area">
                                            <button class="btn-sm btn-info px-2"><a href="/buku/{{ $item->id }}"
                                                    style="text-decoration: none; color:white;">Detail</a></button>
                                            <button class="btn-sm btn-warning px-2"><a href="/buku/{{ $item->id }}/edit"
                                                    style="text-decoration: none;color:white">Edit</a></button>
                                            <button class="btn-sm btn-danger px-3 delete-button" data-id="{{ $item->id }}">Delete</button>
                                        </div>
                                    @endif

                                    @if (Auth::user()->role == 'siswa')
                                        <div class="button-area">
                                            <button class="btn-sm btn-info px-2"> <a href="/buku/{{ $item->id }}"
                                            style="text-decoration: none; color:white;">Detail</a></button>
                                            <form action="{{ route('peminjaman.store', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn-sm btn-danger px-4" {{ $item->stok == 0 ? 'disabled' : '' }}>
                                                    Pinjam Buku
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center">Tidak ada buku yang ditemukan.</p>
                    @endforelse

                </div>

                <div class="d-flex justify-content-between mx-2 my-2">
                    <p class="text-primary my-2">Menampilkan {{ $buku->currentPage() }} dari {{ $buku->lastPage() }} Halaman</p>

                    {{ $buku->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-id');

                // Tampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Hapus Buku?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan AJAX untuk menghapus buku
                        fetch(`/buku/${itemId}/delete`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Tampilkan SweetAlert sukses
                                Swal.fire(
                                    'Dihapus!',
                                    'Buku telah dihapus.',
                                    'success'
                                ).then(() => {
                                    // Refresh halaman atau lakukan tindakan lain
                                    location.reload();
                                });
                            } else {
                                // Tampilkan SweetAlert gagal
                                Swal.fire(
                                    'Gagal!',
                                    'Buku Gagal Dihapus',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Tampilkan SweetAlert error
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat menghapus buku.',
                                'error'
                            );
                        });
                    }
                });
            });
        });
    });
</script>

@endsection