<?php
 
class Status_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    function json() {
        $this->datatables->select('id,nama_status');
        $this->datatables->from('status');
        $this->datatables->add_column('view', '<a href="status/edit/$1">edit</a> | <a href="status/delete/$1">delete</a>', 'id');
        return $this->datatables->generate();
    }
}
 
?>