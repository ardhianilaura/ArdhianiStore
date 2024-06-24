<table class="table table-hover table-bordered table-striped">
	<tr>
	    <td>Nama Produk</td>
	    <td>{{ $daftar_produk->nama_produk }}</td>
	</tr>

	<tr>
	    <td>Harga Satuan</td>
	    <td>{{ number_format($daftar_produk->harga_all) }}</td>
	</tr>

	<tr>
	    <td>Kategori</td>
	    <td>{{ $daftar_produk->kategori }}</td>
	</tr>

	<tr>
	    <td>Jumlah Produk</td>
	    <td>{{ $daftar_produk->jumlah_produk_all }}</td>
	</tr>

	<tr>
	    <td>Total Harga</td>
	    <td>{{ number_format($daftar_produk->total_harga_all) }}</td>
	</tr>
</table>