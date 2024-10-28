@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Tambah Petugas</h1>
@endsection

@section('content')
<form action="/petugas" method="post">
    @csrf
    <div class="card pb-5">
        <div class="form-group mx-4 my-2">
            <label for="nama" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
        </div>

        @error('name')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="jabatan" class="text-md text-primary font-weight-bold">Jabatan</label>
            <input type="text" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}">
        </div>

        @error('jabatan')
        <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="nama" class="text-md text-primary font-weight-bold">Alamat</label>
            <input type="text" id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}">
        </div>

        @error('alamat')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="nama" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
            <input type="text" id="alamat" class="form-control @error('noTelp') is-invalid @enderror" name="noTelp" value="{{ old('noTelp') }}">
        </div>

        @error('noTelp')
            <div class="alert-danger"> {{ $message }}</div>
        @enderror

        <div class="form-group mx-4 my-2">
            <label for="rfid" class="text-md text-primary font-weight-bold">RFID</label>
            <input id="rfid" type="text" class="form-control @error('rfid') is-invalid @enderror" name="rfid" value="{{ old('rfid') }}" required>
            @error('rfid')
                <div class="alert-danger"> {{ $message }}</div>
                                @enderror
        </div>

        <div class="button-save d-flex justify-content-end">
            <button type="submit" class="btn btn-primary mt-4 mx-4 px-5 py-1">Simpan</button>
        </form>
        </div>
    </div>
@endsection
