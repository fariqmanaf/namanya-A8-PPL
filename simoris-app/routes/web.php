<?php

use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardDinasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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
    Route::get('/', [LoginController::class, 'index'])->name('awal');
    Route::post('/', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'index']);
    Route::get('/register/mantri', [RegisterController::class, 'mregist']);
    Route::get('/register/peternak', [RegisterController::class, 'pregist']);
    Route::post('/register/peternak', [RegisterController::class, 'storePeternak']);
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('dinas')->group(function(){
    Route::get('/dashboard', [DashboardDinasController::class, 'index']);
});

Route::middleware('mantri')->group(function(){
    Route::get('/home', function(){
        return view('mantri.layouts.home');
    });
});

Route::middleware('peternak')->group(function(){
    Route::get('/main', function(){
        return view('peternak.layouts.peternak');
    });
});

Route::get('/logout', function(){
    return redirect('/');
});