@extends('layouts.index')
@section('content')

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-16">
				<div class="card">
					<div class="card-body">
						<h3>Checkout</h3>
						<div class="container">
							<div class="row">
								<div class="col-md-8">
									<form action="" id="submit_form" method="POST">
										@csrf
										<input type="hidden" name="json" id="json_callback">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Nama Awal</label>
													<input type="text" name="name" class="form-control"
														value="{{ Auth::user()->name }}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Nama Akhir</label>
													<input type="text" name="lname" class="form-control"
														value="{{ Auth::user()->lname }}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Email</label>
													<input type="text" name="email" class="form-control"
														value="{{ Auth::user()->email }}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Jenis Kelamin</label>
													<input type="text" name="jenis_kelamin" class="form-control"
														value="{{ Auth::user()->jenis_kelamin }}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Tanggal Lahir</label>
													<input type="date" name="tanggal_lahir" class="form-control"
														value="{{ Auth::user()->tanggal_lahir }}">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="">Nomor Handphone</label>
													<input type="text" name="no_hp" class="form-control"
														value="{{ Auth::user()->no_hp }}">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label for="">Alamat</label>
													<input type="text" name="alamat" class="form-control"
														value="{{ Auth::user()->alamat }}">
												</div>
											</div>
										</div>
									</form>
									<div class="col-md-6">
										{{-- <button type="submit" name="place_order_btn" class="btn btn-primary">Place
											Your Order</button> --}}
										<button id='pay-button' class="btn btn-info btn_block">Pay
											Online</button>
									</div>
								</div>
								<div class="col-md-4">
									@php
										$total_harga_barang = 0;
									@endphp
									<table class="table">
										<thead>
											<tr>
												<th>Nama Produk</th>
												<th>Harga</th>
												<th>Qty</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($isi_keranjang as $data)
											<tr>
												<td>{{ $data->nama_produk }}</td>
												<td>{{ number_format($data->harga) }}</td>
												<td>
													<center>{{ $data->jumlah_produk_all }}</center>
												</td>
											</tr>
											</tr>
											@php
												$total_harga_barang += $data->total_harga_all;
											@endphp
											@endforeach
										</tbody>
									</table>
									<br>
									<div class="text-right">
										<p><b>Total Harga : {{ number_format($total_harga_barang) }}</b></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	// For example trigger on button clicked, or any time you need
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay('{{$snapToken}}', {
          onSuccess: function(result){
            /* You may add your own implementation here */
            console.log(result);
            send_response_to_form(result);
          },
          onPending: function(result){
            /* You may add your own implementation here */
            console.log(result);
            send_response_to_form(result);
          },
          onError: function(result){
            /* You may add your own implementation here */
            console.log(result);
            send_response_to_form(result);
          },
          onClose: function(){
            /* You may add your own implementation here */
            alert('you closed the popup without finishing the payment');
          }
        })
      });

      function send_response_to_form(result){
        document.getElementById('json_callback').value = JSON.stringify(result);
        $('#submit_form').submit();
      }
</script>
@endsection