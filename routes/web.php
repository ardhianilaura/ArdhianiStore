<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return view('welcome');
});

Route::group(['middleware' => ['auth', 'isAdmin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
	Route::get('/dashboard', 'DashboardController@index');
	Route::get('/my_profile', 'UserController@my_profile')->name('my_profile');
	Route::post('/my_profile_update', 'UserController@my_profile_update')->name('my_profile_update');

	Route::get('/input_produk', 'ProdukController@input_produk');
	Route::post('/simpan_input_produk', 'ProdukController@simpan_input_produk')->name('simpan_input_produk');
	Route::get('/list_produk', 'ProdukController@list_produk')->name('list_produk');
	Route::get('/delete_produk/{produk_id}', 'ProdukController@delete_produk')->name('delete_produk');
	Route::get('/edit_produk/{produk_id}', 'ProdukController@edit_produk')->name('edit_produk');
	Route::post('/simpan_edit_produk', 'ProdukController@simpan_edit_produk')->name('simpan_edit_produk');
	Route::get('/tambah_stok/{produk_id}', 'ProdukController@tambah_stok')->name('tambah_stok');
	Route::post('/simpan_stok_produk', 'ProdukController@simpan_stok_produk')->name('simpan_stok_produk');

	Route::get('/keranjang', 'PesanController@keranjang')->name('keranjang');
	Route::get('/pesan_produk/{id}', 'PesanController@pesan_produk')->name('pesan_produk');
	Route::post('/pesanan', 'PesanController@pesanan')->name('pesanan');
	Route::post('/hapus_keranjang', 'PesanController@hapus_keranjang')->name('hapus_keranjang');
	Route::post('/detail_keranjang', 'PesanController@detail_keranjang')->name('detail_keranjang');

	Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
	Route::post('/checkout', 'CheckoutController@checkout_post')->name('checkout_post');
	Route::get('/my_order', 'CheckoutController@my_order')->name('my_order');

	Route::get('/laporan_transaksi', 'LaporanController@laporan_transaksi')->name('laporan_transaksi');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
