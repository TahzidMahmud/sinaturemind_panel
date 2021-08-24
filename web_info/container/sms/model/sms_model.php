<?php
class Sms_model extends Model{

    function __construct(){
        parent::__construct();
    }

    public function getstore(){
        $ssl=Session::get('ssl');
        return $this->db->dbselect("SELECT * FROM storemst WHERE xsl='$ssl' ");
    }
    public function create($table,$data){
        return $this->db->insert($table, $data);
    }
    public function any($qry){
        return $this->db->dbselect($qry);
    }
}


?>