<!DOCTYPE html>
<html>
<head>
    <title>Halaman Pendaftaran</title>
    <meta name="csrf-token" content="token_csrf_anda">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/rfid.css">
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
                <p>Silakan Tempelkan Kartu Untuk Melanjutkan Proses pendaftaran</p>
                <div class="spinner-border text-primary" role="status" id="loading-spinner" style="display: none;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let rfid = '';
            let rfidLength = 10; // Panjang RFID yang diharapkan
            let timeout;

            $(document).on('keypress', function(e) {
                clearTimeout(timeout);
                rfid += String.fromCharCode(e.which);

                // Set timeout untuk reset string jika tidak ada input baru dalam 100ms
                timeout = setTimeout(function() {
                    rfid = '';
                }, 100);

                if (rfid.length >= rfidLength) {
                    $('#loading-spinner').show();
                    $.ajax({
                        url: '/register/checkRFID',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            rfid: rfid
                        },
                        success: function(response) {
                            $('#loading-spinner').hide();
                            if (response.success) {
                                window.location.href = '/register/biodata';
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('#loading-spinner').hide();
                            alert('Terjadi kesalahan. Silakan coba lagi. ' + xhr.responseText);
                        }
                    });
                    rfid = ''; // Reset RFID string
                }
            });
        });
    </script>
</body>
</html>