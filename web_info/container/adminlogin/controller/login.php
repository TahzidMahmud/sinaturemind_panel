<?php
class Login extends Controller{
   
    function __construct(){
        parent::__construct();
        
    }
   
    function logininit(){
        
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $rawpass = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        //Logdebug::appendlog($username);
        $hashpass = Hash::create('sha256',$rawpass,HASH_KEY);
        //Logdebug::appendlog($username.$hashpass);
        $loginrec = $this->model->getlogindt($username, $hashpass);
        //Logdebug::appendlog(print_r($loginrec,true));
        //  Logdebug::appendlog(print_r($loginrec[0],true));
        if(count($loginrec)>0){
            Session::init();
            Session::set('adminlogin', true);
            Session::set('ssl', $loginrec[0]['xsl']);
            Session::set('suser', $loginrec[0]['xstore']);
            Session::set('image', $loginrec[0]['ximage']);
            Session::set('sfullname', $loginrec[0]['xfullname']);
            Session::set('saddress', $loginrec[0]['xaddress']);
            Session::set('splan', $loginrec[0]['xaccplan']);
            Session::set('rin', $loginrec[0]['rin_no']);
            Session::set('odc', $loginrec[0]['odc_no']);

            echo json_encode(array("result"=>"success", "message"=>""));
            

        }else{
            echo json_encode(array("result"=>"error", "message"=>"User and password did not match!"));
        }

    }
    
    function logout(){
        Session::destroy();
        header('location: ' . URL);
        exit;
    }
    
}

?>