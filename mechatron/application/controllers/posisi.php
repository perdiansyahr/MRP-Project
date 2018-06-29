<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posisi extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('PosisiModel','posisi');
	}
	public function index()
	{
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('posisiView');
        $this->load->view('footer');
    }
    
    public function ajax_list()
	{
		$list = $this->posisi->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $posisi) {
			$no++;
            $row = array();
            $row[] = $no;
			$row[] = $posisi->nama_posisi;
		
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_posisi('."'".$posisi->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_posisi('."'".$posisi->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->posisi->count_all(),
						"recordsFiltered" => $this->posisi->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->posisi->get_by_id($id);
	
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_posisi' => $this->input->post('nama_posisi'),
			
			);
		$insert = $this->posisi->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_posisi' => $this->input->post('nama_posisi'),
				
			);
		$this->posisi->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->posisi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_posisi') == '')
		{
			$data['inputerror'][] = 'nama_posisi';
			$data['error_string'][] = 'nama posisi wajib diisi';
			$data['status'] = FALSE;
		}

	
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}