<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('detail_peminjaman', function (Blueprint $table) {
        $table->id();
        $table->foreignId('peminjaman_id')->constrained('riwayat_pinjam')->onDelete('cascade');
        $table->foreignId('pengembalian_id')->nullable()->constrained('pengembalian')->onDelete('set null');
        $table->enum('status', ['dipinjam', 'terlambat', 'dikembalikan'])->default('dipinjam');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_peminjamen');
    }
}
