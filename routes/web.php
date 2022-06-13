<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

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

//LOGIN
Route::get('/login', ['as' => 'login.web', 'uses' => 'SignPage\LoginController@index']);
Route::post('/login/{role}', ['as' => 'login.post', 'uses' => 'SignPage\LoginController@checkUserLogin']);

//LOGIN ADMIN
Route::get('/admin', ['as' => 'loginadmin.web', 'uses' => 'SignPage\AdminAuthController@index']);
Route::post('/loginAdmin/{role}', ['as' => 'loginadmin.post', 'uses' => 'SignPage\LoginController@checkUserLogin']);

//GOOGLE LOGIN
Route::get('google', ['as' => 'auth/google', 'uses' => 'SocialiteAuthController@googleRedirect']);
Route::get('/auth/google-callback', ['uses' => 'SocialiteAuthController@loginWithGoogle']);

Route::middleware(['auth.login.information'])->group(function () {
    Route::post('/logout', ['as' => 'logout.post', 'uses' => 'SignPage\LoginController@logout']);

    // User
    Route::middleware(['is.newUser'])->group(function () {
        Route::get('/new-lapak', ['as' => 'new-lapak', 'uses' => 'MainController\Toko\LapakController@create']);
        Route::post('/create-lapak', ['as' => 'create-lapak', 'uses' => 'MainController\Toko\LapakController@store']);
    });

    Route::middleware(['is.User'])->group(function () {
        Route::get('/', ['as' => 'home', 'uses' => 'MainController\Dashboard\DashboardController@index']);
        Route::get('/histori-penjualan', ['as' => 'historiku', 'uses' => 'MainController\Histori\HistoriController@index']);
        Route::group(['prefix' => 'toko', 'as' => 'tokoku.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'MainController\Toko\LapakController@index']);
            Route::put('/update', ['as' => 'updateLapak', 'uses' => 'MainController\Toko\LapakController@update']);
        });
        Route::group(['prefix' => 'produk', 'as' => 'produkku.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'MainController\Produk\ProdukController@index']);
            Route::get('/create-produk', ['as' => 'viewCreateProduk', 'uses' => 'MainController\Produk\ProdukController@viewCreateProduk']);
            Route::post('/create-produk', ['as' => 'createProduk', 'uses' => 'MainController\Produk\ProdukController@createProduk']);
            Route::get('/{id_produk}/update-produk', ['as' => 'viewUpdateProduk', 'uses' => 'MainController\Produk\ProdukController@viewUpdateProduk']);
            Route::post('/update-produk', ['as' => 'updateProduk', 'uses' => 'MainController\Produk\ProdukController@updateProduk']);
        });
    });

    // ADMIN
    Route::middleware(['is.admin'])->group(function () {
        Route::get('/register', ['as' => 'register.web', 'uses' => 'SignPage\AdminAuthController@redirectDaftarAdmin']);
        Route::post('/register', ['as' => 'register.post', 'uses' => 'SignPage\AdminAuthController@createAdmin']);
        Route::post('/changepassword', ['as' => 'changepassword.post', 'uses' => 'SignPage\AdminAuthController@changePassword']);

        Route::group(['prefix' => 'admin/daftar-lapak', 'as' => 'daftar-lapak.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\DaftarLapak\LapakAdminController@index']);
            Route::get('/{id_lapak}/detail-lapak', ['as' => 'detaillapak', 'uses' => 'Admin\DaftarLapak\LapakAdminController@detailLapak']);
            Route::post('/update-lapak', ['as' => 'updateLapak', 'uses' => 'Admin\DaftarLapak\LapakAdminController@updateLapak']);
        });

        Route::group(['prefix' => 'admin/kategori-produk', 'as' => 'kategori-produk.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\Kategori\KategoriAdminController@index']);
            Route::post('/create-update-kategori', ['as' => 'createUpdateKategori', 'uses' => 'Admin\Kategori\KategoriAdminController@createOrUpdate']);
            Route::get('/get-kategori', ['as' => 'getKategori', 'uses' => 'Admin\Kategori\KategoriAdminController@getKategori']);
        });

        Route::group(['prefix' => 'admin/verifikasiLapak', 'as' => 'verifikasi-lapak.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\Verifikasi\VerifikasiController@indexVerifikasiLapak']);
            Route::post('/update-status', ['as' => 'updateStatus', 'uses' => 'Admin\Verifikasi\VerifikasiController@updateStatusLapak']);
        });

        Route::group(['prefix' => 'admin/verifikasiRating', 'as' => 'verifikasi-rating.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\Verifikasi\VerifikasiController@indexVerifikasiRating']);
            Route::post('/update-status', ['as' => 'updateStatus', 'uses' => 'Admin\Verifikasi\VerifikasiController@updateStatusRating']);
        });

        Route::group(['prefix' => 'admin/riwayatTransaksi', 'as' => 'riwayat-transaksi.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\Transaksi\HistoriTransaksi@index']);
        });

        Route::group(['prefix' => 'admin/dashboard', 'as' => 'dashboard-admin.'], function () {
            Route::get('/', ['as' => 'index', 'uses' => 'Admin\Dashboard\DashboardAdminController@index']);
        });
    });
});
