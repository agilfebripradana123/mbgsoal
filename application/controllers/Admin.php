<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$sesi_login=$this->session->userdata('loginMasuk');
		$level=$this->session->userdata('level_pengguna');
		if($sesi_login == false || $level != 'Admin')
		{
			redirect('login');

		}
        $this->load->model('model_admin'); 
	}
	
	public function index()
	{
		$data['judul']='Halaman Admin';
		$data['header']='admin/layout/header';
		$data['isi']='admin/isi/home';
		$this->load->view('admin/layout/layout',$data);
	}
	public function fakultas()
{
    $data['judul'] = 'Halaman Admin';
    $data['header'] = 'admin/layout/header';
    $data['isi'] = 'admin/isi/fakultas';
    $this->load->view('admin/layout/layout', $data);
}

public function ajax_fakultas()
{
    $this->load->model('model_fakultas'); 

    $list = $this->model_fakultas->get_datatables();
    $data = array();
    $no = $_POST['start'] + 1;

    foreach ($list as $fakul) {
        $row = array();
        $row[] = '<div class="text-center">' . $no . '</div>';
        $row[] = $fakul->nama_fakultas;
        $row[] = '<div class="text-center">' . $fakul->status_fakultas . '</div>';
        $row[] = '<div class="text-center"><a class="btn btn-sm btn-success" href="javascript:void(0)" title="Edit" onclick="editFakultas(' . "'" . $fakul->id_fakultas . "'" . ')"><i class="bi bi-pencil-square"></i></a>
            <a class="btn btn-am btn-danger" href="javascript:void(0)" title="Hapus" onclick="deleteFakultas(' . "'" . $fakul->id_fakultas . "'" . ')"><i class="bi bi-trash3-fill"></i></a></div>';
        $data[] = $row;
        $no++;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model_fakultas->count_all(),
        "recordsFiltered" => $this->model_fakultas->count_filtered(),
        "data" => $data,
    );

    echo json_encode($output);
}

public function tambah_fakultas()
{
    $this->_validate_fakultas();
    $data = array(
        'nama_fakultas' => $this->input->post('nama_fakultas'),
        'status_fakultas' => $this->input->post('status_fakultas')
    );
    $insert = $this->model_fakultas->save($data);
    echo json_encode(array("status" => TRUE));
}

public function edit_fakultas($id_fakultas)
{
    $data = $this->model_fakultas->get_by_id($id_fakultas);
    echo json_encode($data);
}

public function update_fakultas()
{
    $this->_validate_fakultas();
    $data = array(
        'nama_fakultas' => $this->input->post('nama_fakultas'),
        'status_fakultas' => $this->input->post('status_fakultas')
    );
    $this->model_fakultas->update(array('id_fakultas' => $this->input->post('id_fakultas')), $data);
    echo json_encode(array("status" => TRUE));
}

public function hapus_fakultas($id_fakultas)
{
    $this->model_fakultas->delete_by_id($id_fakultas);
    echo json_encode(array("status" => TRUE));
}

private function _validate_fakultas()
{
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if ($this->input->post('nama_fakultas') == '') {
        $data['inputerror'][] = 'nama_fakultas';
        $data['error_string'][] = 'Nama fakultas tidak boleh kosong';
        $data['status'] = FALSE;
    }

    if ($this->input->post('status_fakultas') == '') {
        $data['inputerror'][] = 'status_fakultas';
        $data['error_string'][] = 'Status fakultas harus dipilih';
        $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
        echo json_encode($data);
       exit();
}
}

public function profil(){
    $data['judul'] = 'Halaman Admin';
    $data['header'] = 'admin/layout/header';
    $data['isi'] = 'admin/isi/profil';
    $data['profil'] = $this->model_admin->profil_pengguna();
    $this->load->view('admin/layout/layout', $data);
}

public function ajax_gambar()
{
    $data['gambarnya']=$this->model_admin->profil_pengguna();
    $this->load->view('admin/isi/ajax_gambar',$data);
}

