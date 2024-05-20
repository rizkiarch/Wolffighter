<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HadirController;
use App\Http\Controllers\KorlapController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;


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

// Route::get('/', function () {
//     return inertia('home');
// });

Route::get('/', 'HomeController@index');


// Route::get('/settings', function () {
//     return inertia('settings');
// });

Route::middleware(['auth'])->get('/', function () {
    return inertia('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return inertia('home');
    })->name('home');
});

// login
Route::middleware(['guest'])
    ->controller('AuthController')
    ->prefix('auth')->group(function () {

        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'doLogin')->name('do-login');

        Route::get('/logout', 'logout')
            ->withoutMiddleware('guest')
            ->middleware('auth')
            ->name('logout');
    });


// data master
Route::middleware(['auth'])->prefix('bumi-ngapak-raya')->group(function () {
});

// Pengadaan
Route::middleware(['auth'])->prefix('data')->group(function () {
    Route::post('korlap/tambah-korlap', [KorlapController::class, 'pesertaKorlap']);

    Route::resource('organisasi', OrganisasiController::class);
    Route::resource('region', RegionController::class);
    Route::resource('sub-region', SubRegionController::class);
    Route::resource('korlap', KorlapController::class);
    Route::resource('relawan', UserController::class);
});

// Pengadaan
Route::middleware(['auth'])->prefix('peserta')->group(function () {
    Route::post('hadir/scan', [HadirController::class, 'scan']);

    Route::resource('hadir', HadirController::class);
});

// Penjualan
Route::middleware(['auth'])->prefix('rekap-peserta')->group(function () {
    // Route::resource('rekap-peserta', RekappesertaController::class);
});



Route::controller(QrCodeController::class)->prefix('qr-code')->group(function () {
    Route::get('generate', 'generate');
});


Route::get('test', 'TestController@index');
