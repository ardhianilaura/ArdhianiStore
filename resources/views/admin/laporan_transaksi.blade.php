@extends('layouts.index')
@section('content')

<div class="content">
	<div class="container">
		<div class="p-3 mt-3">
			<h3 class="text-center mt-3">LAPORAN TRANSAKSI</h3><br>
			<table class="table table-striped table-light table-hover table-bordered">
				<thead class="text-center">
					<th>NO</th>
					<th>ID Order</th>
					<th>Status</th>
					<th>Tanggal Pemesanan</th>
					<th>Nama</th>
					<th>Total Pesanan</th>
				</thead>
				<tbody>
					@php
						$no = 1;
						$total_laba_kotor = 0;
					@endphp
					@foreach ($daftar_transaksi as $key => $data)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $data->order_id }}</td>
						<td>{{ $data->status }}</td>
						<td>{{ date('d, M Y H:i', strtotime($daftar_order[$key]->created_at)) }}</td>
						<td>{{ $data->name }}</td>
						<td><center>{{ number_format($data->gross_amount) }}</center></td>
					</tr>
					@php
						$total_laba_kotor += $data->total_gross_amount;
					@endphp
					@endforeach
				</tbody>
				<tfoot>
					<tr class="text-center">
						<td colspan="5">Total Pendapatan (Kotor)</td>
						<td>{{ number_format($total_laba_kotor) }}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
@endsection
