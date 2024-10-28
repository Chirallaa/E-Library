@extends('layouts.app')

@section('title', 'SIPERPUS')

@section('content')

<link rel="stylesheet" href="{{ asset('css/home/petugascard.css') }}">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-8 col-lg-6">
            <!-- Section Heading-->
            <div class="section_heading text-center wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              <h3>Petugas <span> Kami</span></h3>
              <div class="line"></div>
            </div>
          </div>
        </div>
        <div class="row">
            @foreach ($petugas as $petugas)
          <!-- Single Advisor-->
          <div class="col-12 col-sm-6 col-lg-3">
            <div class="single_advisor_profile wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
              <!-- Team Thumb-->
              <div class="advisor_thumb">
                @if ($petugas->profile && $petugas->profile->photoProfile)
                    <img src="{{ asset($petugas->profile->photoProfile) }}">
                @else
                    <img src="{{ asset('template/img/default-profile.png') }}">
                @endif
                <!-- Social Info-->
                
              </div>
              <!-- Team Details-->
              <div class="single_advisor_details_info">
                <h6>{{ $petugas->name }}</h6>
                <p class="designation">{{ $petugas->profile->jabatan }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
    </div>
    @include('part.footer')
@endsection