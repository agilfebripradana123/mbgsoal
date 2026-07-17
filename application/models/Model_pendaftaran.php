<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_pendaftaran extends CI_Model{
	
	function simpan_pendaftar()
	{
		$data=array(
			'nama_user'			=> $this->input->post('nama_user'),
			'username'			=> $this->input->post('username'),
			'password'			=> md5($this->input->post('password')),
			'level_pengguna'	=> 'Mahasiswa',
			'status_user'		=> 'Aktif'
		);
		$this->db->insert('user',$data);
	}
	
	function cek_username($username)
	{
		$data=array();
		$this->db->select('*');
		$this->db->where('username',$username);
		$Q = $this->db->get('user');
		if($Q -> num_rows() > 0){
			foreach ($Q -> result_array() as $row){
				$data[]=$row;
			}
		}
		$Q->free_result();
		return $data;
	}
}