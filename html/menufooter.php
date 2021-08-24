                        
                    <footer class="footer text-center text-sm-left">
                    &copy; 2021 Nagbak <span class="d-none d-sm-inline-block float-right"> <i class="mdi mdi-heart text-danger"></i> All rights reserved by DOT BD SOLUTIONS</span>
                </footer><!--end footer-->
            </div>
            <!-- end page content -->
            
        </div>


        <style>
            .sms-modal{
                height:100vh;
                width:100vw;
                position:fixed;
                left:0px;
                top:0px;
                z-index: 100;
                display:none;
                background-color:rgba(0,0,0,0.2);
            }
            .scroll{
                position:fixed;
                top:10vh;
                left:30vw;
                overflow-y:scroll;
            }
        </style>
        <!-- end page-wrapper -->

        <script src="./theme/assets/js/jquery.min.js"></script>
        <script src="./theme/assets/js/bootstrap.bundle.min.js"></script>
        <script src="./theme/assets/js/waves.js"></script>
        <script src="./theme/assets/js/feather.min.js"></script>
        <script src="./theme/assets/js/simplebar.min.js"></script>
        <script src="./theme/assets/js/jquery.validate.min.js"></script>
        <script src="./theme/assets/js/metismenu.min.js"></script>
        
        <script src="./theme/assets/js/moment.js"></script>
        <script src="./theme/plugins/daterangepicker/daterangepicker.js"></script>

        <script src="./theme/plugins/apex-charts/apexcharts.min.js"></script>
        <!-- <script src="./theme/assets/pages/jquery.sales_dashboard.init.js"></script> -->
        <!-- Sweet-Alert  -->
        <script src="./theme/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="./theme/plugins/tinymce/tinymce.min.js"></script>
        <script src="./theme/plugins/ckeditor/ckeditor.js"></script>
        
        <!-- App js -->
        <script src="./theme/assets/js/app.js"></script>
        <?php if(count($this->pagescript)>0){ 
            foreach($this->pagescript as $script){
            ?>
            <script src="<?php echo $script?>"></script>
        <?php } 
        } ?>
        
        <script>
            function highlitenav(nvi){
                var len = $('#navbar li').length;
                var $listItems = $('#navbar li');
                $listItems.removeClass('active');
                // for(var i=1; i<len; i++){
                //         $('#navitem'+i).removeClass('active');
                //     }
                $('#'+nvi).addClass('active');
                
            } 
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: function(toast) {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })



              function manage_status(val){
                
                var stat=$(`#orderact${val}`).find(":selected").text();
               
                $.ajax({
                                        
                    url: "<?php echo URL;?>?page=orders&action=updatestat", 
                    type : "POST", 
                    data :  {
                        ximsl: val,
                        stat:stat
                    },
                    dataType:'json',
                    success : function(result) {
                        Toast.fire({
                            icon: 'success',
                            title: `${result.message}`
                                });
                              
                                $(`#imt${val}`).html(`${result.result}`);
                                $(`#imt${val}`).removeClass();
                                var statclr="";
                                            if(result.result == "Processing"){
                                                statclr="primary";
                                            }else if(result.result == "Delivered"){
                                                statclr="warning";
                                            }else if(result.result == "Canceled"){
                                                statclr="info";
                                            }else if(result.result == "Clear"){
                                                statclr="success";
                                            }else if(result.result == "Pending"){
                                                statclr="danger";
                                            }else{
                                                statclr="primary";
                                            }
                                $(`#imt${val}`).addClass(`text-${statclr}`)
                              
                                check_mast_stat(val);
                        },error: function(xhr, resp, text) {
                            Toast.fire({
                            icon: 'danger',
                            title: `${resp}`
                                });             
                         }
                        
                });
                
              }

              $('#close-btn').on('click',function(){
               
                document.getElementById("restbl").style.display="none";
                $('#restbl').removeClass("d-flex justify-content-center");
                location.reload();

              })
              function check_mast_stat(val){
                 
                $.ajax({
                                        
                                        url: "<?php echo URL;?>?page=orders&action=updatestatmst", 
                                        type : "POST", 
                                        data :  {ximsl: val},
                                        dataType:'json',
                                        success : function(result) {
                                            
                                            var statclr="";
                                            if(result.message == "Processing"){
                                                statclr="primary";
                                            }else if(result.message == "Delivered"){
                                                statclr="warning";
                                            }else if(result.message == "Canceled"){
                                                statclr="info";
                                            }else if(result.message == "Clear"){
                                                statclr="success";
                                            }else if(result.message == "Pending"){
                                                statclr="danger";
                                            }else{
                                                statclr="primary";
                                            }
                                                    $(`#mst${result.xossl}`).html(`${result.message}`);
                                                    $(`#mst${result.xossl}`).removeClass();
                                                    $(`#mst${result.xossl}`).addClass(`btn`)
                                                    $(`#mst${result.xossl}`).addClass(`btn-${statclr}`)
                    
                                            },error: function(xhr, resp, text) {
                                                                
                                             }
                                            
                                    });
              }
                
              $('#orderact').on('change',function(){
                  
              })

              function openorders_table(val){
                  document.getElementById("restbl").style.display="block";
                  $('#restbl').addClass("d-flex justify-content-center");
                

                  $.ajax({
                                        
                    url: "<?php echo URL;?>?page=orders&action=getorders", 
                    type : "POST", 
                    data :  {xossl: val},
                    dataType:'json',
                    success : function(result) {
                        console.log(result);
                        $('#orderstbl').html("");
                    for(let i=0;i<result.result.length;i++){
                        // <button id="${result.result[i].ximsl}" class="btn btn-primary" onClick="manage_status(${result.result[i].ximsl})">${result.result[i].xstatus}</button> 
                        var statclr="";
                        if(result.result[i].xstatus == "Processing"){
                            statclr="primary";
                        }else if(result.result[i].xstatus == "Delivered"){
                            statclr="warning";
                        }else if(result.result[i].xstatus == "Canceled"){
                            statclr="info";
                        }else if(result.result[i].xstatus == "Clear"){
                            statclr="success";
                        }else if(result.result[i].xstatus == "Pending"){
                            statclr="danger";
                        }else{
                            statclr="primary";
                        }
                        $('#orderstbl').append(`
                                <tr>
                                    <td>${result.result[i].xdate} </td>
                                    <td>${result.result[i].xparty} </td>
                                    <td>${result.result[i].item_name} </td>
                                    <td>${parseInt(result.result[i].xqty)} </td>  
                                    <td>${parseFloat(result.result[i].xprice)} </td>
                                    <td>${result.result[i].xprice * result.result[i].xqty} </td>
                                    <td class="text-${statclr}" id="imt${result.result[i].ximsl}">${result.result[i].xstatus} </td>
                                    <td style="width:10rem;">
                                        <select class="form-control text-center" onChange="manage_status(${result.result[i].ximsl})" id="orderact${result.result[i].ximsl}" name="orderact">
                                        <option class="text-center" value="Pending" selected >Pending</option>
                                            <option class="text-center" value="Processing"  >Processing</option>
                                            <option class="text-center" value="Delivered">Delivered</option>
                                            <option class="text-center" value="Canceled">Canceled</option>
                                            <option class="text-center" value="Clear">Clear</option>
                                        </select>
                                    </td>
                                    
                                </tr>
                            `);
                    }
                    
                    
                    },error: function(xhr, resp, text) {
                                                                
                        }
                                            
                    });




              }
              
              
              
              
              
               function opendelivered_orders_table(val){
                  document.getElementById("restbl").style.display="block";
                  $('#restbl').addClass("d-flex justify-content-center");
                

                  $.ajax({
                                        
                    url: "<?php echo URL;?>?page=orders&action=get_del_orders", 
                    type : "POST", 
                    data :  {xossl: val},
                    dataType:'json',
                    success : function(result) {
                        // console.log(result);
                        $('#del_orderstbl').html("");
                    for(let i=0;i<result.result.length;i++){
                        // <button id="${result.result[i].ximsl}" class="btn btn-primary" onClick="manage_status(${result.result[i].ximsl})">${result.result[i].xstatus}</button> 
                       
                        $('#del_orderstbl').append(`
                                <tr>
                                    <td>${result.result[i].xdate} </td>
                                    <td ><input type="hidden" id="customer" value="${result.result[i].zemail}">${result.result[i].xparty} </td>
                                    <td>${result.result[i].xitemid} </td>
                                    <td>${parseInt(result.result[i].xqty)} </td>
                                    <td>${result.result[i].xprice * result.result[i].xqty} </td>
                                    <td>${result.result[i].abl_comission} </td>
                                    <td><input type="checkbox" name="sport" id="pay${result.result[i].ximsl}" value="${result.result[i].ximsl} ${result.result[i].abl_comission}"> Pay</td>
                                   
                                    
                                </tr>
                            `);
                    }
                    
                    
                    },error: function(xhr, resp, text) {
                                                                
                        }
                                            
                    });




              }


             ///////////////////////////////
            /////for generating voucher////
            ///////////////////////////////
            
            function generate_voucher(sl){
            location.replace("<?php echo URL;?>?page=orders&action=voucher&sl="+sl);
                
            }
        </script>
        <?php echo $this->script;?>
        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"></span>
            </div>
        </div>
        
    </body>

</html>