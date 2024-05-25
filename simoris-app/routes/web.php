<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RejectedController;
use App\Http\Controllers\DinasProfileController;
use App\Http\Controllers\MantriProfileController;
use App\Http\Controllers\DashboardDinasController;
use App\Http\Controllers\DataMantriController;
use App\Http\Controllers\MantriFeatureController;
use App\Http\Controllers\PeternakFeaturesController;
use App\Http\Controllers\PeternakProfileController;
use App\Http\Controllers\RegisterMantriController;
use App\Http\Controllers\RegisterPeternakController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function(){
    // Landing Page
    Route::get('/', [LoginController::class, 'index'])->name('awal');
    Route::post('/', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'index']);
    // Register Mantri
    Route::get('/register/mantri/step-1', [RegisterMantriController::class, 'mregist1']);
    Route::post('/register/mantri/step-1', [RegisterMantriController::class, 'storeMantri1']);
    Route::get('/register/mantri/step-2', [RegisterMantriController::class, 'mregist2']);
    Route::post('/register/mantri/step-2', [RegisterMantriController::class, 'storeMantri2']);
    Route::get('/register/mantri/step-3', [RegisterMantriController::class, 'mregist3']);
    Route::post('/register/mantri/step-3', [RegisterMantriController::class, 'storeMantri3']);
    // Register Peternak
    Route::get('/register/peternak/step-1', [RegisterPeternakController::class, 'pregist1']);
    Route::post('/register/peternak/step-1', [RegisterPeternakController::class, 'storePeternak1']);
    Route::get('/register/peternak/step-2', [RegisterPeternakController::class, 'pregist2']);
    Route::post('/register/peternak/step-2', [RegisterPeternakController::class, 'storePeternak2']);
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('rejected')->group(function(){
    Route::get('/register/mantri/edit', [RejectedController::class, 'index']);
    Route::put('/register/mantri/edit', [RejectedController::class, 'update']);
    Route::post('/back', [RejectedController::class, 'back']);
});

Route::middleware('dinas')->group(function(){
    Route::get('/dashboard', [DashboardDinasController::class, 'index']);
    Route::post('/dashboard', [DashboardDinasController::class, 'createStok']);
    Route::get('/dashboard/changepass', [DinasProfileController::class, 'edit']);
    Route::put('/dashboard/changepass', [DinasProfileController::class, 'update']);
    Route::get('/dashboard/riwayat', [DashboardDinasController::class, 'riwayat']);
    Route::get('/dashboard/preview', [DashboardDinasController::class, 'preview']);
    Route::post('/dashboard/preview', [DashboardDinasController::class, 'previewpost']);
    Route::get('dashboard/data-mantri', [DataMantriController::class, 'index']);
    Route::get('dashboard/data-mantri/confirm', [DataMantriController::class, 'confirm']);
    Route::put('dashboard/data-mantri/confirm', [DataMantriController::class, 'postConfirm']);
    Route::get('dashboard/laporanIB', [DashboardDinasController::class, 'laporanIB']);
    Route::get('dashboard/laporanIB/{individuals}', [DashboardDinasController::class, 'ibDetail']);
    Route::get('dashboard/pengajuan-stok', [DashboardDinasController::class, 'pengajuanStok']);
    Route::post('dashboard/pengajuan-stok', [DashboardDinasController::class, 'postPengajuan']);
    Route::get('dashboard/pengajuan-stok/pengambilan', [DashboardDinasController::class, 'pengambilanStok']);
    Route::post('dashboard/pengajuan-stok/pengambilan', [DashboardDinasController::class, 'pengambilanPost']);
    Route::get('dashboard/pengajuan-stok/confirmed', [DashboardDinasController::class, 'confirmedPengajuan']);
    Route::get('dashboard/pengajuan-stok/rejected', [DashboardDinasController::class, 'rejectedPengajuan']);
    Route::get('dashboard/akumulasi', [DashboardDinasController::class, 'akumulasi'])->name('akumulasi');
    Route::get('dashboard/akumulasi/{year}', [DashboardDinasController::class, 'showByYear'])->name('laporan.year');    
});

Route::middleware('mantri')->group(function(){
    Route::get('/home', [MantriProfileController::class, 'index']);
    Route::get('/home/profile', [MantriProfileController::class, 'edit']);
    Route::put('/home/profile', [MantriProfileController::class, 'update']);
    Route::get('/home/profile/document', [MantriProfileController::class, 'dokumenMantri']);
    Route::get('/home/profile/changepass', [MantriProfileController::class, 'changepass']);
    Route::put('/home/profile/changepass', [MantriProfileController::class, 'updatepass']);
    Route::get('/home/distribusi', [MantriFeatureController::class, 'index']);
    Route::post('/home/distribusi', [MantriFeatureController::class, 'indexPost']);
    Route::get('/home/laporanIB', [MantriFeatureController::class, 'laporanIB']);
    Route::get('/home/laporanIB/{individuals}', [MantriFeatureController::class, 'dataSapi']);
    Route::post('/home/laporanIB/{individuals}', [MantriFeatureController::class, 'dataSapiPost']);
    Route::get('/home/laporanIB/{individuals}/sapi-{dataSapi}', [MantriFeatureController::class, 'ibSapi']);
    Route::post('/home/laporanIB/{individuals}/sapi-{dataSapi}', [MantriFeatureController::class, 'ibSapiPost']);
    Route::put('/home/laporanIB/{individuals}/sapi-{dataSapi}', [MantriFeatureController::class, 'editIb']);
    Route::get('/home/riwayatIB', [MantriFeatureController::class, 'riwayatIB']);
    Route::get('/home/riwayat-pengajuan', [MantriFeatureController::class, 'riwayatPengajuan']);
    Route::post('/home/riwayat-pengajuan', [MantriFeatureController::class, 'riwayatPost']);
});

Route::middleware('peternak')->group(function(){
    Route::get('/main', [PeternakProfileController::class, 'index']);
    Route::get('/main/profile', [PeternakProfileController::class, 'edit']);
    Route::put('/main/profile', [PeternakProfileController::class, 'update']);
    Route::get('/main/profile/edit', [PeternakProfileController::class, 'changepass']);
    Route::put('/main/profile/edit', [PeternakProfileController::class, 'updatepass']);
    Route::get('/main/data-mantri', [PeternakFeaturesController::class, 'dataMantri']);
    Route::get('/main/data-mantri/near', [PeternakFeaturesController::class, 'dataMantriTerdekat']);
    Route::get('/main/laporan-ib', [PeternakFeaturesController::class, 'laporanIB']);
    Route::get('/main/laporan-ib/sapi-{dataSapi}', [PeternakFeaturesController::class, 'laporanIBDetail']);
});

Route::get('/logout', function(){
    return redirect('/');
});

Route::get('/back', function(){
    return redirect('/');
});

Route::get('/previous', function(){
    if (Auth::user()->roles_id === 1){
        return redirect('/dashboard');
    } else if (Auth::user()->roles_id === 2){
        return redirect('/home');
    } else if (Auth::user()->roles_id === 3){
        return redirect('/main');
    }
});