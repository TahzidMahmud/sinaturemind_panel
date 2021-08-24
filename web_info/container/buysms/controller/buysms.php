<?php
class Buysms extends Controller{

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
        $this->view->render("menutemplate","appsettings/buysms_view",false);
        Logdebug::appendlog(print_r(URL, true));
        
    }
   
    function script(){
        return "
        <script>
        var amount=$('#amount').val();
        var count=$('#smscount').val();
          $('#inc').on('click',()=>{
                 count ++;
                 var total=(count*0.20).toFixed(2);
                 $('#smscount').val(count);
                 $('#amount').val(total);

            })
            $('#dec').on('click',()=>{
                if( $('#smscount').val()>=0){
                    count --;
                    var total=(count*0.20).toFixed(2);
                    $('#smscount').val(count);
                    $('#amount').val(total);
                }else{
                    $('#smscount').val(0);
                    $('#amount').val(0);
                }
               

           })

           $('#smscount').on('change',()=>{
                count=$('#smscount').val();
                var total=(count*0.20).toFixed(2);
                $('#amount').val(total);

           })

          $('#btn-smt').on('click',()=>{
            var smscount=$('#smscount').val();
            var amount=$('#amount').val();
            var apikey=\"".API_KEY."\";
            var callback=\"".URL."?page=buysms&action=init\"
          Toast.fire({
                    icon: 'error',
                    title: 'This Feature Is Under Development..!!'

                })

            // $.ajax({
            //     url:\"".PAYGATE_URL."&action=init\", 
            //     type:'POST',
            //     data: {
            //         smscount:smscount,
            //         amount:amount,
            //         apikey:apikey,
            //         callbackurl:callback,
            //         type:'smsbuy'
            //     },					
            //     success: function (result) {
            //     //    console.log(result.result)
                
            //     var token=result.message
            //         if(result.message='success'){
            //             location.replace(\"".PAYGATE_URL."&action=paygateway&token=\"+token)
            //         }else{
            //             Toast.fire({
            //                 icon: 'error',
            //                 title: +result.result
            //             });
            //         }
            //     }, 
            //     dataType:'json'
            // });	
          })
        </script>
        ";
    }
}

?>