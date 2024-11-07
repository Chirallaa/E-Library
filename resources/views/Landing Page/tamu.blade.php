<!DOCTYPE html>
<html>
<head>
    <title>Pengunjung</title>
     <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/rfid.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <div class="center">
                    <div class="square">
                        <i class="fa fa-credit-card" style="font-size: 100px; color: #999;"></i>
                        <div class="scan"></div>
                    </div>
                </div>
                <p>Silakan tempelkan kartu Anda</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
       $(document).ready(function() {
    let rfid = '';
    $(document).on('keypress', function(e) {
        rfid += String.fromCharCode(e.which);
        if (rfid.length >= 10) { // Asumsi panjang RFID adalah 10 karakter
            $('.spinner-border').show();
            $.ajax({
                url: '{{ route('tamu') }}', // Ubah URL ke rute pengunjung
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rfid: rfid
                },
                success: function(response) {
                    $('.spinner-border').hide();
                    if (response.success) {
                        window.location.href = response.redirect; // Arahkan ke URL redirect
                    } else {
                        Swal.fire('Error', response.message, 'error'); // Tampilkan pesan kesalahan
                    }
                },
                error: function() {
                    $('.spinner-border').hide();
                    Swal.fire('Error', 'Terjadi kesalahan. Silakan coba lagi.', 'error'); // Tampilkan pesan kesalahan
                }
            });
            rfid = ''; // Reset RFID string
        }
    });
});
    </script>
</body>
</html>
