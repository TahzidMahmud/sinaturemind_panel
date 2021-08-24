<?php
class Buysms_model extends Model{

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
}


?>