<!-- resources/views/auth/biodata.blade.php -->
@extends('layouts.welcome')

@section('content')
<link rel="stylesheet" href="{{ asset('/css/user.css') }}">
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-7">
            <div class="card">
            <a href="{{ url('/') }}" class="text-dark position-absolute" style="text-decoration: none; font-size: 1.5rem; top: 10px; right: 20px;">&times;</a>
                <div class="card-header text-lg text-dark">{{ __('Daftar Anggota') }}</div>
                
                <div class="card-body">
                    <form id="rfid-register-form" method="POST" action="{{ route('register.storeBiodata') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-dark">{{ __('Nama Lengkap') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end text-dark">{{ __('Jenis Kelamin') }}</label>
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="jk-laki-laki" value="laki-laki" {{ old('jk') == 'laki-laki' ? 'checked' : '' }} required>
                                    <label class="form-check-label text-dark" for="jk-laki-laki">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jk" id="jk-perempuan" value="perempuan" {{ old('jk') == 'perempuan' ? 'checked' : '' }} required>
                                    <label class="form-check-label text-dark" for="jk-perempuan">Perempuan</label>
                                </div>
                                @error('jk')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kelas" class="col-md-4 col-form-label text-md-end text-dark">{{ __('Kelas') }}</label>
                            <div class="col-md-6">
                                <input id="kelas" type="text" class="form-control @error('kelas') is-invalid @enderror" name="kelas" value="{{ old('kelas') }}" required>
                                @error('kelas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="noTelp" class="col-md-4 col-form-label text-md-end text-dark">{{ __('No. Telp') }}</label>
                            <div class="col-md-6">
                                <input id="noTelp" type="text" class="form-control @error('noTelp') is-invalid @enderror" name="noTelp" value="{{ old('noTelp') }}" required>
                                @error('noTelp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-md-4 col-form-label text-md-end text-dark">{{ __('Alamat') }}</label>
                            <div class="col-md-6">
                                <textarea id="alamat" class="form-control @error('alamat') is-invalid @enderror" name="alamat" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-5 offset-md-4">
                                <button type="submit" class="btn btn-primary px-5">
                                    {{ __('Daftar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection