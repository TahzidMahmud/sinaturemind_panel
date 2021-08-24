<?php
class Forgotpass extends Controller{
    
    function __construct(){
        parent::__construct();
       
     
        Session::init();
        
       
    }
    public function getpass(){
         $phn = filter_var($_POST['phn'], FILTER_SANITIZE_STRING);
        
         $res=$this->model->any("SELECT * FROM  `storemst` WHERE xstore='$phn'");
            //   Logdebug::appendlog(print_r($res[0]["xpassword"],true));
            	
            if($res[0]["xpassword"]!=""){
                	$vowels = 'aeuy';
            		$consonants = 'bdghjmnpqrstvz';
            		if ($strength >= 1) {
            			$consonants .= 'BDGHJLMNPQRSTVWXZ';
            		}
            		if ($strength >= 2) {
            			$vowels .= "AEUY";
            		}
            		if ($strength >= 4) {
            			$consonants .= '23456789';
            		}
            		if ($strength >= 8) {
            			$consonants .= '@#$%';
            		}
            
            		$password = '*0123456*$';
            		$alt = time() % 2;
            		for ($i = 0; $i < $length; $i++) {
            			if ($alt == 1) {
            				$password .= $consonants[(rand() % strlen($consonants))];
            				$alt = 0;
            			} else {
            				$password .= $vowels[(rand() % strlen($vowels))];
            				$alt = 1;
            			}
            			
            		}
            		 
            		$passd=Hash::create('sha256',$password,HASH_KEY);
                    $this->model->any("UPDATE  `storemst` SET xpassword='$passd' WHERE xstore='$phn'");
                    $sms=new Sendsms();
                        // Logdebug::appendlog(print_r($password,true));
                    $text="From Nagbak [ Your New Password is: (".$password." ) Update It From Profile Option] ";
                    $sms->send_single_sms($text,$phn);
                     echo json_encode(array("result"=>"success","message"=>"Password Updated"));
                
            }else{
                 echo json_encode(array("result"=>"error","message"=>"No Store Found With This Number"));
            exit;
            }
    }
    public function init(){
      
        $this->view->script = $this->script();
         $this->view->render("logintemplate","pass/init_view",false);
    }
    
    
    
    function script(){
        return "
        <script>
          $('#getbtn').on('click', function(){

              var phn=$('#phntxt').val();
              if(phn.length>10){
                     $.ajax({
                                    
                    url:\"".URL."?page=forgotpass&action=getpass\", 
                    type : \"POST\",             				
                    data: {phn: phn},
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                       var res=JSON.parse(result)
                       if(res.result=='error'){
                         $('#res2').text('');
                            $('#res').text('No Store Found With This Number..!!');
                       }else{
                        $('#res').text('');
                            $('#res2').text('Your Password Updated Check SMS in This Number..!!');
                       }
                      
                        
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })	
                  
              }else{
                  $('#res').text('Put A Valid Mobile Number..!!');
              }
          })
       
        </script>
        ";
    }
    
    
}

?>