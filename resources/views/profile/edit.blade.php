@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Edit Profile</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Edit Profile</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Edit Profile -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mx-4 my-2">
                    <label for="nama" class="text-md text-primary font-weight-bold mt-2">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $profile->user->name) }}">
                </div>

                @error('name')
                    <div class="alert-danger"> {{ $message }}</div>
                @enderror

                @if ($profile->user->role == 'siswa')

                    <div class="form-group mx-4 my-2">
                        <label for="kelas" class="text-md text-primary font-weight-bold">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $profile->kelas) }}">
                    </div>

                    @error('kelas')
                        <div class="alert-danger mx-2"> {{ $message }}</div>
                    @enderror
                @endif

                @if ($profile->user->role == 'petugas')
                    <div class="form-group mx-4 my-2">
                        <label for="jabatan" class="text-md text-primary font-weight-bold">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $profile->user->jabatan) }}">
                    </div>

                    @error('jabatan')
                        <div class="alert-danger mx-2"> {{ $message }}</div>
                    @enderror
                @endif

                <div class="form-group mx-4 my-2">
                    <label for="nama" class="text-md text-primary font-weight-bold">Alamat</label>
                    <input type="text" name="alamat"class="form-control" value="{{ old('alamat', $profile->alamat) }}">
                </div>

                @error('alamat')
                    <div class="alert-danger"> {{ $message }}</div>
                @enderror

                <div class="form-group mx-4 my-2">
                    <label for="nama" class="text-md text-primary font-weight-bold">Nomor Telepon</label>
                    <input type="text" name="noTelp" class="form-control" value="{{ old('noTelp', $profile->noTelp) }}">
                </div>

                @error('noTelp')
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
                    <label for="photoProfile" class="text-md text-primary font-weight-bold">Tambah Photo Profile</label>
                    <div class="custom-file">
                    <input type="file" name="photoProfile" id="photoProfile"
                            value="{{ old('photoProfile', $profile->photoProfile) }}">
                    </div>
                </div>

                @error('photoProfile')
                    <div class="alert-danger"> {{ $message }}</div>
                @enderror

                <div class="button-save d-flex justify-content-end">
                    <a href="/profile" class="btn btn-danger mt-4 py-1 px-4">Batal</a>
                    <button type="submit"class="btn btn-primary mt-4 mx-2 px-5 py-1">Simpan</button>
            </form>
        </div>
    </div>
@endsection