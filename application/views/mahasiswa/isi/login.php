<div class="row">
	<div class="col-sm-4"><br><br><br><br><br>
	<h2 class="text-center">Login Mahasiswa</h2><br>
		<?php echo $this->session->flashdata('pesan');?>
		<form method="post" action="<?=base_url();?>login/masuk_login">
			<div class="row mb-4">
				<label class="col-sm-3 col-form-label">Username</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" placeholder="Masukkan Username" name="username">
				</div>
			</div>

			<div class="row mb-4">
				<label class="col-sm-3 col-form-label">Password</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" name="password" placeholder="Masukkan Password">
				</div>
			</div>

			<div class="d-grid gap-2">
				<button class="btn btn-primary" type="submit">Masuk</button>
			</div>
		</form>
	</div>

	<div class="col-sm-8">
		<br><br><br>
		<div class="row g-0 bg-light position-relative">
			<div class="col-md-6 mb-md-0 p-md-4">
				<img src="<?=base_url();?>assets/images/background.jpeg" class="w-100" alt="Universitas MBG">
			</div>

			<div class="col-md-6 p-4 ps-md-0">
				<h5 class="mt-0">Portal Mahasiswa Universitas MBG</h5>
				<p>Mahasiswa dapat masuk ke sistem menggunakan username dan password yang telah terdaftar. Apabila belum memiliki akun, silakan melakukan pendaftaran terlebih dahulu untuk mengakses layanan akademik Universitas MBG.</p>

				<a href="<?=base_url();?>pendaftaran" class="stretched-link">Klik Untuk Mendaftar</a>
			</div>
		</div>
	</div>
</div>