@extends('layouts.index')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<h4>{{ $daftar_produk->nama_produk }}</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<img src="{{ url('upload_file') }}/{{ $daftar_produk->foto }}" class="rounded mx-auto d-block" width="100%" alt="">
							</div>
							<div class="col-md-6 mt-6">
								<form action="{{ route('pesanan') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<h3>{{ $daftar_produk->nama_produk }}</h3>
								<table class="table table-hover">
									<tbody>
										<input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
										<input type="number" name="produk_id" id="produk_id" value="{{ $daftar_produk->produk_id }}" hidden>
										<tr>
							                <td>Harga</td>
							                <td>:</td>
							                <td>Rp. <input type="number" name="harga" id="harga" value="{{ $daftar_produk->harga }}" readonly style="border:none"></td>
							            </tr>
							            <tr>
							                <td>Stok</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->stok }}</td>
							            </tr>

							            <tr>
							                <td>Kategori</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->kategori }}</td>
							            </tr>

							            <tr>
							                <td>Berat Produk</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->berat_produk }}</td>
							            </tr>

							            <tr>
							                <td>Masa Penyimpanan</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->masa_penyimpanan }}</td>
							            </tr>

							            <tr>
							                <td>Tanggal Kadaluwarsa</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->tanggal_kadaluwarsa }}</td>
							            </tr>

							            <tr>
							                <td>Deskripsi</td>
							                <td>:</td>
							                <td>{{ $daftar_produk->deskripsi }}</td>
							            </tr>
								        <tr>
								        	<td>Jumlah Pesan</td>
								        	<td>:</td>
								        	<td>
								        		<input type="number" name="jumlah_produk" id="jumlah_produk" class="form-control" required>
								        	</td>
								        </tr>
								        <tr>
								        	<td></td>
								        	<td></td>
								        	<td>
								        		<button type="submit" id="simpan" class="btn btn-info" hidden> Masukkan Keranjang</button>
								        		<button type="button" id="keranjang" class="btn btn-md btn-primary mt-3"><i class="fa fa-shopping-cart"></i> Masukkan Keranjang</button>
								           	</td>
								        </tr>	
									</tbody>
								</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script type="text/javascript">
		let message = '<?= $_GET["message"] ?? null ?>';
		let title = '<?= $_GET["title"] ?? null ?>';
		let type = '<?= $_GET["type"] ?? null ?>';

		if (message){
			swal(title, message, type);
		}

		$(document).on('click', '#keranjang', function() {
			$('#simpan').trigger('click');
		});
	</script>
@endsection