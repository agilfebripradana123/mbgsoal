<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {

	public function index()
	{
		$data['judul']='Halaman Pendaftaran';
		$data['header']='mahasiswa/layout/header';
		$data['isi']='mahasiswa/isi/pendaftaran'; //isi
		$this->load->view('mahasiswa/layout/layout',$data); //layout
	}
	
	public function simpan_pendaftaran()
	{
		$this->_validate_pendaftaran();
		$this->model_pendaftaran->simpan_pendaftar();
		$this->session->set_flashdata('pesan','<script>swal.fire("Berhasil","Pendaftaran Berhasil, silahkan login menggunakan username dan password yang telah terdaftar","success")</script>');
		echo json_encode(array("status" => TRUE));
	}
	
	private function _validate_pendaftaran()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
		
		$username=$this->input->post('username');
		$cek_usernamnya=count($this->model_pendaftaran->cek_username($username));
	
		if($this->input->post('nama_user') == '')
		{
			$data['inputerror'][] = 'nama_user';
			$data['error_string'][] = 'Field tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if($this->input->post('username') == '')
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Field tidak boleh kosong';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('password') == '')
		{
			$data['inputerror'][] = 'password';
			$data['error_string'][] = 'Field tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if($this->input->post('password_ulang') == '')
		{
			$data['inputerror'][] = 'password_ulang';
			$data['error_string'][] = 'Field tidak boleh kosong';
			$data['status'] = FALSE;
		}
		
		if($cek_usernamnya == 1)
		{
			$data['inputerror'][] = 'username';
			$data['error_string'][] = 'Username telah digunakan';
			$data['status'] = FALSE;
		}
		
		if($this->input->post('password_ulang') != $this->input->post('password'))
		{
			$data['inputerror'][] = 'password_ulang';
			$data['error_string'][] = 'Verifikasi password tidak sama';
			$data['status'] = FALSE;
		}
		
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}
