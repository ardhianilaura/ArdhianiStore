<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\User;


class CheckoutController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function checkout(){
        $daftar_produk = DB::table('produk')
            ->select('*')
            ->get();

        $user_id = Auth::user()->id;
        $isi_keranjang = DB::table('pesanan')
            ->leftjoin('produk', 'pesanan.produk_id', 'produk.produk_id')
            ->select(DB::raw('sum(pesanan.total_harga) as total_harga_all, sum(pesanan.jumlah_produk) as jumlah_produk_all, pesanan.* , produk.*'))
            ->groupBy('pesanan.produk_id')
            ->where('user_id', $user_id)
            ->get();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        if ($isi_keranjang->count() == 0) {
            return view('admin.keranjang', compact('daftar_produk', 'isi_keranjang'))->with('alert-failed', 'Pesanan kosong');
        }

        $total_harga_barang = 0;
        foreach ($isi_keranjang as $data) {
            $item_details[] = [
                'id' => $data->produk_id,
                'price' => $data->harga,
                'quantity' => $data->jumlah_produk,
                'name' => $data->nama_produk,
            ];
            $total_harga_barang = $data->jumlah_produk * $data->harga;
        };

        $params = array(
            'transaction_details' => array(
                'order_id' => 'ODR' . rand(),
                'gross_amount' => $total_harga_barang,
            ),
            'item_details' => $item_details,
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'last_name' => '',
                'email' => Auth::user()->email,
                // 'phone' => Auth::user()->number,
            ),
        );
        // dd($params);
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('admin.checkout', compact('isi_keranjang', 'snapToken', 'total_harga_barang'));
    }

    public function checkout_post(Request $request)
    {
        // return $request;
        $user_id = Auth::user()->id;
        $pesanan_id = DB::table('pesanan')
            ->leftjoin('produk', 'pesanan.produk_id', 'produk.produk_id')
            ->groupBy('pesanan.produk_id')
            ->where('user_id', $user_id)
            ->get('pesan_id');
        foreach ($pesanan_id as $id) {
            $pesan_id[] = $id->pesan_id;
        };

        $json = json_decode($request->get('json'));
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->name = $request->get('name');
        $order->email = $request->get('email');
        $order->number = $request->get('no_hp');
        $order->alamat = $request->get('alamat');
        $order->status = 'success';
        $order->transaction_id = $json->transaction_id;
        $order->order_id = $json->order_id;
        $order->gross_amount = $json->gross_amount;
        $order->payment_type = $json->payment_type;
        $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;

        if ($order->save()) {
            foreach ($pesan_id as $id) {
                DB::table('pesanan')->where('pesan_id', $id)->delete();
            }
            return redirect()->route('my_order');
        }
        return redirect(url('/admin/checkout'))->with('alert-failed', 'Terjadi kesalahan');
    }

    public function my_order(){
        $daftar_order = DB::table('orders')
                        ->orderBy('created_at')
                        ->get();

        return view('admin.my_order', compact('daftar_order'));
    }
}
