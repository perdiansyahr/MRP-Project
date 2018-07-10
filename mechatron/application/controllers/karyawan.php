<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('KaryawanModel','karyawan');
	}
	public function index()
	{
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('karyawan/karyawanView');
        $this->load->view('footer');
	}

public function ajax_list()
	{
		$list = $this->karyawan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $karyawan) {
			$no++;
            $row = array();
            $row[] = $no;
			$row[] = $karyawan->nama_karyawan;
			$row[] = $karyawan->tempat_lahir;
			$row[] = $karyawan->tanggal_lahir;
			$row[] = $karyawan->alamat;
			$row[] = $karyawan->no_telp;
			$row[] = $karyawan->status_id;
			$row[] = $karyawan->posisi_id;
			$row[] = $karyawan->tanggal_masuk;
			$row[] = $karyawan->tanggal_keluar;
		
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_karyawan('."'".$karyawan->id_karyawan."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_karyawan('."'".$karyawan->id_karyawan."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->karyawan->count_all(),
						"recordsFiltered" => $this->karyawan->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id_karyawan)
	{
		$data = $this->karyawan->get_by_id($id_karyawan);
	
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_karyawan' => $this->input->post('nama_karyawan'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'alamat' => $this->input->post('alamat'),
				'no_telp' => $this->input->post('no_telp'),
				'status_id' => $this->input->post('status_id'),
				'posisi_id' => $this->input->post('posisi_id'),
				'tanggal_masuk' => $this->input->post('tanggal_masuk'),
				'tanggal_keluar' => $this->input->post('tanggal_keluar'),

			);
		$insert = $this->karyawan->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_karyawan' => $this->input->post('nama_karyawan'),
				'tempat_lahir' => $this->input->post('tempat_lahir'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'alamat' => $this->input->post('alamat'),
				'no_telp' => $this->input->post('no_telp'),
				'status_id' => $this->input->post('status_id'),
				'posisi_id' => $this->input->post('posisi_id'),
				'tanggal_masuk' => $this->input->post('tanggal_masuk'),
				'tanggal_keluar' => $this->input->post('tanggal_keluar'),				
			);
		$this->karyawan->update(array('id_karyawan' => $this->input->post('id_karyawan')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id_karyawan)
	{
		$this->karyawan->delete_by_id($id_karyawan);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_karyawan') == '')
		{
			$data['inputerror'][] = 'nama_karyawan';
			$data['error_string'][] = 'nama karyawan wajib diisi';
			$data['status'] = FALSE;
		}

	
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
}