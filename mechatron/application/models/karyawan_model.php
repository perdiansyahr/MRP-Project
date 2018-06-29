<?php
 
class Karyawan_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function json() {
	    $this->datatables->select('a.id_karyawan, a.nama, a.tempat_lahir, a.tgl_lahir, a.jenis_kelamin, a.no_telp, b.nama_posisi, c.nama_status, a.tgl_masuk, a.tgl_keluar');
	    $this->datatables->from('karyawan AS a');
	    $this->datatables->join('posisi AS b','a.posisi_id=b.id');
	    $this->datatables->join('status AS c','a.status_id=c.id');
		$this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-xs" data-id="$1" data-nama="$2" data-tempatlahir="$3" data-tanggallahir="$4" data-jeniskelamin="$5" data-telp="$6" data-posisi="$7" data-status="$8" data-tanggalmasuk="$9" data-tanggalkeluar="$10">Edit</a>  <a href="javascript:void(0);" class="hapus_record btn btn-danger btn-xs" data-id="$1">Hapus</a>','id_karyawan, nama, tempat_lahir, tgl_lahir, jenis_kelamin, no_telp, nama_posisi, nama_status, tgl_masuk, tgl_keluar');
        return $this->datatables->generate();
    }
}
 
?>