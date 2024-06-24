@extends('layouts.index')
@section('content')
  <div class="content">
    <div class="container">
      <div class="p-3 mt-3">
        <h3 class="text-center mb-3">FORM TAMBAH PRODUK</h3><br>
        <div class="card p-3">
          <form action="{{ route('simpan_stok_produk') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
            <input type="text" name="produk_id" id="produk_id" value="{{ $daftar->produk_id }}" hidden>
            <div>
              <label for="nama_produk">Nama Produk</label>
              <input type="text" name="nama_produk" id="nama_produk" value="{{ $daftar->nama_produk }}"
                class="form-control" readonly><br>

              <label for="stok">Stok Lama</label>
              <input type="text" name="stok" id="stok" value="{{ $daftar->stok }}"
                class="form-control" readonly><br>

              <label for="stok_produk">Tambah Stok</label>
              <input type="number" name="stok_produk" id="stok_produk" class="form-control @error('stok_produk') is-invalid @enderror" required> 
              <br>

              <label for="kategori">Kategori</label>
              <select name="kategori" id="kategori" class="form-control" readonly>
                <option value="{{ $daftar->kategori }}">{{ $daftar->kategori }}</option>
                <option>---</option>
                <option value="Skin Care">Skin Care</option>
                <option value="Cosmetics">Cosmetics</option>
                <option value="Lip Products">Lip Products</option>
              </select><br>

              <label for="harga">Harga</label>
              <input type="number" name="harga" id="harga" value="{{ $daftar->harga }}" class="form-control" readonly><br>

              <label for="berat_produk">Berat Produk</label>
              <input type="text" name="berat_produk" id="berat_produk" value="{{ $daftar->berat_produk }}"
                class="form-control" readonly><br>

              <label for="masa_penyimpanan">Masa Penyimpanan</label>
              <input type="text" name="masa_penyimpanan" id="masa_penyimpanan" value="{{ $daftar->masa_penyimpanan }}"
                class="form-control" readonly><br>

              <label for="tanggal_kadaluwarsa">Tanggal Kadaluwarsa</label>
              <input type="date" name="tanggal_kadaluwarsa" id="tanggal_kadaluwarsa"
                value="{{ $daftar->tanggal_kadaluwarsa }}" class="form-control" readonly><br>

              <label for="deskripsi">Deskripsi</label>
              <input type="text" name="deskripsi" id="deskripsi" value="{{ $daftar->deskripsi }}"
                class="form-control" readonly><br>

              <label for="tanggal">Tanggal Penambahan</label>
              <input type="date" name="tanggal" id="deskripsi"
                class="form-control" required><br>

              <button type="button" id="button" class="btn btn-md btn-primary mt-3" onclick="validasi()">Tambah Stok</button>
            </div>
          </form>
        </div>
      </div>

      <script type="text/javascript">
      function validasi(){
        var stok_produk = document.getElementById('stok_produk').value;

        var user_id = $('#user_id').val();

        if (stok_produk <= 0){
          swal("Oops!", "Tambahkan Stok Produk Minimal 1pcs", "warning");
        } else {
          swal("Yay!", "Berhasil Menambahkan Stok Produk!", "success");
        }
        document.getElementById('simpan').click();      
      }
    </script>
@endsection