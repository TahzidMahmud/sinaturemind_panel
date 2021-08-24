<?php
class Orders extends Controller{
   
    function __construct(){
        parent::__construct();
        Session::init();
        if(!Session::get('adminlogin')){
            header('location: '. URL);
            exit;
        }
        $this->view->pagescript = array("./theme/plugins/dropzone/dropzone.min.js","./theme/assets/js/jquery.autocomplete.js");
        $this->view->pagecss = array("./theme/plugins/dropzone/dropzone.min.css","./theme/assets/css/app-custom.css");
    }
   
    function init(){
        $stat="Pending";
       if(isset($_GET["stat"])){
            $stat = $_GET["stat"];
        }
        $this->view->stat=$stat;
        $this->view->script = $this->script();
        $orders=$this->model->getordermst($stat);
        $this->view->orders=$orders;
        $this->view->count=count($orders);

        $this->view->render("menutemplate","appsettings/orders_view",false);
        
    }
     function voucher(){
         $stst="";
       if(isset($_GET["sl"])){
            $sl = $_GET["sl"];
        }
        $store=Session::get('ssl');
        $orders=$this->model->any("SELECT * , (select xmrp from seitem WHERE xstoreid='$store' AND seitem.xitemid=imtrnonline.xitemid) AS mrp  FROM imtrnonline WHERE xossl='$sl' AND xstoreid='$store' AND xstatus!='Canceled'");
        //   Logdebug::appendlog(print_r($orders,true));
        $this->view->orders=$orders;
        $cancel_order=$this->model->any("SELECT * , (select xmrp from seitem WHERE xstoreid='$store' AND seitem.xitemid=imtrnonline.xitemid) AS mrp  FROM imtrnonline WHERE xossl='$sl' AND xstoreid='$store' AND xstatus='Canceled'");
        $this->view->cancel_order=$cancel_order;
        $store=$this->model->any("SELECT * FROM storemst WHERE xsl='$store'");
        $store=$store[0];
        $this->view->store=$store;
        $this->view->script = $this->script();
        $mst=$this->model->any("SELECT * FROM imtrnonlinemst WHERE xossl='$sl'");
        $mst=$mst[0];
        
        $this->view->mst=$mst;
        $now  = new DateTime;
        $this->view->dt= $now->format( 'd-m-Y' );
        $this->view->tm= $now->format( 'h:m:sa' );
       

        $this->view->render("notemplate","appsettings/voucher_view",false);
        
    }
    function delivered(){
        $this->view->script = $this->script2();
        $orders=$this->model->getordermst_del();
        $this->view->orders=$orders;

        $this->view->render("menutemplate","appsettings/delivered_view",false);
    }
    function getorders(){
        
        $xossl=$_POST['xossl'];
        $res=$this->model->getorders($xossl);
        echo json_encode(array("message"=>"Updated Successfully..!!","result"=>$res));
    }

     function get_del_orders(){
        $xossl=$_POST['xossl'];
        $res=$this->model->get_del_orders($xossl);
        echo json_encode(array("message"=>"Updated Successfully..!!","result"=>$res));
    }
    function updatestat(){
        $ximsl =$_POST['ximsl'];
        $stat=$_POST['stat'];
        $item=$this->model->getitem($ximsl);
            //  Logdebug::appendlog(print_r($item[0]['xstatus'],true));

        $stat=$this->stat_check($stat,$item[0]['xstatus']);
        // Logdebug::appendlog(print_r($stat,true));

   
        
            $qry="UPDATE imtrnonline SET xstatus='$stat' WHERE ximsl='$ximsl'";
            $this->model->updatestat($qry);
            echo json_encode(array("message"=>"Success..!!","id"=> $ximsl,"result"=>$stat));
        
    }
    

