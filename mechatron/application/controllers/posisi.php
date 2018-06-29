<?php
 
class Posisi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('parser', 'datatables');
        $this->load->helper(array('form','url'));
        $this->load->model('posisi_model');
        $this->aData = array(
            'surl'=>site_url()
        );
    }
    
    function index() {
        $this->parser->parse('posisi_view', $this->aData);

    }
 
    function json() {
        header('Content-Type: application/json');
        echo $this->posisi_model->json();
    }

    function delete($id='0'){ 
    $this->db->where('id',$id);
    $this->db->delete('posisi');
    redirect('index.php/posisi');
  }
}
 
?>