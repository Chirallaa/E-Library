@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('content')
    <div class="card">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">Profile</h4>
        </div>
        <div class="row">
            <div class="col-auto ml-5 mr-5 my-4">
                @if ($profile && $profile->photoProfile)
                    <img src="{{ asset($profile->photoProfile) }}" style="width:150px;height:150px;border-radius:100px">
                @else
                    <img src="{{ asset('template/img/default-profile.png') }}" style="width:100px;height:100px;border-radius:50px">
                @endif
            </div>
            <div class="col-auto mx-4">
                <div class="form-group mb-3">
                    <label for="nama" class="text-lg text-primary font-weight-bold">Nama Lengkap</label>
                    @if ($profile && $profile->user)
                        <h4>{{ $profile->user->name }}</h4>
                    @else
                        <h4>Data tidak tersedia</h4>
                    @endif
                </div>

                @if ($profile && $profile->user->role == 'siswa')

                    <div class="form-group mb-3">
                        <label for="jk" class="text-lg text-primary font-weight-bold">Jenis Kelamin</label>
                        <h4>{{ $profile->jk ?? 'Data tidak tersedia' }}</h4>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="kelas" class="text-lg text-primary font-weight-bold">Kelas</label>
                        <h4>{{ $profile->kelas ?? 'Data tidak tersedia' }}</h4>
                    </div>
                @endif

                @if ($profile && $profile->user->role == 'petugas')
                    <div class="form-group mb-3">
                        <label for="jabatan" class="text-lg text-primary font-weight-bold">Jabatan</label>
                        <h4>{{ $profile->jabatan }}</h4>
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label for="alamat" class="text-lg text-primary font-weight-bold">Alamat</label>
                    @if ($profile)
                        <h4>{{ $profile->alamat }}</h4>
                    @else
                        <h4>Data tidak tersedia</h4>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="noTelp" class="text-lg text-primary font-weight-bold">Nomor Telephone</label>
                    @if ($profile)
                        <h4>{{ $profile->noTelp }}</h4>
                    @else
                        <h4>Data tidak tersedia</h4>
                    @endif
                </div>
            </div>
        </div>
        <div class="edit d-flex justify-content-end my-4 mx-4">
            @if ($profile)
                <a href="/profile/{{ $profile->id }}/edit" class="btn btn-primary px-5">Edit Profile</a>
            @else
                <a href="#" class="btn btn-primary px-5 disabled">Edit Profile</a>
            @endif
        </div>
    </div>
@endsection