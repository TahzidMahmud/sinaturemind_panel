<?php
class Features_model extends Model{
    function __construct(){
        parent::__construct();
    }

    public function create($table,$data){
		//$this->log->modellog( serialize($data));die;
		return $this->db->insert($table, $data);
	}

    function getcode($trx){
		$conditions[]= "trxid = ?";
		$params[]= $trx;
		return $this->db->dbselectbyparam('expshop','*',$conditions,$params);
	}

    function getusedcode($trx){
		$conditions[]= "xcode = ?";
		$params[]= $trx;
		return $this->db->dbselectbyparam('expshopused','*',$conditions,$params);
	}
   
}

?>