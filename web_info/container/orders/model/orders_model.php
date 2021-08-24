<?php
class Orders_model extends Model{
	function __construct(){
        Session::init();
        parent::__construct();
    }

    function any($qry){
        return $this->db->dbselect($qry);
    }
    function getlogindt($user, $pass){
		$conditions[]= "xstore = ?";
		$conditions[]= "xpassword = ?";
		$params[]= $user;
		$params[]= $pass;
		return $this->db->dbselectbyparam('storemst','*',$conditions,$params);
	}
	function getordermst_del(){
	    $ssl=Session::get('ssl');
		
		$orders=array();
		$res=$this->db->dbselect("SELECT xossl FROM imtrnonline WHERE  xstoreid='$ssl' AND xstatus!='Clear' GROUP BY xossl ORDER BY xdate");
		foreach($res as $rs){
			$r=$rs["xossl"];
			$stat="";
			$temp=$this->db->dbselect("SELECT * FROM imtrnonlinemst WHERE  xossl=$r  ORDER BY xdate")[0];
			$tmp=$this->db->dbselect("SELECT xstatus FROM imtrnonline WHERE  xstoreid='$ssl' AND  xossl=$r AND xstatus!='Clear' AND xstatus='Delivered' ORDER BY xdate");
        	// Logdebug::appendlog(print_r($tmp,true));
			$arr=array();
			foreach($tmp as $t){
				array_push($arr,$t["xstatus"]);
			}
        	// Logdebug::appendlog(print_r($arr,true));

			if(count(array_unique($arr))==1){
				foreach($arr as $key=>$val){
					$temp["xstatus"]=$val;
				}
		
			}else{
			$temp["xstatus"]='Processing';

			}
			array_push($orders,$temp);
		}
		return $orders;
	}

	function getordermst($stat){
	    $q="";
	    if($stat!=""){
	        $q="AND xstatus='$stat'";
	    }
	    	
		$ssl=Session::get('ssl');
		
		$orders=array();
		$res=$this->db->dbselect("SELECT xossl FROM imtrnonline WHERE  xstoreid='$ssl' GROUP BY xossl ORDER BY xdate DESC");
		foreach($res as $rs){
			$r=$rs["xossl"];
			$stat="";
			$temp=$this->db->dbselect("SELECT * FROM imtrnonlinemst WHERE  xossl=$r $q  ORDER BY xdate DESC")[0];
                if($temp){
                    array_push($orders,$temp);
                }     
			
		}
// 		Logdebug::appendlog(print_r($orders,true));
		return $orders;
	}
		function getorders($xossl){
		// 'imtrnonline',array("*"),"xossl=$xossl xstoreid='".Session::get('ssl')."' ORDER BY xdate"
		$ssl=Session::get('ssl');
		return $this->db->dbselect("SELECT * FROM imtrnonline WHERE xossl=$xossl AND xstoreid='$ssl' ORDER BY xdate");
	}
	function get_del_orders($xossl){
	    $ssl=Session::get('ssl');
		return $this->db->dbselect("SELECT * FROM imtrnonline WHERE xossl=$xossl AND xstoreid='$ssl' AND xstatus='Delivered' ORDER BY xdate");
	}
	function getitem($val){
		$ssl=Session::get('ssl');
		$res= $this->db->dbselect("SELECT * FROM imtrnonline WHERE  xstoreid='$ssl' AND ximsl=$val");
       return $res;

	}
	function updatestat($query){
		return $this->db->dbselect($query);
	}
	function check_stat_mst($val){
		$ssl=Session::get('ssl');
		return $res=$this->db->dbselect("SELECT * FROM imtrnonline WHERE  xstoreid='$ssl' AND xossl=$val ORDER BY xdate");
	}
	function update_statmst($query){
		return $this->db->dbselect($query);
	}
    function check_mast($xossl){
		$ssl=Session::get('ssl');
		return $res=$this->db->dbselect("SELECT xstatus FROM imtrnonline  Where xossl=$xossl  ORDER BY xdate");
	}
}

?>