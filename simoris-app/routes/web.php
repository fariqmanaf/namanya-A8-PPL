<?php

use Doctrine\DBAL\Driver\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardDinasController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [LoginController::class, 'index'])->name('awal')->middleware('guest');
Route::post('/', [LoginController::class, 'login']);;

Route::middleware('auth')->group(function(){
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::middleware('dinas')->group(function(){
    Route::get('/dashboard', [DashboardDinasController::class, 'index']);
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