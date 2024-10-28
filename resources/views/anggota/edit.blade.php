@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Edit Data Anggota</h1>
@endsection
<head>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@section('content')
    <form action="/anggota/{{ $user->id }}" method="post" enctype="multipart/form-data">
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
                    <label class="text-md text-primary font-weight-bold">Jenis Kelamin</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jk" id="jk-laki-laki" value="laki-laki" {{ old('jk', $profile->jk) == 'laki-laki' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jk-laki-laki">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jk" id="jk-perempuan" value="perempuan" {{ old('jk', $profile->jk) == 'perempuan' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="jk-perempuan">Perempuan</label>
                        </div>
                </div>
            </div>

            @error('jk')
                <div class="alert-danger mx-4"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="kelas" class="text-md text-primary font-weight-bold">Kelas </label>
                <input type="text"  name= "kelas" class="form-control" value="{{ old('kelas', $profile->kelas) }}">
            </div>

            @error('kelas')
                <div class="alert-danger mx-2"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="noTelp" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
                <input type="text" name="noTelp" class="form-control" value="{{ old('noTelp', $profile->noTelp) }}">
            </div>

            @error('noTelp')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="alamat" class="text-md text-primary font-weight-bold">Alamat</label>
                <input type="text" name ="alamat" class="form-control" value="{{ old('alamat', $profile->alamat) }}">
            </div>

            @error('alamat')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="form-group mx-4 my-2">
                <label for="gambar" class="text-md text-primary font-weight-bold">Tambah Photo Profile</label>
                <div class="custom-file">
                    <input type="file" name="photoProfile" value="{{ old('photoProfile', $profile->photoProfile) }}">
                </div>
            </div>

            @error('photoProfile')
                <div class="alert-danger"> {{ $message }}</div>
            @enderror

            <div class="button-save d-flex justify-content-end">
                <a href="/anggota" class="btn btn-danger mt-4 px-3 py-1">Batal</a>
                <button type="submit" class="btn btn-primary mt-4 mx-2 px-4 py-1">Simpan</button>
    </form>
    </div>
    </div>
@endsection