public function update_profil()
{
    $this->_validate_update_profil();
    $this->model_admin->update_profil();
    echo json_encode(array("status" => TRUE));
    $config['upload_path'] = './assets/gambar/';
        $config['allowed_types'] = 'jpg|png|jpeg|bmp';
        $config['encrypt_name'] = true; 
		
		$this->upload->initialize($config);
        if(!empty($_FILES['userfile'])){
            if ($this->upload->do_upload('userfile')){
                $gambar = $this->upload->data();
                $config['image_library']='gd2';
				$config['source_image']='./assets/gambar/'.$gambar['file_name'];
                $config['create_thumb']= FALSE;
                $config['maintain_ratio']= FALSE;
				$config['max_size']= 50000;
				$config['width']= 120;
				$config['height']= 160;
                $config['new_image']= './assets/gambar/'.$gambar['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
				$gambar1 = array(
					'gambar' => $gambar['file_name']	
				);
				$this->db->where('id_user',$this->session->userdata('id_user'));
				$this->db->update('user',$gambar1);	
            }
		}
}

private function _validate_update_profil()
{
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if ($this->input->post('nama_user') == '') {
        $data['inputerror'][] = 'nama_user';
        $data['error_string'][] = 'Field nama_user tidak boleh kosong';
        $data['status'] = FALSE;
    }

    if ($this->input->post('username') == '') {
        $data['inputerror'][] = 'username';
        $data['error_string'][] = 'Field username tidak boleh kosong';
        $data['status'] = FALSE;
    }

    if ($data['status'] === FALSE) {
        echo json_encode($data);
        exit();
    }
}
public function prodi()

{
    $this->load->model('Model_prodi');
    $data['judul'] = 'Prodi';
    $data['header'] = 'admin/layout/header';
    $data['footer'] = 'admin/layout/footer';
    $data['isi'] = 'admin/isi/prodi';
    $data['fakultas'] = $this->model_prodi->ambil_fakultas();
    $this->load->view('admin/layout/layout', $data);
}
public function ajax_list_prodi() {
    
    $list = $this->model_prodi->get_datatables();
    $data = array();
    $no = $_POST['start'];
    $nomor = 1;

    foreach ($list as $rows) {
        $no++;
        $row = array();
        $row[] = '<div class="text-center">' . $no . '</div>';
        $row[] = $rows->nama_fakultas;
        $row[] = $rows->nama_prodi;
        $row[] = '<div class="text-center">' . $rows->status_prodi . '</div>';
        $row[] = '<div class="text-center">
                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_prodi(\'' . $rows->id_prodi . '\')">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_prodi(\'' . $rows->id_prodi . '\')">
                        <i class="bi bi-trash3-fill"></i>
                    </a>
                  </div>';
        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->model_prodi->count_all(),
        "recordsFiltered" => $this->model_prodi->count_filtered(),
        "data" => $data,
    );

    echo json_encode($output);
}

public function ajax_edit_prodi($id_prodi) {
    $data = $this->model_prodi->get_by_id($id_prodi);
    echo json_encode($data);
}

public function ajax_add_prodi() {
    $this->_validate_prodi();
    $data = array(
        'id_fakultas' => $this->input->post('id_fakultas'),
        'nama_prodi' => $this->input->post('nama_prodi'),
        'status_prodi' => $this->input->post('status_prodi')
    );
    $insert = $this->model_prodi->save($data);
    echo json_encode(array("status" => TRUE));
}
public function ajax_update_prodi() {
    $this->_validate_prodi();
    $data = array(
        'id_fakultas' => $this->input->post('id_fakultas'),
        'nama_prodi' => $this->input->post('nama_prodi'),
        'status_prodi' => $this->input->post('status_prodi')
    );
    $this->model_prodi->update(array('id_prodi' => $this->input->post('id_prodi')), $data);
    echo json_encode(array("status" => TRUE));
}

public function ajax_delete_prodi($id_prodi) {
    $this->model_prodi->delete_by_id($id_prodi);
    echo json_encode(array("status" => TRUE));
}
private function _validate_prodi() {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = true;

    if ($this->input->post('id_fakultas') === "") {
        $data['inputerror'][] = 'id_fakultas';
        $data['error_string'][] = 'Fakultas harus dipilih.';
        $data['status'] = false;
    }

    if ($this->input->post('nama_prodi') === "") {
        $data['inputerror'][] = 'nama_prodi';
        $data['error_string'][] = 'Nama prodi tidak boleh kosong.';
        $data['status'] = false;
    }

    if ($this->input->post('status_prodi') === "") {
        $data['inputerror'][] = 'status_prodi';
        $data['error_string'][] = 'Status prodi harus dipilih.';
        $data['status'] = false;
    }

    if ($data['status'] === false) {
        echo json_encode($data);
        exit();
    }
    
}
public function soal()
	{
		$data['judul'] = 'Soal';
		$data['header'] = 'admin/layout/header';
		$data['footer'] = 'admin/layout/footer';
		$data['isi'] = 'admin/isi/soal';
		$this->load->view('admin/layout/layout', $data);
	}

	public function ajax_list_soal()
	{
		$list = $this->model_soal->get_datatables();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $soa) {
			$no++;
			$image = '';
			if (!empty($soa->gambarnya)) {
				$image = '<img src="' . base_url('./assets/gambarsoal/' . $soa->gambarnya) . '" alt="gambarnya" style="inline-size:80%;">';
			} else {
				$image = '<a href="javascript:void(0)">Gambar Tidak Tersedia</a>';
			}

			$row = array(
				'<div class="text-center">' . $no . '</div>',
				'<div>' . $soa->soalnya . '</div>
            <div>A. ' . $soa->pilihan_a . '</div>
            <div>B. ' . $soa->pilihan_b . '</div>
            <div>C. ' . $soa->pilihan_c . '</div>
            <div>D. ' . $soa->pilihan_d . '</div>
            <div>E. ' . $soa->pilihan_e . '</div>
            <div class="fw-bold"> Jawaban : ' . $soa->jawaban . '</div>',
				'<div class="text-center"> 
                <div title="Edit" onclick="edit_soal(' . "'" . $soa->id_soal . "'" . ')">' . $image . '</div>
            </div>',
				'<div class="text-center">' . $soa->status_soal . '</div>',
				'<div class="text-center">
                <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_soal(' . "'" . $soa->id_soal . "'" . ')">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_soal(' . "'" . $soa->id_soal . "'" . ')">
                    <i class="bi bi-trash3-fill"></i>
                </a>
            </div>'
			);
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->model_soal->count_all(),
			"recordsFiltered" => $this->model_soal->count_filtered(),
			"data" => $data,
		);

		echo json_encode($output);
	}

	public function edit_soal($id_soal)
	{
		$data = $this->model_soal->get_by_id($id_soal);
		echo json_encode($data);
	}
	public function ajax_delete_soal($id_soal)
	{
		$this->db->where('id_soal', $id_soal);
		$this->db->delete('soal');
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_cari_soal()
	{
		$keluar['soal'] = $this->model_soal->ajax_ambil_soal();
		$this->load->view($keluar);
	}
	public function ajax_add_soal()
	{
        date_default_timezone_set('Asia/Jakarta');

		$this->_validate_soal();
		$config['upload_path'] = './assets/gambarsoal/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp';
		$config['encrypt_name'] = true;

		$this->upload->initialize($config);

		if (!empty($_FILES['gambarnya'])) {
			if ($this->upload->do_upload('gambarnya')) {
				$gambar = $this->upload->data();

				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/gambarsoal/' . $gambar['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['max_size'] = 50000;
				$config['width'] = 120;
				$config['height'] = 160;
				$config['new_image'] = './assets/gambarsoal/' . $gambar['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				$data = array(
                    'waktu_sort' => date("Y-m-d H:i:s"),
					'soalnya' => $this->input->post('soalnya'),
					'pilihan_a' => $this->input->post('pilihan_a'),
					'pilihan_b' => $this->input->post('pilihan_b'),
					'pilihan_c' => $this->input->post('pilihan_c'),
					'pilihan_d' => $this->input->post('pilihan_d'),
					'pilihan_e' => $this->input->post('pilihan_e'),
					'jawaban' => $this->input->post('jawaban'),
					'status_soal' => $this->input->post('status_soal'),
					'gambarnya' => $gambar['file_name']
				);
			} else {
				$data = array(
                    'waktu_sort' => date("Y-m-d H:i:s"),
					'soalnya' => $this->input->post('soalnya'),
					'pilihan_a' => $this->input->post('pilihan_a'),
					'pilihan_b' => $this->input->post('pilihan_b'),
					'pilihan_c' => $this->input->post('pilihan_c'),
					'pilihan_d' => $this->input->post('pilihan_d'),
					'pilihan_e' => $this->input->post('pilihan_e'),
					'jawaban' => $this->input->post('jawaban'),
					'status_soal' => $this->input->post('status_soal'),
					'gambarnya' => ''
				);
			}
		} else {
			$data = array(
                'waktu_sort' => date("Y-m-d H:i:s"),
				'soalnya' => $this->input->post('soalnya'),
				'pilihan_a' => $this->input->post('pilihan_a'),
				'pilihan_b' => $this->input->post('pilihan_b'),
				'pilihan_c' => $this->input->post('pilihan_c'),
				'pilihan_d' => $this->input->post('pilihan_d'),
				'pilihan_e' => $this->input->post('pilihan_e'),
				'jawaban' => $this->input->post('jawaban'),
				'status_soal' => $this->input->post('status_soal'),
				'gambarnya' => ''
			);
		}
		$insert = $this->model_soal->save($data);
		echo json_encode(array("status" => TRUE));
	}
	public function ajax_update_soal()
	{
		$this->_validate_soal();
		$config['upload_path'] = './assets/gambarsoal/';
		$config['allowed_types'] = 'jpg|png|jpeg|bmp';
		$config['encrypt_name'] = true;

		$this->upload->initialize($config);

		if (!empty($_FILES['gambarnya'])) {
			if ($this->upload->do_upload('gambarnya')) {
				$gambar = $this->upload->data();

				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/gambarsoal/' . $gambar['file_name'];
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = FALSE;
				$config['max_size'] = 50000;
				$config['width'] = 120;
				$config['height'] = 160;
				$config['new_image'] = './assets/gambarsoal/' . $gambar['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();

				$data = array(
					'soalnya' => $this->input->post('soalnya'),
					'pilihan_a' => $this->input->post('pilihan_a'),
					'pilihan_b' => $this->input->post('pilihan_b'),
					'pilihan_c' => $this->input->post('pilihan_c'),
					'pilihan_d' => $this->input->post('pilihan_d'),
					'pilihan_e' => $this->input->post('pilihan_e'),
					'jawaban' => $this->input->post('jawaban'),
					'status_soal' => $this->input->post('status_soal'),
					'gambarnya' => $gambar['file_name']
				);
			} else {
				$data = array(
					'soalnya' => $this->input->post('soalnya'),
					'pilihan_a' => $this->input->post('pilihan_a'),
					'pilihan_b' => $this->input->post('pilihan_b'),
					'pilihan_c' => $this->input->post('pilihan_c'),
					'pilihan_d' => $this->input->post('pilihan_d'),
					'pilihan_e' => $this->input->post('pilihan_e'),
					'jawaban' => $this->input->post('jawaban'),
					'status_soal' => $this->input->post('status_soal'),
					'gambarnya' => ''
				);
			}
		} else {
			$data = array(
				'soalnya' => $this->input->post('soalnya'),
				'pilihan_a' => $this->input->post('pilihan_a'),
				'pilihan_b' => $this->input->post('pilihan_b'),
				'pilihan_c' => $this->input->post('pilihan_c'),
				'pilihan_d' => $this->input->post('pilihan_d'),
				'pilihan_e' => $this->input->post('pilihan_e'),
				'jawaban' => $this->input->post('jawaban'),
				'status_soal' => $this->input->post('status_soal'),
				'gambarnya' => ''
			);
		}
		$this->model_soal->update(array('id_soal' => $this->input->post('id_soal')), $data);
		echo json_encode(array("status" => TRUE));
	}
	private function _validate_soal()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if ($this->input->post('soalnya') == '') {
			$data['inputerror'][] = 'soalnya';
			$data['error_string'][] = 'soal tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('pilihan_a') == '') {
			$data['inputerror'][] = 'pilihan_a';
			$data['error_string'][] = 'pilihan a tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('pilihan_b') == '') {
			$data['inputerror'][] = 'pilihan_b';
			$data['error_string'][] = 'pilihan b tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('pilihan_c') == '') {
			$data['inputerror'][] = 'pilihan_c';
			$data['error_string'][] = 'pilihan c tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('pilihan_d') == '') {
			$data['inputerror'][] = 'pilihan_d';
			$data['error_string'][] = 'pilihan d tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('pilihan_e') == '') {
			$data['inputerror'][] = 'pilihan_e';
			$data['error_string'][] = 'pilihan e tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('jawaban') == '') {
			$data['inputerror'][] = 'jawaban';
			$data['error_string'][] = 'jawaban tidak boleh kosong';
			$data['status'] = FALSE;
		}
		if ($this->input->post('status_soal') == '') {
			$data['inputerror'][] = 'status_soal';
			$data['error_string'][] = 'status soal harus dipilih';
			$data['status'] = FALSE;
		}
		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}


}