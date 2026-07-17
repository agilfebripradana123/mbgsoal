<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$judul;?></title>
    <link href="<?=base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="<?=base_url();?>assets/sweetalert/dist/sweetalert2.min.js"></script> 
	<link rel="stylesheet" href="<?=base_url();?>assets/sweetalert/dist/sweetalert2.css" type="text/css">
  </head>
  <body>
	
	<div class="container">
	<div class="row">
	<div class="col-sm-12">
	<!--header-->
		<?php $this->load->view($header);?>
	<!--akhir header-->
	</div>
	</div>
	
	<!--Isi-->
		<?php $this->load->view($isi);?>
	<!-- akhir isi-->
	
	<!-- Footer -->
		<?php $this->load->view('mahasiswa/layout/footer');?>
	 <!-- Akhir footer-->
	</div>
   <script src="<?=base_url();?>assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>



