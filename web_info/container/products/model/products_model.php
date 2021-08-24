<?php
class Products_model extends Model{

    function __construct(){
        Session::init();
        parent::__construct();
    }

    function create($table,$data){
		//$this->log->modellog( serialize($data));die;
		return $this->db->insert($table, $data);
	}
    public function fetchcats($table,$fields){
        return $this->db->dbselectbyparam($table,$fields);

    }
    public function any($qry){
        return $this->db->dbselect($qry);
    }
   
    public function fetchbrands($table,$fields){
        return $this->db->dbselectbyparam($table,$fields);

    }
    public function update($table, $data, $where){
		
		return $this->db->dbupdate($table, $data, $where);
	}
	function findlastitemssrc($itemcount,$qry){
	    if($qry!=""){
	        return $this->db->select('seitem',array("xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,round(xstdprice,2) as salesprice,round(xstock,2) as stock
        ,xstatus as status,xunitstk as unit,ximages as images,xprops as props,xpricebasis as pricebasis,round(xmrp,2) as mrp, xreorder as reorderlevel, xdisc as discount, zactive as active,ablpercent"), " xstoreid = ".Session::get('ssl')." and xdesc like '%$qry%' order by ztime DESC LIMIT $itemcount");
	    }else{
	        return $this->db->select('seitem',array("xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,round(xstdprice,2) as salesprice,round(xstock,2) as stock
        ,xstatus as status,xunitstk as unit,ximages as images,xprops as props,xpricebasis as pricebasis,round(xmrp,2) as mrp, xreorder as reorderlevel, xdisc as discount, zactive as active,ablpercent"), " xstoreid = ".Session::get('ssl')." order by ztime DESC LIMIT $itemcount");
	    }
	    
	    
	    
	}

   function findlastitems($itemcount,$stat){
        //  Logdebug::appendlog(print_r($itemcount, true));
        //   Logdebug::appendlog(print_r($stat, true));
       $q="";
       if($stat!=""){
           if($stat=='active'){
               $q=1;
           }else{
               $q=0;
           }
            // Logdebug::appendlog(print_r("run 2", true));
           return $this->db->select('seitem',array("xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,round(xstdprice,2) as salesprice,round(xstock,2) as stock
        ,xstatus as status,xunitstk as unit,ximages as images,xprops as props,xpricebasis as pricebasis,round(xmrp,2) as mrp, xreorder as reorderlevel, xdisc as discount, zactive as active,ablpercent"), " xstoreid = ".Session::get('ssl')." and zactive='$q' order by ztime DESC LIMIT $itemcount");
           
       }else{
            // Logdebug::appendlog(print_r("run 1", true));
            return $this->db->select('seitem',array("xitemid as itemid,xitemcode as itemcode,xdesc as itemdesc,xlongdesc as longdesc,round(xstdprice,2) as salesprice,round(xstock,2) as stock
        ,xstatus as status,xunitstk as unit,ximages as images,xprops as props,xpricebasis as pricebasis,round(xmrp,2) as mrp, xreorder as reorderlevel, xdisc as discount, zactive as active,ablpercent"), " xstoreid = ".Session::get('ssl')." order by ztime DESC LIMIT $itemcount");
       }
       
    }

    public function fetchsubcats($table,$fields){
       
        // return $this->db->select('onlinesubcat',array("*"),"xcatsl=".$xcatsl);
        return $this->db->dbselectbyparam($table,$fields);
    }
    public function fetchbrand($xcatsl){
        return $this->db->select('onlinebrand',array("*"),"xcatsl=".$xcatsl);
    }
    public function filtersearch($xcat="",$xsubcat="",$xdesc=""){
        
        $where = "1=1";
        if($xcat!="Select Category"){
            $where .= " and xcat= '$xcat'";
        }
        if($xsubcat!="Select Sub-Category"){
            $where .= " and xsubcat= '$xsubcat'";
        }
        if($xdesc!=""){
            $where .= " and xdesc LIKE '%$xdesc%'";
        }
        $searchres = $this->db->select('seitemext',array("*"),$where." and xitemid NOT IN (SELECT xitemid FROM seitem WHERE xstoreid ='".Session::get('ssl')."')");
        //  Logdebug::appendlog(print_r($searchres, true));
      
    return $searchres;


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
        xfeature as fetures,ximages as images,zactive as isactive,xunitstk as itemunit, xstock as stock";
		return $this->db->dbselectbyparam('seitem',$fields,$conditions,$params);
    }
    function fetchitem($id){
        return $this->db->select('seitemext',array('*'),"xitemid='$id'");
    }
}

?>