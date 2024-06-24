@extends('layouts.index')
@section('content')

<div class="content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<h3>My Profile Page</h3>
						<form action="{{ route('my_profile_update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<img name="foto" src="{{ URL::asset('img/'.Auth::user()->foto) }}" class="w-75" alt>

									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Username</label>
										<input type="text" name="username" class="form-control" value="{{ Auth::user()->username }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Nama Awal</label>
										<input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Nama Akhir</label>
										<input type="text" name="lname" class="form-control" value="{{ Auth::user()->lname }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Email</label>
										<input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Jenis Kelamin</label>
										<input type="text" name="jenis_kelamin" class="form-control" value="{{ Auth::user()->jenis_kelamin }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Tanggal Lahir</label>
										<input type="text" name="tanggal_lahir" class="form-control" value="{{ Auth::user()->tanggal_lahir }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="">Nomor Handphone</label>
										<input type="text" name="no_hp" class="form-control" value="{{ Auth::user()->no_hp }}">
									</div>
 								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label for="">Alamat</label>
										<input type="text" name="alamat" class="form-control" value="{{ Auth::user()->alamat }}">
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<button type="submit" id="simpan" class="btn btn-primary" hidden> Update Profile</button>
										<button type="submit" id="profile" class="btn btn-primary">Update Profile</button>
									</div>
								</div>
							</div>
						</form>
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

		$(document).on('click', '#profile', function() {
			$('#simpan').trigger('click');
		});
	</script>
@endsection