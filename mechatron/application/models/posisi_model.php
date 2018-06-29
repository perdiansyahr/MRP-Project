<?php
 
class Posisi_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function json() {
        $this->datatables->select('id,nama_posisi');
        $this->datatables->from('posisi');
        $this->datatables->add_column('view', '<a href="posisi/edit/$1">edit</a> | <a href="posisi/delete/$1">delete</a>', 'id');
        return $this->datatables->generate();
    }
}
 
?>