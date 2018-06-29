<?php
 
class Status extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('status_model');
    }
    
    function index() {
        $this->load->view('status_view');
    }
 
    function json() {
        header('Content-Type: application/json');
        echo $this->status_model->json();
    }

    function simpan(){ //function simpan data
        $data=array(
        'id'           => $this->input->post('statusid'),
        'nama_status'  => $this->input->post('namastatus'),
    );

    $this->db->insert('status', $data);
    redirect('index.php/status');
    }

    //Function 'delete' untuk hapus data
    function delete($id='0'){
    $this->db->where('id',$id);
    $this->db->delete('status');
    redirect('index.php/status');
  }
}
 
?>