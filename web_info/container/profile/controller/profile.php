<?php
class Profile extends Controller{
   

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
        $this->view->script = $this->script();
        $st=$this->model->getstore();
        // Logdebug::appendlog(print_r($st[0],true));
        $this->view->sdata=$st[0];
        
        $this->view->render("menutemplate","appsettings/profile_view",false);
        
    }
    function verify_pass(){
        $temp=Hash::create('sha256',$_POST["pass"],HASH_KEY);
        //   Logdebug::appendlog(print_r(array(["pass"=>$temp,"db"=>$_SESSION['pass']]),true));

        if($temp == $_SESSION['pass'] ){
            echo json_encode(array(["mesasge"=>"success"]));
        }else{
            echo json_encode(array(["mesasge"=>"error"]));
        }
    }
    function update_pass(){
        $ssl=Session::get('ssl');
        $newpass=Hash::create('sha256',$_POST["newpass"],HASH_KEY);
        $res=$this->model->any("UPDATE `storemst` SET xpassword='$newpass' WHERE  xsl='$ssl'");
        $_SESSION["adminlogin"]=1;
         echo json_encode(array(["mesasge"=>"Password Updated successfully..!!"]));
            // Logdebug::appendlog(print_r($res,true));
        
    }
      function update_shipping(){
        $ssl=Session::get('ssl');
         $shipping=filter_var($_POST['shipping'], FILTER_SANITIZE_STRING);
        $expshipping=filter_var($_POST['expshipping'], FILTER_SANITIZE_STRING);
         Logdebug::appendlog(print_r($expshipping,true));
        $res=$this->model->any("UPDATE `storemst` SET shipping='$shipping', expshipping='$expshipping'  WHERE  xsl='$ssl'");
         echo json_encode(array(["mesasge"=>" Updated successfully..!!","result"=>"success"]));
           
        
    }
    function get_password(){
         $ssl=Session::get('ssl');
         $res=$this->model->any("SELECT xpassword FROM `storemst` WHERE xsl='$ssl' ");
        $pass=$res[0]["xpassword"];
//  Logdebug::appendlog(print_r($_SESSION,true));
        $_SESSION['pass']=$pass;
        echo json_encode(array(["mesasge"=>"success","pass"=>$pass]));
    }
    function update(){
        
        $xemail=filter_var($_POST['xemail'], FILTER_SANITIZE_STRING);

        $xorgname=filter_var($_POST['xorgname'], FILTER_SANITIZE_STRING);
        $xdelarea=filter_var($_POST['xdelarea'], FILTER_SANITIZE_STRING);
        $ssl=Session::get('ssl');
        $qry="UPDATE storemst
        SET  xemail= '$xemail',  xorgname= '$xorgname', xdelarea='$xdelarea'
        WHERE  xsl='$ssl'";
        $this->model->update($qry);

        echo json_encode(array("message"=>"Update Successfull..!!"));


    }

    function upload_image(){
        $ssl=Session::get('ssl');
          $storeFolder = USER_IMAGE_LOCATION;   //2
        $path="";
        if( $_FILES['categoryimage']['name']){
            $path = $_FILES['categoryimage']['name'];
            // move_uploaded_file($_FILES['categoryimage']['name'],$storeFolder);
            
            $uploadfile = new ImageUpload();
                $result = $uploadfile->store_uploaded_image($storeFolder,'categoryimage',160, 160, "thumb");                
                $result = $uploadfile->store_uploaded_image($storeFolder,'categoryimage',500, 300);
        }
        
       
        // $ext = pathinfo($path, PATHINFO_EXTENSION);
       
   
        $result =$this->model->any("UPDATE `storemst` SET ximage='$path' WHERE  xsl='$ssl'");
       


        if($result>0){  
            echo json_encode(array("result"=>"success","message"=>"Image Uploaded successfully!"));
          
            exit;
        }else{
            echo json_encode(array("result"=>"error","message"=>"Uplolad Failed !"));
            exit;
        }
        
    }
    
    function update_rinodc(){
        $ssl=Session::get('ssl');
        $rin=filter_var($_POST['rin'], FILTER_SANITIZE_STRING);
        $odc=filter_var($_POST['odc'], FILTER_SANITIZE_STRING);
        $result =$this->model->any("UPDATE `storemst` SET rin_no='$rin' , odc_no='$odc' WHERE  xsl='$ssl'");
      

//   Logdebug::appendlog(print_r($result,true));
        
        if($result>0){  
        $_SESSION['rin']=$result["rin_no"];
        $_SESSION['odc']=$result["odc_no"];
            
            echo json_encode(array("result"=>"success","message"=>"Inserted successfully!"));
          
            exit;
      }else{
            echo json_encode(array("result"=>"error","message"=>" Failed !"));
            exit;
        }
        
    }

    function script(){
        return "
        <script>
          $('#shippingsmt').on('click',function(){
         
            var shipping=$('#shipping').val();
            var expshipping=$('#expshipping').val();
            
            $.ajax({
                url:\"".URL."?page=profile&action=update_shipping\", 
                type:'POST',
                data:{
                    shipping:shipping,
                    expshipping:expshipping
                },
                success: function (result) {
               
                        var res=JSON.parse(result);
                        Toast.fire({
                        icon: res[0].result,
                        title: 'Update Success ..!!'

                    })
                    delay(3000)
    
                        }, 
               
                });
            
        })
        $('#rinodc').on('click',function(){
            var rin=$('#rin').val();
            var odc=$('#odc').val();
            $.ajax({
                url:\"".URL."?page=profile&action=update_rinodc\", 
                type:'POST',
                data:{
                    rin:rin,
                    odc:odc
                },
                success: function (result) {
               
                        var res=JSON.parse(result);
                       
                        Toast.fire({
                        icon: res.result,
                        title: res.message

                    })
                    delay(3000)
    
                        }, 
               
                });
            
        })
        $('#categoryimage').change(
                function(){
                    var img=$(this).val();
                    let file = document.querySelector('input[type=file]').files[0];
                    const preview = document.querySelector(\"#selectedimage\");
                    const cross = document.querySelector(\"#crossbutton\");

                    let reader = new FileReader();

                    reader.addEventListener(\"load\", function () {
                    
                      document.getElementById('addcategory').style.display=\"block\";
                        preview.src = reader.result;
                        preview.style=\"height:200px;width:200px;border-radius:5px;\"
                        cross.style=\"height:30px;width:30px;padding:5px!important;margin-bottom:auto!important;background:darkred;border-radius:50%;color:white;cursor:pointer;\"
                      }, false);
                    
                      if (file) {
                        reader.readAsDataURL(file);
                      }
                }
            );
      $('#crossbutton').click(function(){
     document.getElementById('addcategory').style.display=\"none\";
                const cross = document.querySelector(\"#crossbutton\");
                cross.style=\"display:none;\"
                const preview = document.querySelector(\"#selectedimage\");
               preview.src=\"\";
               preview.style=\"display:none;\"
               const imginput = document.querySelector(\"#categoryimage\");
               imginput.value=\"\";
            });
          $(document).ready(function(){
         document.getElementById(\"curpass\").style.display=\"none\";
          $.ajax({
                url:\"".URL."?page=profile&action=get_password\", 
                type:'GET',
                success: function (result) {
               
                   
                }, 
               
            });	
              
          });
          
          
     $('#addcategory').on('click',function(e){
                e.preventDefault();
                var form = new FormData(document.getElementById('addcategoryform'));
               
                //append files
                var file = document.getElementById('categoryimage').files[0];
                if (file) {   
                    form.append('uploaded-image', file);
                }
                
               
                $.ajax({
                                    
                    url:\"".URL."?page=profile&action=upload_image\", 
                    type : \"POST\",  
                                                   				
                    data: form,
                    // data : JSON.stringify(getFormData($('#addcategoryform'))),
                    contentType: false, 
                    processData: false,
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                       
                        const resultobj = JSON.parse(result);

                    //   console.log(resultobj.result);
                        $(\"#overlay\").fadeOut(300);
                        if(resultobj.result=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: ''+resultobj.message
                            })
                            setTimeout(function(){
                                // location.reload();
                             }, 301);
                            
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title:resultobj.message
                            })
                        }
                        
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })
            });
          $('#new_pass_conf').focusout(function(){
              let tmp=$('#new_pass').val();
              let tmp2=$('#new_pass_conf').val();
              if(tmp!=tmp2){
                  document.getElementById(\"curpass2\").style.display=\"block\";
              }
          });
          $('#btn-pass').on('click',function(){
              let tmp=$('#new_pass').val();
               $.ajax({
                url:\"".URL."?page=profile&action=update_pass\", 
                type:'POST',
                data:{
                    newpass:tmp
                },
                success: function (result) {
                        var res=JSON.parse(result);
                        
                       
                        Toast.fire({
                        icon: 'success',
                        title: res[0].mesasge

                    })
                    delay(3000)
    
                        }, 
               
                });	
          });
          $('#current_pass').focusout(function(){
          var pass= $('#current_pass').val();
              $.ajax({
                url:\"".URL."?page=profile&action=verify_pass\", 
                type:'POST',
                data:{
                    pass:pass
                },
                success: function (result) {
                var res=JSON.parse(result);
               console.log(res[0].mesasge);
                if(res[0].mesasge=='error'){
                    document.getElementById(\"curpass\").style.display=\"block\";
                }else{
                    document.getElementById(\"curpass\").style.display=\"none\";
                }
                   
                }, 
               
            });	
          });
          
          $('#btn-smt').on('click',()=>{
            
            var xemail=$('#email').val();
            var xorgname=$('#name').val();
            var xdelarea=$('#delarea').val();

            $.ajax({
                url:\"".URL."?page=profile&action=update\", 
                type:'POST',
                data: {
                    xemail:xemail,
                    xorgname:xorgname,
                    xdelarea:xdelarea
                },					
                success: function (result) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Update Successfull..!!'

                    })
                }, 
                dataType:'json'
            });	
          })
        </script>
        ";
    }
}

?>