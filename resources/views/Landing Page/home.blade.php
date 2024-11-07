@extends('layouts.app')

@section('title', 'SIPERPUS')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/home/menu.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Caveat&display=swap" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<script src="{{ asset('js/menu.js') }}"></script>
<div class="container">
    <div class="content">
        
        <!-- Continue with existing search bar -->
        <div class="search-bar-container" style="background-image: url('{{ asset('img/bg.jpg') }}'); background-size: cover; background-position: center; padding: 20px; border-radius: 10px; text-align: center;">
            <div class="search-bar">
                <form action="{{ route('home') }}" method="GET" class="search-form">
                    <input type="text" name="query" class="search-input" placeholder="Masukkan kata kunci untuk mencari koleksi..." value="{{ request('query') }}">
                    <button type="submit" class="search-button">
                        <i class="search-icon fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        @if(request()->has('query'))
        <div class="container">
    <div class="sidebar">
        <div class="sidebar-section">
            <h3 class="collapsible">Katalog <span class="toggle-icon">+</span></h3>
            <ul>
                @foreach($kategoriList as $kategori)
                    <li>
                        <a href="#" class="filter-link" data-value="{{ $kategori->nama }}">
                            <span>{{ $kategori->nama }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <hr class="sidebar-divider">
        <div class="sidebar-section">
            <h3 class="collapsible">Pengarang <span class="toggle-icon">+</span></h3>
            <ul>
                @foreach($pengarangList as $pengarang)
                    <li>
                        <a href="#" class="filter-link" data-value="{{ $pengarang->pengarang }}">
                            <span>{{ $pengarang->pengarang }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <hr class="sidebar-divider">
        <div class="sidebar-section">
            <h3 class="collapsible">Tahun Terbit <span class="toggle-icon">+</span></h3>
            <ul>
                @foreach($tahunList as $tahun)
                    <li>
                        <a href="#" class="filter-link" data-value="{{ $tahun->tahun_terbit }}">
                            <span>{{ $tahun->tahun_terbit }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

                <!-- main content -->
                <div class="main-content">
                    @if(request('query') === '')
                        <!-- Display all books when query is empty (/query=) -->
                        <div id="all-books" class="book-section">
                            <h2>Semua Buku</h2>
                            <div class="row">
                                @foreach ($allBooks as $buku)
                                    <div class="col-12 col-sm-6 col-lg-3">
                                    <a href="{{ route('detail', ['id' => $buku->id]) }}" style="text-decoration: none; color: inherit;">
                                        <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                            <div class="advisor_thumb">
                                                <a style="text-decoration: none; color: inherit;" href="{{ route('detail', ['id' => $buku->id]) }}">
                                                    @if ($buku->gambar)
                                                        <img src="{{ asset('images/' . $buku->gambar) }}">
                                                    @else
                                                        <img src="{{ asset('img/default-profile.png') }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="single_advisor_details_info">
                                                <h6>{{ $buku->judul }}</h6>
                                                <p class="designation">{{ $buku->pengarang }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                    @elseif(isset($searchResults) && $searchResults->count() > 0)
                        <!-- Display search results -->
                        <div id="search-results" class="book-section">
                            <div class="row">
                                @foreach ($searchResults as $buku)
                                    <div class="col-12 col-sm-6 col-lg-3">
                                    <a href="{{ route('detail', ['id' => $buku->id]) }}" style="text-decoration: none; color: inherit;">
                                        <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                            <div class="advisor_thumb">
                                                <a style="text-decoration: none; color: inherit;" href="{{ route('detail', ['id' => $buku->id]) }}">
                                                    @if ($buku->gambar)
                                                        <img src="{{ asset('images/' . $buku->gambar) }}">
                                                    @else
                                                        <img src="{{ asset('img/default-profile.png') }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="single_advisor_details_info">
                                                <h6>{{ $buku->judul }}</h6>
                                                <p class="designation">{{ $buku->pengarang }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div id="search-results" class="book-section">
                            <h2>Buku tidak tersedia</h2>
                        </div>
                    @endif
                </div>
            </div>
        @else

 <!-- Display dashboard content when no query -->
 <div class="dashboard-quick-links">
                <div class="dashboard-link">
                    <a style="text-decoration: none; color: inherit;" href="{{ route('register') }}">
                        <i class="fa fa-credit-card"></i>
                        <span>Daftar</span>
                    </a>
                </div>
                <div class="dashboard-link">
                    <a style="text-decoration: none; color: inherit;" href="{{ route('scan.rfid') }}">
                        <i class="fa fa-users"></i>
                        <span>Tamu</span>
                    </a>
                </div>
                <div class="dashboard-link">
                    <a style="text-decoration: none; color: inherit;" href="{{ route('showPetugas') }}">
                        <i class="fa fa-info-circle"></i>
                        <span>Hubungi Kami</span>
                    </a>
                </div>
            </div>

<div class="pembatas">
    
    </div>
<div class="library-content">
    <div class="whats-happening">
        <div class="tutorial">
        <h2>PERPUSTAKAAN</h2>
        <div id="libraryCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/bg.jpg') }}" class="d-block w-100" alt="Teen Pumpkin Decorating Contest">
                </div>
                <!-- Add more carousel items here -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#libraryCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#libraryCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#libraryCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#libraryCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#libraryCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <!-- Add more indicators as needed -->
            </div>
        </div>
    </div>

    <div class="library-stats">
    <div class="stats-container">
        <div class="stat-item" onmouseover="animateCount(this, {{ $bukuList->count() }}, 'booksCount')">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-info">
                <h3 id="booksCount">0</h3>
                <p>Jumlah Buku</p>
            </div>
        </div>
        <div class="stat-item" onmouseover="animateCount(this, {{ $kategoriList->count() }}, 'catalogsCount')">
            <div class="stat-icon">
                <i class="fas fa-list"></i>
            </div>
            <div class="stat-info">
                <h3 id="catalogsCount">0</h3>
                <p>Jumlah Katalog</p>
            </div>
        </div>
    </div>
</div>
            <!-- New Arrivals section -->
            <div class="container">
    <div class="content">
        <div class="new-arrivals-section">
            <div class="new-arrivals-header">
                <h2>NEW ARRIVALS</h2>
            </div>

                <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($bukuList->chunk(4) as $chunk)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <div class="row">
                        @foreach ($chunk as $buku)
                            <div class="col-md-3">
                                <img src="{{ asset('images/' . $buku->gambar) }}" alt="{{ $buku->judul }}" class="d-block w-100">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="pembatas">
    </div>

            <!-- Tutorial section -->
            <div class="container">
                <div class="content">
                    <div class="tutorial">
                        <h2>Tata Cara Mendaftar Menjadi Anggota Perpustakaan</h2>
                        <div class="tutorial-steps">
                            <div class="tutorial-step">
                                <i class="fa fa-map-marker"></i>
                                <span>DATANG KE PERPUSTAKAAN</span>
                            </div>
                            <div class="tutorial-step">
                                <i class="fa fa-user"></i>
                                <span>MENDATANGI PUSTAKAWAN</span>
                            </div>
                            <div class="tutorial-step">
                                <i class="fa fa-id-card"></i>
                                <span>MEMINTA KARTU ANGGOTA</span>
                            </div>
                            <div class="tutorial-step">
                                <i class="fa fa-pencil"></i>
                                <span>MENGISI BIODATA ANGGOTA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@include('part.footer')
@endsection
