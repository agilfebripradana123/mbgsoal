<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model_admin extends CI_Model
{
    public function profil_pengguna()
    {
        $this->db->from('user');
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $query = $this->db->get();
        return $query->row();
    }

    public function update_profil()
    {
        $data = array(
            'nama_user' => $this->input->post('nama_user'),
            'username' => $this->input->post('username')
        );

        $this->db->where('id_user', $this->input->post('id_user'));
        $this->db->update('user',$data);
}

}