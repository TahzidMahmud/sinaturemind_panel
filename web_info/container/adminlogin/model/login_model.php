<?php
class Login_model extends Model{
    function __construct(){
        parent::__construct();
    }

    function getlogindt($user, $pass){
		$conditions[]= "mobile = ?";
		$conditions[]= "xpassword = ?";
		$params[]= $user;
		$params[]= $pass;
		return $this->db->dbselectbyparam('suser','*',$conditions,$params);
	}

    
}

?>