<?php

use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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
    // Register
    Route::get('/register', [RegisterController::class, 'index']);
    Route::get('/register/mantri', [RegisterController::class, 'mregist']);
    Route::post('/register/mantri', [RegisterController::class, 'storeMantri']);
    Route::get('/register/peternak', [RegisterController::class, 'pregist']);
    Route::post('/register/peternak', [RegisterController::class, 'storePeternak']);
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('dinas')->group(function(){
    Route::get('/dashboard', [DashboardDinasController::class, 'index']);
    Route::get('/dashboard/changepass', [DinasProfileController::class, 'edit']);
    Route::put('/dashboard/changepass', [DinasProfileController::class, 'update']);
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