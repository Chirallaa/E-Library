<!-- resources/views/auth/login.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
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
            <p>Silakan tempelkan kartu untuk login.</p>
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
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
                      alert(response.message);
                  }
              },
              error: function() {
                  $('#loading-spinner').hide();
                  alert('Terjadi kesalahan. Silakan coba lagi.');
              }
          });
          rfid = ''; // Reset RFID string
      }
  });
});
    </script>
</body>
</html>

