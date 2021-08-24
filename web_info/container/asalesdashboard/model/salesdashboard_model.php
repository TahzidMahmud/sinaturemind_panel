<?php
class Salesdashboard_model extends Model{
    function __construct(){
        parent::__construct();
    }

    public function any($qry){
        return $this->db->dbselect($qry);
    }
}

?>