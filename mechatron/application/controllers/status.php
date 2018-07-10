<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('statusModel','status');
	}
	public function index()
	{
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('status/statusView');
        $this->load->view('footer');
    }
    
    public function ajax_list()
	{
		$list = $this->status->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $status) {
			$no++;
            $row = array();
            $row[] = $no;
			$row[] = $status->nama_status;
		
			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_status('."'".$status->id."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_status('."'".$status->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->status->count_all(),
						"recordsFiltered" => $this->status->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->status->get_by_id($id);
	
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'nama_status' => $this->input->post('nama_status'),
			
			);
		$insert = $this->status->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'nama_status' => $this->input->post('nama_status'),
				
			);
		$this->status->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->status->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('nama_status') == '')
		{
			$data['inputerror'][] = 'nama_status';
			$data['error_string'][] = 'nama status wajib diisi';
			$data['status'] = FALSE;
		}

	
		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
	
}