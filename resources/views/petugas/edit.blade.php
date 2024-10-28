@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Edit Data Petugas</h1>
@endsection

@section('content')
    <form action="/petugas/{{ $user->id }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="card pb-5">
            <div class="form-group mx-4 my-2">
                <label for="nama" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
            </div>

            @error('name')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="jabatan" class="text-md text-primary font-weight-bold">Jabatan</label>
                <input type="text"  name= "jabatan" class="form-control" value="{{ old('jabatan', $profile->jabatan) }}">
            </div>

            @error('jabatan')
                <div class="alert-danger mx-2"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="alamat" class="text-md text-primary font-weight-bold">Alamat</label>
                    <input type="text" name ="alamat" class="form-control" value="{{ old('alamat',optional($profile)->alamat) }}">
            </div>

            @error('alamat')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="noTelp" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
                <input type="text" name="noTelp" class="form-control" value="{{ old('noTelp', $user->noTelp) }}">
            </div>

            @error('noTelp')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="gambar" class="text-md text-primary font-weight-bold">Tambah Photo Profile</label>
                <div class="custom-file">
                    <input type="file" name="photoProfile" value="{{ old('photoProfile', optional($profile)->photoProfile) }}">
                </div>
            </div>

            @error('photoProfile')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="button-save d-flex justify-content-end">
                <a href="/petugas" class="btn btn-danger mt-4 px-3 py-1">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-4 py-1">Simpan</button>
    </form>
    </div>
    </div>
@endsection