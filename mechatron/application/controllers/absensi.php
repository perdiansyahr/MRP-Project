<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('absensiModel','absensi');
	}
	public function index()
	{
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('absensi/absensiView');
        $this->load->view('footer');
	}

public function ajax_list()
	{
		$list = $this->absensi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $absensi) {
			$no++;
            $row = array();
            $row[] = $no;
			$row[] = $absensi->karyawan_id;
			$row[] = $absensi->tanggal;
			$row[] = $absensi->jam_masuk;
			$row[] = $absensi->jam_keluar;
			$row[] = $absensi->kegiatan;
		
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_absensi('."'".$absensi->id_absensi."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_absensi('."'".$absensi->id_absensi."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->absensi->count_all(),
						"recordsFiltered" => $this->absensi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id_absensi)
	{
		$data = $this->absensi->get_by_id($id_absensi);
	
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'tanggal' => $this->input->post('tanggal'),
				'jam_masuk' => $this->input->post('jam_masuk'),
				'jam_keluar' => $this->input->post('jam_keluar'),
				'kegiatan' => $this->input->post('kegiatan'),
			);
		$insert = $this->absensi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'karyawan_id' => $this->input->post('karyawan_id'),
				'tanggal' => $this->input->post('tanggal'),
				'jam_masuk' => $this->input->post('jam_masuk'),
				'jam_keluar' => $this->input->post('jam_keluar'),
				'kegiatan' => $this->input->post('kegiatan'),		
			);
		$this->absensi->update(array('id_absensi' => $this->input->post('id_absensi')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id_absensi)
	{
		$this->absensi->delete_by_id($id_absensi);
		echo json_encode(array("status" => TRUE));
	}

	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('karyawan_id') == '')
		{
			$data['inputerror'][] = 'karyawan_id';
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