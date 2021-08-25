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
        $loginrec = $this->model->getlogindt($username, $hashpass)[0];
        // Logdebug::appendlog(print_r($loginrec,true));
        //  Logdebug::appendlog(print_r($loginrec[0],true));
        if(count($loginrec)>0){
            Session::init();
            Session::set('adminlogin', true);
            Session::set('sl', $loginrec['sl']);
            Session::set('uname', $loginrec['uname']);
            Session::set('mobile', $loginrec['mobile']);
            Session::set('xemail', $loginrec['xemail']);
            Session::set('role', $loginrec['role']);
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