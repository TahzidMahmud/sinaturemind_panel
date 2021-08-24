<?php 
class Payment extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->script="";
        Session::init();
    }

    function init(){
       
        if(isset($_POST['apikey'])){
            $data = $_POST;
            $session_token = uniqid();
            Session::set("session_token", $session_token);
            Session::set($session_token, json_encode($data));
            echo json_encode(array("result"=>"success","message"=>$session_token));            
        }else{
            echo json_encode(array("result"=>"error","message"=>"could not create session!"));
        }
        
    }

    function paygateway(){
        $token = $_GET['token'];
        if($token==Session::get("session_token")){
            $this->view->token=$token;
            $data = json_decode(Session::get($token));
            
            $this->view->callbackurl=$data->callbackurl;
            $this->view->render("notemplate","payment/paymentgateway");
        }else{
            echo json_encode(array("result"=>"error","message"=>"Session expired!"));
        }
    }     

}
?>