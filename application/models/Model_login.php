<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_login extends CI_Model{
	
	function cek_data_pengguna($username,$password)
	{
		$this->db->from('user');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$query = $this->db->get();
		return $query->result();
	}
}