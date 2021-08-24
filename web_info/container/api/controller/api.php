<?php
class Api extends Controller{

    function __construct(){
        parent::__construct();
       
       
    }   
    function getsms(){
        $lastsl=$_POST['lastsl'];
        $channel=$_POST['channel'];
        $res=$this->model->any("SELECT xsl,xnumber,xbody FROM smstxn WHERE xsl > $lastsl AND  xchannel='$channel' LIMIT 50");
       
        echo json_encode(array("result"=>$res));
    }
    function store_list(){
        $store_list=$this->model->any("SELECT *,(SELECT COUNT(xitemid) FROM `seitem` WHERE xstoreid=storemst.xsl AND zactive='1' GROUP BY xstoreid) AS product_count FROM storemst");
          echo json_encode(array("stores"=>$store_list));
        
    }
    function total_sales_list(){
        $total_sales_list=$this->model->any("SELECT *,(SELECT COUNT(`xossl`) AS cnt FROM `imtrnonlinemst`  WHERE xstoreid=storemst.xsl GROUP BY `xstoreid` ) AS total_sales,(SELECT SUM(`xprice` * `xqty`) AS cnt FROM `imtrnonline`  WHERE xstoreid=storemst.xsl GROUP BY `xstoreid` ) AS sales_amount  FROM storemst");
          echo json_encode(array("stores"=>$total_sales_list));
        
    }
    function delivered_list(){
        $delivered_list=$this->model->any("SELECT *,(SELECT COUNT(`xossl`) AS cnt FROM `imtrnonlinemst`  WHERE xstoreid=storemst.xsl AND xstatus IN ('Delivered')  GROUP BY `xstoreid` ) AS total_sales,(SELECT SUM(`xprice` * `xqty`) AS cnt FROM `imtrnonline`  WHERE xstoreid=storemst.xsl AND xstatus IN ('Delivered')  GROUP BY `xstoreid` ) AS sales_amount  FROM storemst");
          echo json_encode(array("stores"=>$delivered_list));
        
    }
    function canceled_list(){
        $canceled_list=$this->model->any("SELECT *,(SELECT COUNT(`xossl`) AS cnt FROM `imtrnonlinemst`  WHERE xstoreid=storemst.xsl AND xstatus IN ('Delivered') GROUP BY `xstoreid` ) AS total_sales,(SELECT SUM(`xprice` * `xqty`) AS cnt FROM `imtrnonline`  WHERE xstoreid=storemst.xsl AND xstatus IN ('Delivered') GROUP BY `xstoreid` ) AS sales_amount  FROM storemst");
          echo json_encode(array("stores"=>$canceled_list));
        
    }
  
    function script(){
        return "
        <script>
         
        </script>
        ";
    }
}

?>