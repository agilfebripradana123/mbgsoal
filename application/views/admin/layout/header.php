<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
	      <img src="<?=base_url();?>assets/images/logo.png" alt="Bootstrap" width="50" height="35">
	</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?=base_url();?>admin">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Master Data
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?=base_url();?>admin/fakultas">Fakultas</a></li>
			<li><a class="dropdown-item" href="<?=base_url();?>admin/prodi">Program Studi</a></li>
			<li><a class="dropdown-item" href="<?=base_url();?>admin/upload_form">Mahasiswa</a></li>
			<li><a class="dropdown-item" href="<?=base_url();?>admin/soal">Soal</a></li>
          </ul>
        </li>
      </ul>
	 
    </div>
	 <ul class="navbar-nav pull-right">
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<?=$this->session->userdata('nama_user');?>
			</a>
			<ul class="dropdown-menu">
				<li><a class="dropdown-item" href="<?=base_url();?>admin/profil">Profil</a></li>
				<li><a class="dropdown-item" href="<?=base_url();?>login/keluar">Keluar</a></li>
			</ul>
		</li>
		</ul>
  </div>
</nav>