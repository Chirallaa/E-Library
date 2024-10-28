<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CetakLaporanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatPinjamController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/detail/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/pustakawan', [HomeController::class, 'showPetugas'])->name('showPetugas');
Route::get('/Guest', [PengunjungController::class, 'scanRfid'])->name('scan.rfid'); // Tambahkan rute ini
Route::post('/tamu', [PengunjungController::class, 'tamu'])->name('tamu'); 
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/most-borrowed-books', [HomeController::class, 'mostBorrowedBooks'])->name('most.borrowed.books');
Route::get('/most-viewed-books', [HomeController::class, 'mostViewedBooks'])->name('most.viewed.books');
Auth::routes();

Route::middleware(['auth', 'session.timeout'])->group(function () {
    
    Route::resource('/pengunjung', PengunjungController::class);
    Route::get('/pengunjung', [PengunjungController::class, 'index'])->name('pengunjung.index');
    Route::get('/pengunjung/download-pdf/{start_date}/{end_date}', [PengunjungController::class, 'downloadPDF'])->name('pengunjung.downloadPDF');
   
    Route::resource('katalog', KategoriController::class);
    Route::delete('/katalog/{id}/delete', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    
    Route::resource('buku', BukuController::class);
    Route::delete('/buku/{id}/delete', [BukuController::class, 'destroy'])->name('buku.destroy');

    Route::resource('anggota', AnggotaController::class);
    Route::delete('/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    Route::resource('petugas', PetugasController::class);
    Route::delete('/petugas/{id}', [PetugasController::class, 'destroyPetugas'])->name('petugas.destroy');

    Route::resource('profile', ProfileController::class)->only('index','update','edit');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('peminjaman', RiwayatPinjamController::class);

    Route::get('/peminjaman/create/{buku_id}', [RiwayatPinjamController::class, 'create'])->name('peminjaman.create');
    Route::get('peminjaman', [RiwayatPinjamController::class, 'index'])->name('peminjaman.tampil');
    Route::post('/peminjaman/store/{id}', [RiwayatPinjamController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/download-pdf/{start_date}/{end_date}', [RiwayatPinjamController::class, 'downloadPDF'])->name('peminjaman.downloadPDF');
    
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/search', [PengembalianController::class, 'search'])->name('pengembalian.search');
    Route::post('/pengembalian/search', [PengembalianController::class, 'search'])->name('pengembalian.search');
    Route::post('/pengembalian/return', [PengembalianController::class, 'returnBook'])->name('pengembalian.return');
    Route::put('/pengembalian/update-denda-manual/{id}', [PengembalianController::class, 'updateDendaManual'])->name('pengembalian.updateDendaManual');

});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::post('/register/checkRFID', [RegisterController::class, 'checkRFID'])->name('register.checkRFID');
Route::get('/register/biodata', [RegisterController::class, 'showBiodataForm'])->name('register.biodata');
Route::post('/register/biodata', [RegisterController::class, 'storeBiodata'])->name('register.storeBiodata');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

