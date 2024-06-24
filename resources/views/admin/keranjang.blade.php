@extends('layouts.index')
@section('content')

<div class="content">
	<div class="container">
		<div class="p-3 mt-3">
			<h1 class="text-center mb-3">Keranjang Saya</h1>
			<a href="{{ url('/admin/dashboard') }}" class="btn btn-sm btn-success"> Produk</a><br>
			<table class="table table-striped table-light table-hover table-bordered">
				<thead class="text-center">
					<center>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama Produk</th>
							<th scope="col">Harga</th>
							<th scope="col">Kategori</th>
							<th scope="col">Jumlah Produk</th>
							<th scope="col">Total Harga</th>
							<th scope="col">Aksi</th>
						</tr>
					</center>
				</thead>
				<tbody id="isi_keranjang">
					@php
						$no = 1;
						$total_harga_barang = 0;
					@endphp
					@foreach($isi_keranjang as $data)

					<tr class="text-center">
						<td>{{ $no++ }}</td>
						<td>{{ $data->nama_produk }}</td>
						<td>{{ number_format($data->harga) }}</td>
						<td>{{ $data->kategori }}</td>
						<td>{{ $data->jumlah_produk_all }}</td>
						<td>{{ number_format($data->total_harga_all) }}</td>
						<td>
							<a class="btn btn-md btn-danger" onclick="hapus_keranjang({{ $data->pesan_id }})"><i
									class="fa fa-trash"></i></a>
							<a class="btn btn-md btn-warning" onclick="detail_keranjang({{ $data->pesan_id }})"
								data-toggle="modal" data-target="#modalDetail"><i i class="fa fa-eye"></i></a>
						</td>
					</tr>
					@php
						$total_harga_barang += $data->total_harga_all;
					@endphp
					@endforeach
				</tbody>
				<tfoot>
					<tr class="text-center">
						<td colspan="5">Total Harga Barang</td>
						<td>{{ number_format($total_harga_barang) }}</td>
						<td>
							@if (Auth::user())
							<a href="{{ url('admin/checkout') }}" class="btn btn-success checkout-btn">Check Out</a>
							@else
							<a href="{{ url('auth/login') }}" class="btn btn-success checkout-btn">Check Out</a>
							@endif
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="modal-content">
			<div class="modal-header" id="modal-header">
				<h5 class="modal-title" id="title">Detail Produk</h5>
			</div>

			<div class="modal-body" id="detailKeranjang">

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	function hapus_keranjang(pesan_id){
			var token = '{{ csrf_token() }}';
			var my_url = "{{ url('/admin/hapus_keranjang') }}";
			var formData = {
					'_token': token,
					'pesan_id': pesan_id
			};
			var konfirmasi = confirm('Apakah Anda Yakin Akan Menghapus Produk Ini Dari Keranjang Saya?');
			if (konfirmasi){
				$.ajax({
					method: 'POST',
					url: my_url,
					data: formData,
		
					success: function(resp){

						location.reload();
						swal("Yay!", "Data Berhasil Dihapus!", "success");
					},
					
					error: function(resp){
						console.log(resp);
						swal("Oops!", "Data Tidak Berhasil Dihapus!", "error");
					}
				});
			}
		}

		function detail_keranjang(pesan_id){
			var token = '{{ csrf_token() }}';
			var my_url = "{{ url('/admin/detail_keranjang') }}";
			var formData = {
					'_token': token,
					'pesan_id': pesan_id
			};

			$.ajax({
					method: 'POST',
					url: my_url,
					data: formData,
		
					success: function(resp){
						$('#detailKeranjang').html(resp);
						$('#modalDetail').modal('show');
					},
					
					error: function(resp){
						console.log(resp);
					}
				});
		}
</script>
@endsection