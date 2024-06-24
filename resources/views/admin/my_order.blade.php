@extends('layouts.index')
@section('content')

<div class="content">
	<div class="container">
		<div class="p-3 mt-3">
			<h3 class="text-center mt-3">PESANAN SAYA</h3><br>
			<table class="table table-striped table-light table-hover table-bordered">
				<thead class="text-center">
					<th>NO</th>
					<th>ID Order</th>
					<th>Status</th>
					<th>Tanggal Pemesanan</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Alamat</th>
					<th>No handphone</th>
					<th>Total Pesanan</th>
					<th>Payment Type</th>
				</thead>
				<tbody>
					@php
							$no = 1;
					@endphp
					@foreach($daftar_order as $item)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $item->order_id }}</td>
						<td>{{ $item->status }}</td>
						<td>{{ date('d, M Y H:i', strtotime($item->created_at)) }}</td>
						<td>{{ $item->name }}</td>
						<td>{{ $item->email }}</td>
						<td>{{ $item->number }}</td>
						<td>{{ $item->alamat }}</td>
						<td>{{ number_format($item->gross_amount) }}</td>
						<td>{{ $item->payment_type }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection