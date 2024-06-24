<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;

class LaporanController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function laporan_transaksi(){
    	$daftar_order = DB::table('orders')
                        ->orderBy('created_at')
                        ->get();

    	$user_id = Auth::user()->id;
        $daftar_transaksi = DB::table('orders')
			            ->leftjoin('produk', 'orders.id', 'produk.produk_id')
			            ->select(DB::raw('sum(orders.gross_amount) as total_gross_amount, orders.* , produk.*'))
			            ->groupBy('orders.id')
			            ->where('user_id', $user_id)
			            ->get();
 
        return view('admin.laporan_transaksi',compact('daftar_order', 'daftar_transaksi'));
    }
}