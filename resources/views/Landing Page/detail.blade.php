@extends('layouts.app')

@section('title', 'SIPERPUS')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin: 0 auto;
            max-width: 910px;
        }

        .choose {
            width: 100%;
            height: 40px;
        }
        .fa {
            margin-right: 20px;
            font-size: 30px;
            color: gray;
            float: right;
        }
        /******************************************
        Book stuff
        *******************************************/

        .book {
            display: inline-block;
            width: 230px;
            height: auto;
            box-shadow: 0 0 20px #aaa;
            margin: 25px;
            padding: 10px;
            vertical-align: top;
            transition: transform 0.2s;
        }
        .book:hover {
            transform: scale(1.05);
        }
        .cover {
            border: 2px solid gray;
            height: 300px;
            overflow: hidden;
        }

        .cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book p {
            margin-top: 12px;
            font-size: 20px;
            text-align: center;
        }

        .book .author {
            font-size: 15px;
            text-align: center;
        }
        @media (max-width: 941px) {
            .container {
                max-width: 700px;
            }
            .book {
                margin: 49px;
            }
        }
        @media (max-width: 730px) {
            .book {
                display: block;
                margin: 0 auto;
                margin-top: 50px;
            }
        }

        /*********************************
        other
        **********************************/

        h1 {
            color: black;
            text-align: center;
            font-size: 50px;
            margin-bottom: -3px;
        }

        /**********************************
        display change
        ***********************************/
        /*book height smaller, cover opacity, move text onto cover and star too
        animate it */
        #list-th:target .book {
            height: 100px;
            width: 250px;
            padding: 10px;
            margin: 25px auto 25px auto;
        }

        #list-th:target .cover {
            width: 246px;
        }

        #list-th:target img {
            opacity: .1;
        }

        #list-th:target p {
            margin-top: -62px;
            margin-left: 20px;
        }
        /* remove button? */
        #large-th:target .book {
            height: 390px;
        }

        /* Tambahkan margin pada kolom keterangan buku */
        .book-details {
            margin-left: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="{{ url()->previous() }}" class="btn btn-primary mb-3">Kembali</a> <!-- Tombol kembali ke dashboard -->
        <div class="row">
            <div class="col-md-3">
                <div class="book">
                    <div class="cover">
                        <img src="{{ $buku->gambar ? asset('images/' . $buku->gambar) : asset('img/default-profile.png') }}" alt="Book Cover">
                    </div>
                </div>
            </div>
            <div class="col-md-9 book-details"> <!-- Tambahkan class book-details -->
                <h1>{{ $buku->judul }}</h1>
                <h4>Informasi Detail</h4>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Judul Buku</th>
                            <td>{{ $buku->judul ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>ISBN</th>
                            <td>{{ $buku->isbn }}</td>
                        </tr>
                       
                        <tr>
                            <th>Pengarang</th>
                            <td>{{ $buku->pengarang }}</td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>{{ $buku->penerbit }}</td>
                        </tr>
                       <tr>
                            <th>Katalog</th>
                            <td>{{ $kategori->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $buku->tahun_terbit }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Halaman</th>
                            <td>{{ $buku->halaman }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

@include('part.footer')
@endsection