<?php 
class Sslpay extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->script="";
        
    }

    function makepayment(){
        Session::init();
        $token = $_GET['token'];
        
        $data = json_decode(Session::get($token));
         
        
        global $invoice_no;
        global $amount;
        if($data->amount){
            $amount=$data->amount;
        }else{
            $amount = 1000;
        }
       
        $invoice_no = "ssl-".uniqid();
        if($data->smscount){
            $numitems=$data->smscount;
        }else{
            $numitems = 1;
        }
      
        $pass = Hash::create('sha256',$data->password,HASH_KEY);
        $type="";
        if($data->type != "smsbuy"){
            $type='registration';
            $cols = "insert into store_temp (xtemptxn,xstore,xfullname,xorgname,xaddress,xdistrict,xthana,xaccplan,xbizcat,xcontact,xemail,xpassword,xpaymethod,xamount,xcallback) values";
            $vals = "('".$invoice_no."','".$data->mobile."','".$data->ownername."','".$data->orgname."','".$data->address."','".$data->district."','".$data->thana."','".$data->accplan."','".$data->bizcat."','".$data->contact."','".$data->email."','".$pass."','SSLCOMMERZE',".$amount.",'".$data->callbackurl."')";

        }else{
            // Logdebug::appendlog(print_r($data->type, true));
            $type='smspay';
            $cols = "insert into store_temp (xtemptxn,xstore,xfullname,xorgname,xaddress,xdistrict,xthana,xaccplan,xbizcat,xcontact,xemail,xpassword,xpaymethod,xamount,xcallback) values";
            $vals = "('".$invoice_no."','".$_SESSION["ssl"]."','".$_SESSION["sfullname"]."','".$_SESSION["sfullname"]."','".$_SESSION["saddress"]."','".$_SESSION["saddress"]."','','smspay','','".$_SESSION["suser"]."','info@dotbd.com','".$pass."','SSLCOMMERZE',".$amount.",'".$data->callbackurl."')";
            //   Logdebug::appendlog(print_r($data->callbackurl, true));

           

        }
        $result = $this->model->updatetemp($cols.$vals);
       
        if($result==0){
            echo json_encode(array("result"=>"failed", "message"=>"Could not ceate invoice!"));
            exit;
        }
       
        $post_data = array();

        $post_data['total_amount'] = $amount;//$_POST['amount'];
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = $invoice_no;
        $post_data['type']=$type;

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $_SESSION["sfullname"];
        $post_data['cus_email'] = 'info@dotbd.com';
        $post_data['cus_add1'] = $_SESSION["saddress"];
        $post_data['cus_add2'] = $_SESSION["saddress"];
        $post_data['cus_city'] = 'NA';
        $post_data['cus_state'] = 'NA';
        $post_data['cus_postcode'] = '0000';
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $_SESSION["suser"];
        //$post_data['cus_fax'] = "01711111111";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $_SESSION["sfullname"];
         $post_data['ship_add1'] =$_SESSION["saddress"];
         $post_data['ship_add2'] = $_SESSION["saddress"];
        $post_data['ship_city'] = 'NA';
        $post_data['ship_state'] = 'NA';
        $post_data['ship_postcode'] = '0000';
        $post_data['ship_phone'] = $_SESSION["suser"];
        $post_data['ship_country'] = "Bangladesh";

       

        $post_data['emi_option'] = "0";
        

        $post_data["product_category"] = "Ecommerce";
        $post_data["product_name"] = "Ecommerce Items";
        
         $post_data["shipping_method"] = "Courier";
         $post_data["num_of_item"] = $numitems;
        

        # SPECIAL PARAM
        $post_data['tokenize_id'] = "1";

        # 1 : Physical Goods
        # 2 : Non-Physical Goods Vertical(software)
        # 3 : Airline Vertical Profile
        # 4 : Travel Vertical Profile
        # 5 : Telecom Vertical Profile

        $post_data["product_profile"] = "general";
        $post_data["product_profile_id"] = "5";

        //$post_data["topup_number"] = "01711111111"; # topUpNumber
        //Logdebug::appendlog(serialize($post_data));
        # First, save the input data into local database table `orders`
        //$query = new OrderTransaction();
        //$sql = $query->saveTransactionQuery($post_data);

        // if ($conn_integration->query($sql) === TRUE) {

        //     # Call the Payment Gateway Library
             $sslcomz = new SslCommerzNotification();
            //   Logdebug::appendlog(print_r($sslcomz->makePayment($post_data, 'hosted'), true));
             
             $sslcomz->makePayment($post_data, 'hosted');
        // } else {
        //     echo "Error: " . $sql . "<br>" . $conn_integration->error;
        // }
    }

    function sslsuccess(){
        //Session::init();
        // Logdebug::appendlog(print_r($_POST, true));
        //Logdebug::appendlog(print_r($_POST,true)); echo 'success'; die;
        $sslc = new SslCommerzNotification();
        
        $hostcallback="";
        if(!isset($_POST['tran_id'])){
            // Logdebug::appendlog(print_r($_POST,true));
            $this->finalcallback('0', 'failed',"");
            exit;
        }
        $tran_id = $_POST['tran_id'];
        $amount =  $_POST['amount'];
        $currency =  $_POST['currency'];
        $hostcallback="";
        $validation = $sslc->orderValidate($tran_id, $amount, $currency, $_POST);
        //Logdebug::appendlog($validation);
        $tran_id = (string)$tran_id;
        $status= "failed";
        $invoice=0;
        if ($validation == TRUE) {
        $status= "Success";
        $tord = $this->model->gettemporder($tran_id);
        $date = date('Y-m-d');
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date)); 
        
        //   Logdebug::appendlog(print_r($tord[0], true));
       if($tord[0]['xstatus']=='Success'){
           $this->finalcallback("", 'Failed',$tord[0]['xcallback']);
           exit;
       }
       
       $ordered = $this->model->isordered($tran_id);

       if(count($ordered)>0){
        $this->finalcallback("", 'Failed',$tord[0]['xcallback']);
        exit;
       }
    
        
            $updatetemp = $this->model->updatetemp("update store_temp set xstatus='".$status."' where xtemptxn='".$tran_id."'");
            
           if( $tord[0]['xaccplan']!='smspay'){
                $cols = "insert into storemst (xtemptxn,xstore,xfullname,xorgname,xaddress,xdistrict,xthana,xaccplan,xbizcat,xcontact,xemail,xpassword,xpaymethod,xamount) values";
                $vals = "('".$tord[0]['xtemptxn']."','".$tord[0]['xstore']."','".$tord[0]['xfullname']."','".$tord[0]['xorgname']."','".$tord[0]['xaddress']."','".$tord[0]['xdistrict']."','".$tord[0]['xthana']."','".$tord[0]['xaccplan']."','".$tord[0]['xbizcat']."','".$tord[0]['xcontact']."','".$tord[0]['xemail']."','".$tord[0]['xpassword']."','SSLCOMMERZE',".$tord[0]['xamount'].")";
            
                $invoice = $this->model->updatetemp($cols.$vals);
           }else{
               $xbel=(int)$tord[0]['xamount']/0.20;
                $cols = "insert into smsbel (xstoreid,bizid,xbel) values";
                $vals = "('".$tord[0]['xstore']."','100','".$xbel."')";
            
                $invoice = $this->model->updatetemp($cols.$vals);
            }
       
            $hostcallback = $tord[0]['xcallback'];
            
            
        }


        $this->finalcallback($invoice, $status,$hostcallback);
    }

    function finalcallback($invoice, $status, $hostcallback){
        //Session::init();
        $this->view->status = $status;
        $this->view->invoice = $invoice;
        $this->view->callback = $hostcallback;
        $this->view->render("notemplate","payment/callback");
    }

    function sslfail(){
        $tran_id = $_POST['tran_id'];
        $tord = $this->model->gettemporder($tran_id);
        $hostcallback = $tord[0]['xcallback'];
        //Logdebug::appendlog();
        $this->finalcallback('0', 'fail',$hostcallback);
    }
    
    function sslcancel(){
        $tran_id = $_POST['tran_id'];
        $tord = $this->model->gettemporder($tran_id);
        $hostcallback = $tord[0]['xcallback'];
        $this->finalcallback('0', 'fail',$hostcallback);
    }

    function sslipn(){
        
    }
    

}
?>