    function updatestatmst(){
        $ximsl =$_POST['ximsl'];
        $item=$this->model->getitem($ximsl);
        $xossl=$item[0]['xossl'];
        $ress=$this->model->check_mast($xossl);

        $statt=array();
        for($i=0;$i<count($ress);$i++){
           array_push($statt,$ress[$i]['xstatus']);
        }   
        if(count(array_unique( $statt))==1){
            $temp=array_unique( $statt);
            $st="";
            foreach($temp as $key=>$val){
                $stat=$val;
            }
            $this->model->update_statmst("UPDATE imtrnonlinemst SET xstatus='$val' WHERE xossl= $xossl");
        }
        elseif(count(array_unique( $statt))==2){
             $temp=array_unique( $statt);
                // Logdebug::appendlog(print_r($temp,true));
            if(($temp[0]=='Delivered' || $temp[0]=='Canceled') && ($temp[1]=='Delivered' || $temp[1]=='Canceled')){
                
                 $this->model->update_statmst("UPDATE imtrnonlinemst SET xstatus='Delivered' WHERE xossl= $xossl");
            }else{
                $this->model->update_statmst("UPDATE imtrnonlinemst SET xstatus='Processing' WHERE xossl= $xossl");
            }
            
        }else{
            $this->model->update_statmst("UPDATE imtrnonlinemst SET xstatus='Processing' WHERE xossl= $xossl");
        }   
        
        echo json_encode(array("message"=>$stat,"xossl"=>$xossl));
    }
    function pay_comission(){
        
    }
    function get_sessiondt(){
        $rin=$_SESSION['rin'];
        $mobile=$_SESSION['suser'];
        $name=$_SESSION['sfullname'];
        $date=date("Y-m-d h:i:s");
        $store=Session::get('ssl');
        echo json_encode(array("rin"=>$rin,"mobile"=>$mobile,"name"=>$name,"date"=>$date,"vendor"=>$store));
    }
    function test(){
        $res=json_decode($_POST['apikey']);
        //   Logdebug::appendlog(print_r($_POST['apikey'],true));
        
    }

    function stat_check($t1,$t2){
        $r1=0;
        $r2=0;
        if($t1=="Pending"){
            $r1=0;
        }else if($t1=="Processing"){
            $r1=1;
        }else if($t1=="Canceled"){
            $r1=2;
        }else if($t1=="Delivered"){
            $r1=3;
        }else if($t1=="Clear"){
            $r1=4;
        }else{

        }
        if($t2=="Pending"){
            $r2=0;
        }else if($t2=="Processing"){
            $r2=1;
        }else if($t2=="Canceled"){
            $r2=2;
        }else if($t2=="Delivered"){
            $r2=3;
        }else if($t1=="Clear"){
            $r2=4;
        }else{
            
        }

        if($r1>$r2){
            return $t1;
        }else{
            return $t2;
        }
       

    }

    
    function script(){
        return "
        <script>
       
     $(\"#fltstat\").change(function(){

        var stat=document.getElementById(\"fltstat\").value;
        location.replace(\"".URL."?page=orders&action=init&stat=\"+stat);


    })
        </script>
        ";
    }
      function script2(){
        return "
        <script>
        var pay_total=0;
        var order_list=[]
       
            $('#cal-btn').on('click',function(){
            pay_total=0;
            order_list=[];
                $(\"#dl_table input[type=checkbox]:checked\").each(function () {
                    let tmp=this.value;
                    let tmp2=tmp.split(\" \");
                    order_list.push(tmp2[0]);
                   pay_total+=parseFloat(tmp2[1]);
                });
                 
                 $('#pay-total').val(pay_total);
            });
            $('#pay-btn').on('click',function(){
            pay_total=0;
            order_list=[];
                $(\"#dl_table input[type=checkbox]:checked\").each(function () {
                    let tmp=this.value;
                    let tmp2=tmp.split(\" \");
                    order_list.push(tmp2[0]);
                   pay_total+=parseFloat(tmp2[1]);
                });
                 
               $('#pay-total').val(pay_total);
                $.ajax({
                    url:\"".URL."?page=orders&action=get_sessiondt\", 
                    type:'GET',
                
                    success: function (result) {
                   
                            var res=JSON.parse(result);
                               if(res){
                                var amount=pay_total;
                            //   amount=20;
                                let name=res.name;
                                let mobile=res.mobile;
                                let date=res.date;
                                let rin=res.rin;
                                let type='Retailer';
                                let opost='0';
                                let customer=res.vendor;
                                let callbackurl='https://testng.nagbak.com/?page=del_orders&action=delivered';
                                
                                
                                // var dt_list={name,mobile,date,amount,opost,rin,type};
                                var dt_list=[];
                                dt_list.push(name);
                                dt_list.push(mobile);
                                dt_list.push(date);
                                dt_list.push(amount);
                                dt_list.push(opost);
                                dt_list.push(rin);
                                dt_list.push(type);
  
                                  var params={vendor:mobile, salesdt:dt_list,apikey:\"36cfce7372fc99723569236e883dc4db39669cdf116a57d6d126e05fdea7be3c\", customer:customer,callbackurl:callbackurl}
                                   $.ajax({
                                      url:\"https://portal3.amarbazarltd.com/paynow/\", 
                                      type:'POST',
                                      data:JSON.stringify(params),
                                       success: function (result) {
                                        var reslt=JSON.parse(result);
                                        var message=reslt.message;
                                        var url ='https://portal3.amarbazarltd.com/paynow/paygateway/';
                                        url+=message;
                                         if(reslt.result=\"success\"){
                                            location.replace(url);
                                            }

                                       }
                                    });
                                
                               }else{}
                           
                            }, 
                });
                
            });
           
            
             

        </script>
        ";
    }
}

?>