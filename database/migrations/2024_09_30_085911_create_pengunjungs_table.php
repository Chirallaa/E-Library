<?php

   use Illuminate\Database\Migrations\Migration;
   use Illuminate\Database\Schema\Blueprint;
   use Illuminate\Support\Facades\Schema;

   class CreatePengunjungsTable extends Migration
   {
       public function up()
       {
           Schema::create('pengunjung', function (Blueprint $table) {
               $table->id();
               $table->foreignId('user_id')->constrained()->onDelete('cascade');
               $table->date('waktu_kunjungan'); // Menyimpan tanggal saja
           });
       }

       public function down()
       {
           Schema::dropIfExists('pengunjung');
       }
   }