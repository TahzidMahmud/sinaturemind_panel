<?php
class Itemmaster_model extends Model{

    function __construct(){
        parent::__construct();
    }

    function create($table,$data){
// 	 Logdebug::appendlog(print_r($data, true));
// 	  Logdebug::appendlog(print_r($table, true));
		return $this->db->insert($table, $data);
	}
	 public function any($qry){
        return $this->db->dbselect($qry);
    }
   
    public function fetchcats($table,$fields){
        return $this->db->dbselectbyparam($table,$fields);

    }
    public function fetchbrands($table,$fields){
        return $this->db->dbselectbyparam($table,$fields);

    }
    public function update($table, $data, $where){
		
		return $this->db->dbupdate($table, $data, $where);
	}

    function findlastitems($itemcount){
        return $this->db->select('seitem',array("xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,round(xstdprice,2) as salesprice,round(xstock,2) as stock
        ,xstatus as status,xunitstk as unit,ximages as images,xprops as props,xpricebasis as pricebasis,round(xmrp,2) as mrp, xreorder as reorderlevel, xdisc as discount, zactive as active,ablpercent"), " xstoreid = ".Session::get('ssl')." order by ztime DESC LIMIT $itemcount");
    }
    public function fetchsubcats($xcatsl){
       
        return $this->db->select('onlinesubcat',array("*"),"xcatsl=".$xcatsl);
    }
    public function fetchbrand($xcatsl){
        return $this->db->select('onlinebrand',array("*"),"xcatsl=".$xcatsl);
    }

    function finditems($srcst){
        $conditions[]= "xstoreid = ?";
        $conditions[]= "xdesc like ?";
		$params[]= Session::get('ssl');
        $params[]= "%".$srcst."%";
        
		return $this->db->dbselectbyparam('seitem',"xitemid as data, CONCAT(xdesc,' ',xitemid) as value",$conditions,$params);
    }

    function finditembyid($srcstr){
        $conditions[]= "xstoreid = ?";
        $conditions[]= "xitemid = ?";
		$params[]= Session::get('ssl');
        $params[]= $srcstr;
        $fields = "xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,xcat as cat,xsubcat as subcat,
        xbrand as brand,xstdprice as salesprice,xpricebasis as pricebasis,xrelated as relateditem,xprops as props,
        xfeature as fetures,ximages as images,zactive as isactive,xunitstk as itemunit, xstock as stock ,ablpercent,xmrp as mrp";
		return $this->db->dbselectbyparam('seitem',$fields,$conditions,$params);
    }


    public function filtersearch($xcat,$xsubcat,$xdesc=""){
        $query="";
        if($xcat != "Select Category..." && $xsubcat != "Select Sub-Category..." && $xdesc!=""){
            return $this->db->select('seitem',array("*"),"xcat= '$xcat'  and xsubcat = '$xsubcat' and xdesc Like '%$xdesc%'");
        }else{
          
           if($xcat != "Select Category..."){
                $query.="xcat= '$xcat'";
           }if($xsubcat != "Select Sub-Category..."){

            $query.= $query!=""?"and xcat= '$xsubcat'":"xcat= '$xsubcat'";
                
           }if($xdesc!=""){
                $query.= $query!=""?"and xdesc Like '%$xdesc%'":"xdesc Like '%$xdesc%'";
           }
            // Logdebug::appendlog(print_r($query,true));


           return $this->db->select('seitem',array("*"),$query);
        }


    }
}


?>