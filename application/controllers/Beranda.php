<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$sesi_login=$this->session->userdata('loginMasuk');
		$level=$this->session->userdata('level_pengguna');
		if($sesi_login == false || $level != 'Mahasiswa')
		{
			redirect('login');
		}
	}
	
	public function index()
	{
		$data['judul']='Halaman Login';
		$data['header']='mahasiswa/layout/header';
		$data['isi']='mahasiswa/isi/beranda';
		$this->load->view('mahasiswa/layout/layout',$data);
	}
	
}


