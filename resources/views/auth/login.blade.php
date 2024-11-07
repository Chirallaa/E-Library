<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
            <p>Silakan tempelkan kartu untuk login.</p>
            </div>
        </div>
    </div>
    <form id="loginForm">
        <input type="text" id="rfidInput" placeholder="Masukkan RFID" style="display: none;">
        <button type="submit" style="display: none;">Login</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let rfid = '';
            $(document).on('keypress', function(e) {
                rfid += String.fromCharCode(e.which);
                if (rfid.length >= 10) { 
                    $('#loading-spinner').show();
                    $.ajax({
                        url: '{{ route('login') }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            rfid: rfid
                        },
                        success: function(response) {
                            $('#loading-spinner').hide();
                            if (response.success) {
                                window.location.href = response.redirect;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            $('#loading-spinner').hide();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan. Silakan coba lagi.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                    rfid = ''; // Reset RFID string
                }
            });
        });

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form dari pengiriman default

            const rfid = document.getElementById('rfidInput').value; // Ambil nilai RFID

            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rfid: rfid })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Jika login berhasil
                    window.location.href = data.redirect; // Redirect ke dashboard
                } else {
                    // Jika login gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>