<?php
class Salesdashboard extends Controller{
    
    function __construct(){
        parent::__construct();
       
        Session::init();
        if(!Session::get('adminlogin')){
            header('location: '. URL);
            exit;
        }
        $this->view->pagescript = array();
        $this->view->pagecss = array();
        
    }
    
    public function init(){
        $ssl=Session::get('ssl');
        $total=0;
        $trecev=0;
        $this->view->script = $this->script();
        $totalordr= $this->model->any("SELECT COUNT(ximsl) as 'count' FROM imtrnonline WHERE xstoreid=$ssl");
        $this->view->totalordr=$totalordr[0]["count"];
// OR xstatus='Clear'
        $delord= $this->model->any("SELECT COUNT(ximsl) as 'count' FROM imtrnonline WHERE  xstoreid=$ssl AND xstatus IN('Delivered' ,'Clear')");
    
        $this->view->delord=$delord[0]["count"];

        $ordpen= $this->model->any("SELECT COUNT(ximsl) as 'count' FROM imtrnonline WHERE xstoreid=$ssl AND xstatus='Pending'");
       
        $this->view->ordpen=$ordpen[0]["count"];
        $ordproc= $this->model->any("SELECT COUNT(ximsl) as 'count' FROM imtrnonline WHERE xstoreid=$ssl AND xstatus='Processing'");
        // Logdebug::appendlog(print_r($ordproc,true));
        $this->view->ordproc=$ordproc[0]["count"];
        $tt= $this->model->any("SELECT xprice , xqty  FROM imtrnonline WHERE xstoreid=$ssl");
        Logdebug::appendlog(print_r($tt,true));
        foreach($tt as $t){
            $total+=$t["xprice"]*$t["xqty"];
        }
        $this->view->total=$total;
        $tr= $this->model->any("SELECT xprice , xqty  FROM imtrnonline WHERE  xstatus in('Delivered','Clear') AND xstoreid=$ssl");
        // Logdebug::appendlog(print_r($tt,true));
        foreach($tr as $t){
            $trecev+=$t["xprice"]*$t["xqty"];
        }
        $this->view->trecev=$trecev;
      



        $this->view->render("menutemplate","storepage/salesdashboard_view",false);
    }
    
    function script(){
        return "
        <script>
           
        </script>
        ";
    }
    
    
}

?>