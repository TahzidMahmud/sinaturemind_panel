<?php
class Profile_model extends Model{

    function __construct(){
        parent::__construct();
    }

   
    public function update($qry){
		
		return $this->db->dbselect($qry);
	}
    public function getstore(){
        $ssl=Session::get('ssl');
        return $this->db->dbselect("SELECT * FROM storemst WHERE xsl='$ssl' ");
    }
    public function any($qry){
		
		return $this->db->dbselect($qry);
	}
     function create($table,$data){
// 	 Logdebug::appendlog(print_r($data, true));
// 	  Logdebug::appendlog(print_r($table, true));
		return $this->db->insert($table, $data);
	}
}


?>