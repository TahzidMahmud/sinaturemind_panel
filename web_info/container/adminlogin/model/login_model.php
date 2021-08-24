<?php
class Login_model extends Model{
    function __construct(){
        parent::__construct();
    }

    function getlogindt($user, $pass){
		$conditions[]= "xstore = ?";
		$conditions[]= "xpassword = ?";
		$params[]= $user;
		$params[]= $pass;
		return $this->db->dbselectbyparam('storemst','*',$conditions,$params);
	}

    
}

?>