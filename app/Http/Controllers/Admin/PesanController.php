<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function keranjang()
    {
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

        return view('admin.keranjang', compact('daftar_produk', 'isi_keranjang'));
    }

    public function pesan_produk($id)
    {
        $daftar_produk = DB::table('produk')
            ->select('*')
            ->where('produk_id', $id)
            ->first();
        return view('admin.pesan_produk', compact('daftar_produk'));
    }

    public function pesanan(Request $pesan)
    {
        $data_swal = [
            'type' => 'success',
            'title' => 'yay',
        ];

        $user_id = $pesan->user_id;
        $produk_id = $pesan->produk_id;
        $harga = $pesan->harga;
        $jumlah_produk = $pesan->jumlah_produk;

        $stok = DB::table('produk')
            ->where('produk_id', '=', $produk_id)
            ->value('stok');

        // jika stok lebih dari jumlah barang
        if ((int)$stok < (int)$jumlah_produk) {
            $data_swal['id'] = $produk_id;
            $data_swal['message'] = 'Stok kurang dari jumlah pesanan';
            $data_swal['type'] = 'warning';
            $data_swal['title'] = 'oops!';
            return redirect()->route('pesan_produk', $data_swal);
        }

        $data = [
            'user_id' => $user_id,
            'produk_id' => $produk_id,
            'harga' => $harga,
            'jumlah_produk' => $jumlah_produk,
            'total_harga' => $harga * $jumlah_produk,
        ];

        $cek = DB::table('pesanan')->where('produk_id', $produk_id)->where('user_id', $user_id)->first();
        // dd($cek);
        if ($cek) {
            $jumlah = $cek->jumlah_produk + $jumlah_produk;
            $data['jumlah_produk'] = $jumlah;
            DB::table('pesanan')->where('pesan_id', $cek->pesan_id)->update($data);
        } else {
            DB::table('pesanan')
                ->insertGetId($data);
        }

        // update stok dikurangi jumlah
        $update_data = array(
            'stok' => $stok - $jumlah_produk
        );
        // update data
        DB::table('produk')
            ->where('produk_id', $produk_id)
            ->update($update_data);

        return redirect(route('keranjang'));
    }

    public function hapus_keranjang(Request $hapus)
    {
        $pesan_id = $hapus->pesan_id;

        DB::table('pesanan')
            ->where('pesan_id', $pesan_id)
            ->delete();
    }

    public function detail_keranjang(Request $detail)
    {
        $pesan_id = $detail->pesan_id;
        $daftar_produk = DB::table('pesanan')
            ->leftjoin('produk', 'pesanan.produk_id', 'produk.produk_id')
            ->select(DB::raw('pesanan.pesan_id, pesanan.jumlah_produk as jumlah_produk_all, pesanan.total_harga as total_harga_all, produk.nama_produk, produk.harga as harga_all, produk.kategori, produk.foto'))
            ->groupBy('pesanan.produk_id')
            ->where('pesanan.pesan_id', $pesan_id)
            ->first();
        return view('admin.detail_keranjang', compact('daftar_produk'));
    }
}
