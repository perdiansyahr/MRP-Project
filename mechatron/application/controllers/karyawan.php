<?php
 
class Karyawan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('datatables');
        $this->load->model('karyawan_model');
    }
    
    function index() {
        $this->load->view('karyawan_view');
    }
 
    function json() {
        header('Content-Type: application/json');
        echo $this->karyawan_model->json();
    }

	function simpan(){ //function simpan data
	$data=array(

	  'id_karyawan'   => $this->input->post('karyawanid'),
	  'nama'          => $this->input->post('namakaryawan'),
	  'tempat_lahir'  => $this->input->post('tempatlahir'),
	  'tgl_lahir'     => $this->input->post('tanggallahir'),
	  'jenis_kelamin' => $this->input->post('jeniskelamin'),
	  'no_telp'       => $this->input->post('nomortelepon'),
	  'nama_posisi'   => $this->input->post('namaposisi'),
	  'nama_status'   => $this->input->post('namastatus'),
	  'tgl_masuk'     => $this->input->post('tanggalmasuk'),
	  'tgl_keluar'    => $this->input->post('tanggalkeluar')
	);
		$this->db->insert('karyawan', $data);
		redirect('karyawan');
	}


    function delete(){ //function hapus data
    $id=$this->input->post('karyawanid');
    $this->db->where('id_karyawan',$id);
    $this->db->delete('karyawan');
    redirect('karyawan');
  }
}