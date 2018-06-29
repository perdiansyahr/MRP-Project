<?php
Class KaryawanModel extends CI_Model
{
    public function __construct()
	{
		$this->load->database();
    }
    public function totalKaryawan()
    {
        $this->db->select('count(*) AS jumlah');
        $this->db->from('karyawan');
        //return $this->db->get()->result();
        $query = $this->db->get();
        return $query->row()->jumlah;
    }
}