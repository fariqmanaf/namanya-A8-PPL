<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RejectedController;
use App\Http\Controllers\DinasProfileController;
use App\Http\Controllers\MantriProfileController;
use App\Http\Controllers\DashboardDinasController;
use App\Http\Controllers\PeternakProfileController;

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
    Route::get('/register/mantri/step-1', [RegisterController::class, 'mregist1']);
    Route::post('/register/mantri/step-1', [RegisterController::class, 'storeMantri1']);
    Route::get('/register/mantri/step-2', [RegisterController::class, 'mregist2']);
    Route::post('/register/mantri/step-2', [RegisterController::class, 'storeMantri2']);
    Route::get('/register/mantri/step-3', [RegisterController::class, 'mregist3']);
    Route::post('/register/mantri/step-3', [RegisterController::class, 'storeMantri3']);
    // Register Peternak
    Route::get('/register/peternak/step-1', [RegisterController::class, 'pregist1']);
    Route::post('/register/peternak/step-1', [RegisterController::class, 'storePeternak1']);
    Route::get('/register/peternak/step-2', [RegisterController::class, 'pregist2']);
    Route::post('/register/peternak/step-2', [RegisterController::class, 'storePeternak2']);
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
    Route::get('/dashboard/changepass', [DinasProfileController::class, 'edit']);
    Route::put('/dashboard/changepass', [DinasProfileController::class, 'update']);
    Route::get('/dashboard/riwayat', [DashboardDinasController::class, 'riwayat']);
});

Route::middleware('mantri')->group(function(){
    Route::get('/home', [MantriProfileController::class, 'index']);
    Route::get('/mantri/profile', [MantriProfileController::class, 'show']);
    Route::get('/mantri/profile/edit', [MantriProfileController::class, 'edit']);
    Route::put('/mantri/profile/edit', [MantriProfileController::class, 'update']);
});

Route::middleware('peternak')->group(function(){
    Route::get('/main', [PeternakProfileController::class, 'index']);
    Route::get('/peternak/profile', [PeternakProfileController::class, 'show']);
    Route::get('/peternak/profile/edit', [PeternakProfileController::class, 'edit']);
    Route::put('/peternak/profile/edit', [PeternakProfileController::class, 'update']);
});

Route::get('/logout', function(){
    return redirect('/');
});

Route::get('/back', function(){
    return redirect('/');
});