@extends('layouts.master')

@section('sidebar')
    @include('part.sidebar')
@endsection

@section('topbar')
    @include('part.topbar')
@endsection

@section('judul')
    <h1 class="text-primary">Form Pengembalian Buku</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('pengembalian.search') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_name" class="text-primary font-weight-bold">Nama Peminjam</label>
                    <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Ketik nama peminjam">
                    <input type="hidden" name="user_id" id="user_id">
                </div>
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            @if (isset($peminjaman) && $peminjaman->count() > 0)
                <h3 class="mt-4">Data Peminjaman</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Wajib Kembali</th>
                            <th>Denda Keterlambatan</th>
                            <th>Denda Manual</th>
                            <th>Kondisi Buku</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                            <tr>
                                <td>{{ $item->buku ? $item->buku->judul : 'Buku tidak ditemukan' }}</td>
                                <td>{{ $item->tanggal_pinjam }}</td>
                                <td>{{ $item->tanggal_wajib_kembali }}</td>
                                <td>Rp {{ $item->pengembalian ? $item->pengembalian->hitungDendaKeterlambatan() : '0' }}</td>
                                <td>
                                    <form action="{{ url('/pengembalian/return') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="peminjaman_id" value="{{ $item->id }}">
                                        <span class="denda-manual-text">Rp. 0</span>
                                        <input type="numbering" name="denda_manual" class="form-control denda-manual" placeholder="Masukkan denda kerusakan" value="0" style="display: none;">
                                </td>
                                <td>
                                    <select name="kondisi" class="form-control kondisi">
                                        <option value="baik" selected>Baik</option>
                                        <option value="rusak">Rusak</option>
                                        <option value="hilang">Hilang</option>
                                    </select>
                                </td>
                                <td>
                                        <button type="submit" class="btn btn-success mt-2">Kembalikan Buku</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-4">Tidak ada data peminjaman yang ditemukan.</p>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            var users = [
                @foreach ($users as $user)
                    { id: "{{ $user->id }}", label: "{{ $user->name }}" },
                @endforeach
            ];

            $("#user_name").autocomplete({
                source: users,
                select: function(event, ui) {
                    $("#user_name").val(ui.item.label);
                    $("#user_id").val(ui.item.id);
                    return false;
                }
            });

            // Handle kondisi change event
            $('.kondisi').change(function() {
                var kondisi = $(this).val();
                var dendaManualInput = $(this).closest('tr').find('.denda-manual');
                var dendaManualText = $(this).closest('tr').find('.denda-manual-text');
                if (kondisi === 'rusak' || kondisi === 'hilang') {
                    dendaManualInput.show().prop('disabled', false);
                    dendaManualText.hide();
                } else {
                    dendaManualInput.hide().prop('disabled', true);
                    dendaManualText.show().text('Rp. 0');
                }
            });
        });
    </script>
@endpush