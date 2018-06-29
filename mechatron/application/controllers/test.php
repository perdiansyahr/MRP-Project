<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
      public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
       	$this->load->view('testView');
    }
    public function testlain()
    {
        $this->load->view('testView2'); 
    }
    public function testlain2($judul, $coba='default')
    {
        $data['title'] = $judul;
        $data['testaja'] = $coba;
        $this->load->view('testView3', $data); 
    }
    public function testlain3($judul, $coba='default')
    {
        $data['title'] = $judul;
        $data['testaja'] = $coba;
        $this->load->view('testView3top', $data); 
        $this->load->view('testView3bot', $data); 
    }
    public function testmodel1($judul='')
    {
        $this->load->model('posisiModel');
        $data['title'] = $judul;
        $data['total'] = $this->posisiModel->totalPosisi();
        $this->load->view('testViewModel', $data);
        
    }
    public function testmodel2($judul='')
    {
        $this->load->model('posisiModel');
        $data['title'] = $judul;
        $data['list'] = $this->posisiModel->listPosisi();
        $this->load->view('testViewModel2', $data);
        
    }
    public function testmodel3($judul='')
    {
        $this->load->view('header');
        $this->load->view('menu');
        $this->load->view('testViewGrid');
        
    }
    public function listdata()
    {
        $this->load->model('posisiModel');
        $data['list'] = $this->posisiModel->listPosisi();
      //  $result = '{"data":'. json_encode($data['list']).'}';
      $result  = 'success';
      $message = 'query success';
        foreach ($data['list'] as $daftar){
            $functions  = '<div>
                            <button class="btn btn-info" id="editData" data-id="'   . $daftar['id'] . '" data-name="' . $daftar['nama_posisi'] . '">
                                EDIT
                                <i class="glyph-icon icon-edit"></i>
                            </button>&nbsp&nbsp<button class="btn btn-warning" id="deleteData" data-id="'   . $daftar['id'] . '" data-name="' . $daftar['nama_posisi'] . '">
                                DELETE
                                <i class="glyph-icon icon-trash"></i>
                            </button>
                           </div>';
            $hasil[] = array(
              "id"          => $daftar['id'],
              "nama_posisi"  => $daftar['nama_posisi'],
              "functions"     => $functions
            );
        }
        $data = array(
            "result"  => $result,
            "message" => $message,
            "data"    => $hasil
          );
          
          // Convert PHP array to JSON array
          $json_data = json_encode($data);
          print $json_data;
        //echo $result;
    }
    public function deldata($id='')
    {
        if ($id == ''){
            $result  = 'error';
            $message = 'id missing';
          } else {
           $this->load->model('posisiModel');
           $this->posisiModel->deleteData($id);
          }
    }

    public function adddata()
    {

    }

    public function editdata()
    {

    }
}