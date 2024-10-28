@extends('layouts.master')

@section('topbar')
@include('part.topbar', ['profile' => $profile])
@endsection

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('judul')
   <h2 class="text-primary"> Selamat Datang, {{ Auth::user()->name }}</h2>
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-xl-3 col-md-4 mb-4">
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
    <div class="col-xl-3 col-md-4 mb-4">
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
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-4 mb-4">
        <div class="card h-100 bg-gradient-danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm text-light font-weight-bold text-uppercase mb-1" style="font-size:.8rem;">Pinjaman Saat ini</div>
                        <div class="h5 mb-0 font-weight-bold text-light">{{ $pinjamanUser }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-3x text-light"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <h3 class="text-dark" style="font-weight: bold;">Informasi Penting Aturan Peminjaman</h3>
    <ol class="text-dark">
        <li class="text-dark">Durasi peminjaman maksimal 3 hari </li>
        <li class="text-dark">Setiap anggota hanya dapat meminjam 2 buku </li>
        <li class="text-dark">Jika buku dikembalikan lebih dari waktu yang ditentukan akan diberikan denda setiap buku Rp.1000/hari.</li>
        <li class="text-dark">Jika telah meminjam buku,silahkan ke tempat petugas untuk melakukan konfirmasi</li>
        <li class="text-dark">Jika pada saat pengembalian buku terdapat kerusakan maka harus membayar denda sesuai dengan ketentuan dari petugas</li>
        <li class="text-dark">jika buku yang dipinjam hilang maka harus melakukan konfirmasi ke petugas dan membayar sesuai dengan harga buku</li>
    </ol>
</div>
@endsection