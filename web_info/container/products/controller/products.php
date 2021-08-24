<?php
class Products extends Controller{

    function __construct(){
        parent::__construct();
        Session::init();
        if(!Session::get('adminlogin')){
            header('location: '. URL);
            exit;
        }
       
        $this->view->pagescript = array("./theme/plugins/dropzone/dropzone.min.js","./theme/assets/js/jquery.autocomplete.js","./theme/plugins/datatables/jquery.dataTables.min.js");
        $this->view->pagecss = array("./theme/plugins/dropzone/dropzone.min.css","./theme/assets/css/app-custom.css","./theme/plugins/datatables/datatables.min.css");
    }

    function init(){
         $storeid = Session::get('ssl');
        $this->view->script = $this->script();
        $categories= $this->model->any("SELECT * FROM onlinecat WHERE xstoreid='15'");
        $subcategories=$this->model->fetchsubcats("onlinesubcat","*");
        $brands= $this->model->fetchbrands("onlinebrand","*");
        // Logdebug::appendlog(print_r($categories,true));
        $this->view->allcategories=$categories;
        $this->view->allsubcategories=$subcategories;
        $this->view->allbrands=$brands;

        $this->view->render("menutemplate","appsettings/products_view",false);
        
    }
    function deleteitem(){
        $itmid=filter_var($_POST['itmid'], FILTER_SANITIZE_STRING);
          $storeid = Session::get('ssl');
        $this->model->any("DELETE FROM seitem
            WHERE xitemid = '$itmid' and xstoreid='$storeid'");
             echo json_encode(array("result"=>"success","message"=>" Delted successfully!"));
            
        
    }
   
    function addcategory(){
        $storeFolder = PRODUCT_IMAGE_LOCATION.Session::get('ssl')."/";   //2

        $path="";
        if( $_FILES['categoryimage']['name']){
            $path = $_FILES['categoryimage']['name'];
            $uploadfile = new ImageUpload();
                $result = $uploadfile->store_uploaded_image($storeFolder,'categoryimage',160, 80, "thumb");                
                $result = $uploadfile->store_uploaded_image($storeFolder,'categoryimage',500, 300);
        }
       
        // $ext = pathinfo($path, PATHINFO_EXTENSION);
        $date = date('Y-m-d');
       
    	
        $xcat = filter_var($_POST['category'], FILTER_SANITIZE_STRING);

        $storeid = Session::get('ssl');
        $zemail = Session::get('suser');
      
        //Logdebug::appendlog(print_r($data, true));

        // Logdebug::appendlog( print_r(,true));
        $sdata = array(
            "bizid"=>100,
            "xstoreid"=>$storeid,
            "xcat"=>$xcat,
            "ximage"=>$path,
        );
        
        $result = $this->model->create('onlinecat', $sdata);
       


        if($result>0){  
            echo json_encode(array("result"=>"success","message"=>"Category Create successfully!"));
          
            exit;
        }else{
            echo json_encode(array("result"=>"error","message"=>"Failed to create Category!"));
            exit;
        }
        
    }
    function addbrand(){
        $date = date('Y-m-d');
        $data = json_decode(file_get_contents('php://input'));
        // $imtype = filter_var($data->imtype, FILTER_SANITIZE_STRING);
    
        $xcatsl = filter_var($data->cat, FILTER_SANITIZE_STRING);
        $xbrand = filter_var($data->brand, FILTER_SANITIZE_STRING);

        $storeid = Session::get('ssl');
        $zemail = Session::get('suser');
      
        //Logdebug::appendlog(print_r($data, true));
        //Logdebug::appendlog($doctype);
        $sdata = array(
            "bizid"=>100,
            "xstoreid"=>$storeid,
            "xcatsl"=>$xcatsl,
            "xbrand"=>$xbrand,
        );
        
        $result = $this->model->create('onlinebrand', $sdata);

        if($result>0){  
            echo json_encode(array("result"=>"success","message"=>"Brand Create successfully!"));
          
            exit;
        }else{
            echo json_encode(array("result"=>"error","message"=>"Failed to create Brand!"));
            exit;
        }
        
    }


    function addsubcategory(){
        $date = date('Y-m-d');
        $data = json_decode(file_get_contents('php://input'));
        // $imtype = filter_var($data->imtype, FILTER_SANITIZE_STRING);
    
        $xcatsl = filter_var($data->cat, FILTER_SANITIZE_STRING);
        $xsubcat = filter_var($data->subcategory, FILTER_SANITIZE_STRING);

        $storeid = Session::get('ssl');
        $zemail = Session::get('suser');
      
        //Logdebug::appendlog(print_r($data, true));
        //Logdebug::appendlog($doctype);
        $sdata = array(
            "bizid"=>100,
            "xstoreid"=>$storeid,
            "xcatsl"=>$xcatsl,
            "xsubcat"=>$xsubcat,
        );
        
        $result = $this->model->create('onlinesubcat', $sdata);

        if($result>0){  
            echo json_encode(array("result"=>"success","message"=>"Sub-Category Create successfully!"));
          
            exit;
        }else{
            echo json_encode(array("result"=>"error","message"=>"Failed to create Sub-Category!"));
            exit;
        }
    }
    
    
    function searchitems(){
       
        $xcat = "";
        $xsubcat = "";
        $xdesc="";
       
       if(isset($_POST["cat"])){
           $xcat = filter_var($_POST['cat'], FILTER_SANITIZE_STRING);
       }
       if(isset($_POST["subcat"])){
           $xsubcat = filter_var($_POST['subcat'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["query"])){
           $xdesc= filter_var($_POST['query'], FILTER_SANITIZE_STRING);
       }
    
    
       
       $result=$this->model->filtersearch($xcat,$xsubcat,$xdesc);
        //Logdebug::appendlog(print_r($result, true));

        if(count($result)>0){  
            echo json_encode(array("message"=>"success","result"=>$result));
          
        }else{
            echo json_encode(array("message"=>"error","result"=>"Failed to search"));
           
        }
    }
    
    function itemnaction(){
        $itemno=$_POST['item'];
        if(!is_numeric($itemno)){
            echo json_encode(array("result"=>"error", "message"=>'Not a valid item to activate!'));    
            exit;
        }
        $srcstr = $itemno;
        
        $row_data = $this->model->finditembyid($srcstr);
      
        if($row_data[0]['isactive']==0){
                $actval=1;
        }else{
            $actval=0;
        }

        $data = array(
            'zactive'=>$actval
        );

            $where = " xstoreid=".Session::get('ssl')." and xitemid = ".$itemno;
             
            $result = $this->model->update("seitem",$data,$where);
            if($result){
                echo json_encode(array("result"=>"success", "message"=>'Item activated!', "activestat"=>$actval));
                
            }else{
                echo json_encode(array("result"=>"error", "message"=>'Item activation failed!'));
            }

        
    }
function updateitm(){
  
        $price = 0;
        $mrp = 0;
        $percentage=0;
        $itmid=null;
        $longdsc="";
       
       if(isset($_POST["price"])){
           $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["longdsc"])){
           $longdsc = filter_var($_POST['longdsc'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["mrp"])){
           $mrp = filter_var($_POST['mrp'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["percentage"])){
           $percentage = filter_var($_POST['percentage'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["itmid"])){
           $itmid = filter_var($_POST['itmid'], FILTER_SANITIZE_STRING);
       }
        if(isset($_POST["stock"])){
           $stock = filter_var($_POST['stock'], FILTER_SANITIZE_STRING);
       }
        $data = array(
            'xstdprice'=>$price,
            'xmrp'=>$mrp,
            'ablpercent'=>$percentage,
            'xlongdesc'=>$longdsc,
            'xstock'=>$stock
        );
      
                //   Logdebug::appendlog(print_r($data, true));

            $where = " xstoreid=".Session::get('ssl')." and xitemid = ".$itmid;
       
            $result = $this->model->update("seitem",$data,$where);
            
                //   Logdebug::appendlog(print_r($result, true));
       if($result){
                echo json_encode(array("result"=>"success", "message"=>'Item Updated!'));
                
            }else{
                echo json_encode(array("result"=>"error", "message"=>'Item Update failed!'));
            }
      
    

    
}

    function itembyid(){
        $srcstr = $_GET['itemid'];
        
        $data = $this->model->finditembyid($srcstr);
        
        echo json_encode($data);	
    }

    function itemautolist(){
        $srcstr = $_POST['query'];
        $data = $this->model->finditems($srcstr);
        
        echo json_encode(array("suggestions"=>$data));	
    }
    function lastitemssrc(){
        $itemcount = $_GET['itemcount'];
         if(isset($_GET["qry"])){
           $qry = filter_var($_GET['qry'], FILTER_SANITIZE_STRING);
       }
        //Logdebug::appendlog($itemcount);
        $data = $this->model->findlastitemssrc($itemcount,$qry);
        // Logdebug::appendlog(print_r(json_encode($data),true));
        echo json_encode($data);
    }

    function lastitems(){
        $stat="";
        $itemcount = $_GET['itemcount'];
         if(isset($_GET["stat"])){
           $stat = filter_var($_GET['stat'], FILTER_SANITIZE_STRING);
       }
        //Logdebug::appendlog($itemcount);
        $data = $this->model->findlastitems($itemcount,$stat);
        // Logdebug::appendlog(print_r(json_encode($data),true));
        echo json_encode($data);	
    }
    public function fetchsubcats(){
        $valueSelected = $_GET['xcatsl'];
       
        $data=$this->model->fetchsubcats($valueSelected);

        // Logdebug::appendlog(print_r(json_encode($data),true));
        
        echo json_encode($data);	

    }
    public function fetchbrand(){
        $valueSelected = $_GET['xcatsl'];
       
        $data=$this->model->fetchbrand($valueSelected);

        // Logdebug::appendlog(print_r(json_encode($data),true));
        

        echo json_encode($data);
    }
    public function addnewitem(){
       

        $price = $_POST['price'];
        $stock=$_POST['stock'];
        $percentage=$_POST['percentage'];
        $itmid=$_POST['itmid'];

        $item=$this->model->fetchitem($itmid);
      


        $sdata = array(
            // 'xitemid' =>  $item[0]['xitemid'],
            'bizid' =>  $item[0]['bizid'],
            'xstoreid' => Session::get('ssl'),
            'xitemcode' =>  $item[0]['xitemcode'], 
            'xdesc' =>  $item[0]['xdesc'],
            'xlongdesc' =>  $item[0]['xlongdesc'],
            'xcat' =>   $item[0]['xcat'],
            'xsubcat' =>  $item[0]['xsubcat'],
            'xbrand' =>  $item[0]['xbrand'],
            'xgitem' =>   $item[0]['xgitem'],
            'xcitem' =>   $item[0]['xcitem'], 
            'xsup' =>  $item[0]['xsup'], 
            'xunitpur' =>  $item[0]['xunitpur'], 
            'xunitsale' =>   $item[0]['xunitsale'], 
            'xunitstk' =>  $item[0]['xunitstk'], 
            'xconversionstk' =>    $item[0]['xconversionstk'], 
            'xconversionsell' =>   $item[0]['xconversionsell'], 
            'xmandatorybatch' =>    $item[0]['xmandatorybatch'], 
            'xserialconf' =>  $item[0]['xserialconf'], 
            'xtypestk' =>  $item[0]['xtypestk'],
            'xreorder' =>  $item[0]['xreorder'], 
            'xpricepur' =>    $item[0]['xpricepur'], 
            'xmrp' =>   $item[0]['xstdprice'], 
            'xstdprice' =>  $price, 
            'xstock' =>$stock , 
            'xdisc' =>   $item[0]['xdisc'], 
            'xpricebasis' =>   $item[0]['xpricebasis'], 
            'xhscode' =>   $item[0]['xhscode'], 
            'xweight' =>   $item[0]['xweight'], 
            'xvatpct' =>   $item[0]['xvatpct'], 
            'zactive' =>  $item[0]['zactive'], 
            'xprops' =>   $item[0]['xprops'], 
            'xfeature' =>   $item[0]['xfeature'], 
            'xrelated' =>   $item[0]['xrelated'], 
            'ximages' =>  $item[0]['ximages'], 
            'xstatus' =>  $item[0]['xstatus'], 
            'ablpercent'=> $percentage
        );
        
        $result = $this->model->create('seitem', $sdata);
        //  Logdebug::appendlog(print_r($result, true));
         
            echo json_encode(array("message"=>"success","result"=>$result));
          
      

    }

    function script(){
        return "
        <script>
        ///////////////////////////////////x
        //Auto Complete Item Search Section
        ///////////////////////////////////
        var table = $('#example').DataTable({
            \"pageLength\": 25,
            // src=\"./public/images/uploads/products/15/'+JsonResultRow.ximages+'
            \"columnDefs\": [
                
                { \"title\": \"Image\",\"width\": \"25%\" ,\"targets\":\"0\" },
                { \"title\": \"Name\", \"width\": \"50%\" ,\"targets\":\"1\"},   
                { \"title\": \"Action\", \"width\": \"10%\" ,\"targets\":\"2\"},          
            ],
            \"columns\": [
                { \"width\": \"25%\", \"render\": function (data, type, JsonResultRow, meta) {
                    return '<img style=\"height:5rem;width:5rem;\" src=\"./public/images/uploads/products/15/'+JsonResultRow.ximages+'\">';
                } },
                { \"data\": \"desc\" },
                {  \"width\": \"10%\" , \"render\": function (data, type, JsonResultRow, meta) {
                    return '<button class=\"btn btn-success\" onClick=\"openmodal('+JsonResultRow.xitemid+','+JsonResultRow.xstdprice+')\">Add</button>';
                } }
            ]
        });
        $( document ).ready(function() {
            var resultobj={};
        });
        ///////////////////////
        ////src input empty case//
        /////////////////////////
       
        $('#srctxt').on(\"input\",function(){
        var res =  $(this).val(); 
        if(res.length >=3){
             $.ajax({
                                
               url:\"".URL."?page=additems&action=lastitemssrc&itemcount=10000&qry=\"+res,
                type : 'GET',  
                
                
                 success : function(result) {
               
                      
                        // console.log(result.length)
                        result=JSON.parse(result);
                         let total=result.length;
                        $('#total').html('');
                        $('#total').append(total);
                         $('#lastitems').html('');
                        result.forEach(function(resp){
                            // console.log(result);
                            let images = resp.images.split(',');
                            let propstr = ''
                            let keys = []
                            if(JSON.parse(resp.props)){

                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                if(Object.entries(attrs)){
                                    for(const [key, value] of Object.entries(attrs)){
                                        let valstr = Object.keys(value)[0];
                                        if(val == valstr){
                                            propstr += value[valstr].attr+',';
                                        }
                                        
                                    }
                                }
                               
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                            }
                            
                            $('#lastitems').append(`
                            <tr>                                                    <td><a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'<p class=\"text-success\">Active</p>': '<p class=\"text-danger\">In-active</p>')+`</a></td> 
                                <td>
                                    <div class=\"media\">       
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                               
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+resp.longdesc+`','`+resp.stock+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                    $(\"#overlay\").fadeOut(300);
                }
            })
        }else{
         table.clear().draw();
             showlastitems()
        }
       
           
        })
        
        
        
        
        
        ////////////////////////////////
        //////search by name in shop////
        //////////////////////////////
        $('#btnsrc').on('click',function(){
         var query=document.getElementById(\"srctxt\").value;
       
             $.ajax({
                                
               url:\"".URL."?page=additems&action=lastitemssrc&itemcount=10000&qry=\"+query,
                type : 'GET',  
                
                beforeSend:function(){	
                    $(\"#overlay\").fadeIn(300);
                    
                },
                 success : function(result) {
                //   $('#lastitems').html('')
                    // console.log(result)
                        $(\"#overlay\").fadeOut(300);
                       
                       
                        // console.log(result.length)
                        result=JSON.parse(result);
                         let total=result.length;
                        $('#total').html('');
                        $('#total').append(total);
                         $('#lastitems').html('');
                        result.forEach(function(resp){
                            // console.log(result);
                            let images = resp.images.split(',');
                            let propstr = ''
                            let keys = []
                            if(JSON.parse(resp.props)){

                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                if(Object.entries(attrs)){
                                    for(const [key, value] of Object.entries(attrs)){
                                        let valstr = Object.keys(value)[0];
                                        if(val == valstr){
                                            propstr += value[valstr].attr+',';
                                        }
                                        
                                    }
                                }
                               
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                            }
                            
                            $('#lastitems').append(`
                            <tr>                                                 <td><a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'<p class=\"text-success\">Active</p>': '<p class=\"text-danger\">In-active</p>')+`</a></td>     
                                <td>
                                    <div class=\"media\">       
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                                
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+resp.longdesc+`','`+resp.stock+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                    $(\"#overlay\").fadeOut(300);
                }
            })
        })
        
        
        ////////////////////////////
        ///active inactive search///
        //active///
         $('#activesrc').on('click', function(){
          
           $.ajax({
                                
               url:\"".URL."?page=additems&action=lastitems&itemcount=10000&stat=active\",
                type : 'GET',  
                
                beforeSend:function(){	
                    $(\"#overlay\").fadeIn(300);
                    
                },
                 success : function(result) {
                //   $('#lastitems').html('')
                    console.log(result)
                        $(\"#overlay\").fadeOut(300);
                       
                       
                        // console.log(result.length)
                        result=JSON.parse(result);
                         let total=result.length;
                        $('#total').html('');
                        $('#total').append(total);
                         $('#lastitems').html('');
                        result.forEach(function(resp){
                            // console.log(result);
                            let images = resp.images.split(',');
                            let propstr = ''
                            let keys = []
                            if(JSON.parse(resp.props)){

                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                if(Object.entries(attrs)){
                                    for(const [key, value] of Object.entries(attrs)){
                                        let valstr = Object.keys(value)[0];
                                        if(val == valstr){
                                            propstr += value[valstr].attr+',';
                                        }
                                        
                                    }
                                }
                               
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                            }
                            
                            $('#lastitems').append(`
                            <tr>                                                    <td><a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'<p class=\"text-success\">Active</p>': '<p class=\"text-danger\">In-active</p>')+`</a></td>       
                                <td>
                                    <div class=\"media\">       
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                               
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+resp.longdesc+`','`+resp.stock+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                    $(\"#overlay\").fadeOut(300);
                }
            })
             
         })
         ///inactive///
          $('#inactivesrc').on('click', function(){
          
           $.ajax({
                                
               url:\"".URL."?page=additems&action=lastitems&itemcount=10000&stat=inactive\",
                type : 'GET',  
                
                beforeSend:function(){	
                    $(\"#overlay\").fadeIn(300);
                    
                },
                 success : function(result) {
                 console.log(result)
                //   $('#lastitems').html('')
                    // console.log(result)
                        $(\"#overlay\").fadeOut(300);
                       
                       
                        // console.log(result.length)
                         result=JSON.parse(result);
                          let total=result.length;
                        $('#total').html('');
                        $('#total').append(total);
                          $('#lastitems').html('');
                        result.forEach(function(resp){
                            // console.log(result);
                            let images = resp.images.split(',');
                            let propstr = ''
                            let keys = []
                            if(JSON.parse(resp.props)){

                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                if(Object.entries(attrs)){
                                    for(const [key, value] of Object.entries(attrs)){
                                        let valstr = Object.keys(value)[0];
                                        if(val == valstr){
                                            propstr += value[valstr].attr+',';
                                        }
                                        
                                    }
                                }
                               
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                            }
                            
                            $('#lastitems').append(`
                            <tr>                                                     <td><a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'<p class=\"text-success\">Active</p>': '<p class=\"text-danger\">In-active</p>')+`</a></td>     
                                <td>
                                    <div class=\"media\">       
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                                
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+resp.longdesc+`','`+resp.stock+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                    $(\"#overlay\").fadeOut(300);
                }
            })
             
         })
        
       
function drawtable(){
    var res=resultobj;
    var temp ={};
    $.each(res, function(key,val){
        // console.log( temp[key]['ximages'])
        temp[\"ximages\"]=val.ximages
        temp[\"desc\"]=val.xdesc
        temp[\"xitemid\"]=val.xitemid
        temp[\"xstdprice\"]=val.xstdprice
        table.row.add(temp).draw();

    })  
}



$('#itemsearch').autocomplete({
            delay: 2000,
            minChars: 3,
            lookup: function (query, done) {
                $.ajax({
                    url:\"".URL."?page=itemdatabase&action=itemautolist\", 
                    
                    type:'POST',
                    data: {
                        query : $('#itemsearch').val()
                    },					
                    success: function (data) {
                        done(data);
                    }, 
                    dataType:'json'
                });			
                
            },
            onSelect: function (suggestion) { 
                    // console.log(suggestion)
                    showitem(suggestion.data);
                    //console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
                },
                showNoSuggestionNotice: true,
                noSuggestionNotice: 'Sorry, no matching results'
            });

            function showitem(item){
                $('.attr_result').html('')
                props = []
                features = []
                relatedarr = []
                imagearr = []
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=itembyid&itemid=\"+item,  
                    type : \"GET\",  
                    dataType: 'json',
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        $(\"#overlay\").fadeOut(300);
                        let data = result[0];
                        $('#itemno').val(data.itemid)
                        $('#itemdesc').val(data.itemdesc)
                        $('#skucode').val(data.itemcode)
                        $('#cat').val(data.cat).change()
                        $('#subcat').val(data.subcat).change()
                        $('#brand').val(data.brand)
                        $('#salesprice').val(data.salesprice)
                        $('#itemunit').val(data.itemunit)
                        
                        props = JSON.parse(data.props)
                        features = JSON.parse(data.fetures)
                        if(data.relateditem!=''){
                            relatedarr = data.relateditem.split(',');
                        }
                        if(data.images!=''){
                            imagearr = data.images.split(',');
                        }
                        showImages()
                        showFeatures()
                        showRelatedProducts()
                        for(const [key, value] of Object.entries(props)){
                            showAttr(Object.keys(value)[0])
                        }
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(resp)
                    }
                })
            }


            function openmodal(val,price){
                $('#addmodal').modal('show');
                 $('#saleprice').val('');
                $('#ablpercent').val('');
                $('#mrp').text(price);
                document.getElementById(\"itmid\").value=val;
                
            }
             function openmodal2(val,mrp,price,percent,long,stock){
            //  console.log(val)
            //  console.log(mrp)
            //  console.log(price)
            //   console.log(percent)
                $('#addmodal2').modal('show');
                $('#saleprice2').val(price);
                $('#ablpercent2').val(percent);
                $('#mrp2').val(mrp);
                $('#stockedt').val(stock);
                $('#longdesc2').val(long)
                document.getElementById(\"itmid\").value=val;
                
            }


              $('#edititm').submit(function(event) {
                event.preventDefault();
                let price =$('#saleprice2').val();
                let mrp =$('#mrp2').val();
                let percentage=$('#ablpercent2').val();
                let itmid=$('#itmid').val();
                let longdsc= $('#longdesc2').val();
                let stock=$('#stockedt').val();
                // console.log(percentage)

                $.ajax({
                                    
                    url:\"".URL."?page=products&action=updateitm\", 
                    type : 'POST',  
                    dataType:'json',                     				
                    data: {
                        price : price,
                        percentage : percentage,
                        mrp:mrp,
                        itmid : itmid,
                        longdsc:longdsc,
                        stock:stock
                        
                    },
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        // console.log(result)
                       if(result.result=='success'){

                        Toast.fire({
                            icon: 'success',
                            title: result.message
                        })

                       }else{
                            Toast.fire({
                            icon: 'error',
                            title: result.message
                        })
                       }
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })
               
              
               
              
                $('#addmodal2').modal('hide');
                  location.reload();

                
            });




            ///////////////////////
            ///add product form submition
            ///////////////////////
            $('#addsubcategoryform').submit(function(event) {
                event.preventDefault();
                let price =$('#saleprice').val();
                let percentage=$('#ablpercent').val();
                let stock=$('#stck').val();
                let itmid=$('#itmid').val();
                // console.log(percentage)

                $.ajax({
                                    
                    url:\"".URL."?page=additems&action=addnewitem\", 
                    type : 'POST',  
                    dataType:'json',                     				
                    data: {
                        price : price,
                        percentage : percentage,
                        itmid : itmid,
                        stock:stock
                    },
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        // console.log(result)
                       if(result.message=='success'){

                        Toast.fire({
                            icon: 'success',
                            title: 'Item Added successfully!'
                        })
                         let stock=$('#stck').val();

                       }
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })
               
                resultobj.splice( resultobj.find(function(post, index) {
                    if(post.xitemid == itmid){
                        return true;
                    }
                    }),1);
                table.clear().draw();
                drawtable()
                showlastitems()
                // location.reload();
                // $('#fsearchresult').html('');
                // console.log(resultobj)
                $('#addmodal').modal('hide');

                
            });

            ///////////////////////////////////
            //Sub category fetch search
            ///////////////////////////////////
            $('#fcat').on('change', function (e) {
                var optionSelected = $('option:selected', this);
                var valueSelected = this.value;
              
               
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=fetchsubcats&xcatsl=\"+valueSelected,  
                    type : \"GET\",  
                    dataType: 'json',
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        $(\"#overlay\").fadeOut(300);
                         $(\"#fsubcat\").html('');
                       result.forEach(
                         function(val){
                            //  console.log($(\"#subcat\"));
                             
                            $(\"#fsubcat\").append(
                               '<option value=\"'+val.xsubcatsl+'\">'+val.xsubcat+'</option>'
                            );
                         }
                        );
                        

                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(text)
                    }
                })
            
               
            })

            /////////////////////////
            //Show Items in table
            ////////////////////////

            showlastitems()
            function showlastitems(){
                $('#lastitems').html('')
                $.ajax({
                                    
                    url:\"".URL."?page=additems&action=lastitems&itemcount=10000\",  
                    type : \"GET\",  
                    dataType: 'json',
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                    // console.log(result)
                        $(\"#overlay\").fadeOut(300);
                        let total=result.length;
                        $('#total').html('');
                        $('#total').append(total);
                       
                        // console.log(result.length)
                        result.forEach(function(resp){
                            // console.log(result);
                            let images = resp.images.split(',');
                            let propstr = ''
                            let keys = []
                            if(JSON.parse(resp.props)){

                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                if(Object.entries(attrs)){
                                    for(const [key, value] of Object.entries(attrs)){
                                        let valstr = Object.keys(value)[0];
                                        if(val == valstr){
                                            propstr += value[valstr].attr+',';
                                        }
                                        
                                    }
                                }
                               
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                            }
                             table.clear().draw();
                            $('#lastitems').append(`
                            <tr>                                                  <td><a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'<p class=\"text-success\">Active</p>': '<p class=\"text-danger\">In-active</p>')+`</a></td>  
                            
                                <td>
                                    <div class=\"media\">       
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                                
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+resp.longdesc+`','`+resp.stock+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(text)
                    }
                })
            }
            function showmodal(item, idsc){
                $('#item').html(item);
                $('#itemsl').val(item);
                $('#description').html(idsc);
                $('#cost').val('0');
                $('#qty').val('0');
				$('#stockmodal').modal('toggle');
				$('#stockmodal').modal('show');
			}
           
			///////////////////////////////////
            // Related Items Add
            ///////////////////////////////////

			 var relatedarr = [];
			  $('#relateditems').autocomplete({
                delay: 500,
                minChars: 3,
				lookup: function (query, done) {
					$.ajax({
						url:\"".URL."?page=itemdatabase&action=itemautolist\", 
						type:'POST',
						data: {
							query : $('#relateditems').val()
						},					
						success: function (data) {
							done(data);
						}, 
						dataType:'json'
					});			
					
				},
				onSelect: function (suggestion) { 
                    if(relatedarr.indexOf(suggestion.data) === -1){
                        relatedarr.push(suggestion.data);
                    }
                    showRelatedProducts();
					},
					showNoSuggestionNotice: true,
					noSuggestionNotice: 'Sorry, no matching results'
				});

                function showRelatedProducts(){
                    $('#relateditem_result').html('');
                    if(relatedarr.length>0){
                        relatedarr.forEach(function(resp){
                            $('#relateditem_result').append(`<tr class=\"bg-light\"><td>`+resp+`</td><td><a href=\"javascript:void(0)\" onclick=\"removerelated('`+resp+`')\">Remove</a></td></tr>`)
                            
                        });
                    }
                }

                function removerelated(res){
                    var index = relatedarr.indexOf(res);
                    relatedarr.splice(index, 1);
                    showRelatedProducts()
                }
			/////////////
			//delteitm//
			///////////
			function deleteitm(itmid){
			  $('#delsure').modal('show');
			  $('#delprd').val(itmid)
			   
			}
			
			
			
			$('#delpr').on('click',function(){
			            var itmid= $('#delprd').val()
			        $.ajax({
						url:\"".URL."?page=additems&action=deleteitem\", 
						type:'POST',
						data: {
							itmid:itmid
						},					
						success: function (data) {
							  $('#delprd').val()
							 Toast.fire({
                                icon: data.result,
                                title: data.message
                            });
                             $('#delsure').modal('hide');
                              table.clear().draw();
                            	showlastitems()
						}, 
						dataType:'json'
					});	
		
			    
			})
        ////////////////////////
        //Image Add
        ////////////////////////

       


        function showImages(){
            $('#imglist').html('');
            if(imagearr.length>0){
                imagearr.forEach(function(resp){
                    
                    $('#imglist').append('<div class=\"col-1\"><div class=\"row\"><img src=\"".PRODUCT_IMAGE_LOCATION.Session::get('ssl')."/'+resp+'\" height=\"50\" width=\"60\"></div><div class=\"row\"><a href=\"javascript:void(0)\" onclick=\"imgdrop(\''+resp+'\')\">Remove</a></div></div>');	
                });
            }else{
                $('#imglist').html('No Image found!');
            }
        }

        function imgdrop(img){
            var index = imagearr.indexOf(img);
            
            $.ajax({
				url:\"".URL."?page=itemdatabase&action=dropimage\", 
				type : 'POST', // type of action POST || GET
				dataType : 'json', // data type						
				data : {name:img,request:2}, // post data || get data
				beforeSend:function(){
					$(\"#overlay\").fadeIn(300);
				},
				success : function(result) {
                    $(\"#overlay\").fadeOut(300);
                    imagearr.splice(index, 1);
					showImages()
				},
				error: function(xhr, resp, text) {
					$(\"#overlay\").fadeOut(300);
					console.log(xhr, resp, text);
				}
			})
            
        }


    
         /////////////////////////
         // Item Properties Add
         /////////////////////////

         let props=[];
         
         $('.btnadd').on('click', function(e){
            e.preventDefault();
                __this = $(this).attr('id');
                var okey = __this;
                var oval = $('#'+__this+'_attr').val();
                var oprice = $('#'+__this+'_price').val();
             
                // var okey = __this.parent().prev().children('input').attr('id');
                // var oval = __this.parent().prev().children('input').val();
                if(props.length==0){
                    var obj = {};
                    obj[okey] = {attr: oval, price: oprice};
                    props.push(obj);
                }else{
                    var exist = 0;
                    for(var i=0; i<props.length; i++){
                        
                        for(const [key, value] of Object.entries(props[i])){
                            if(key==okey)
                                exist = 1;
                        }
                    }
                    if(exist == 0){
                        var obj = {};
                        obj[okey] = {attr: oval, price: oprice};
                        props.push(obj);
                    }else{
                        exist = 0;
                        for(var i=0; i<props.length; i++){
                            
                            for(const [key, value] of Object.entries(props[i])){
                                if(value.attr==oval)
                                    exist = 1;
                            }
                        }
                        if(exist == 0){
                            var obj = {};
                            obj[okey] = {attr: oval, price: oprice};
                            props.push(obj);
                        }
                    }
                
                }
                
                showAttr(okey);
                
            })

            function showAttr(okey){
                $('#'+okey+'_result').html('')
                    $.each(props,function(k,v){
                        for(const [key, value] of Object.entries(v)){
                            if(key==okey){ 
                                $('#'+key+'_result').append(`<tr class=\"bg-light\"><td>`+value.attr+`</td><td>`+value.price+`</td></tr>`)
                            }
                        }
                    })
            }
    
            function removeAttr(okey, val){
                var index = -1
                    $.each(props,function(k,v){
                        for(const [key, value] of Object.entries(v)){
                            if(value.attr==val){
                                
                                index=k
                                
                            }
                        }
                            
                    })
                    props.splice(index, 1)
                    showAttr(okey)
            }

            ///////////////////////////////////////////////////////
            //Add Item Features
            ///////////////////////////////////////////////////////

            let features = []

            $('#btnfeatureadd').on('click', function(e){
                e.preventDefault();
                 __this = $(this);
                    var okey = $('#feature').val();
                    var oval = $('#featuredesc').val();;
                    if(features.length==0){
                        var obj = {};
                        obj = {attr: okey, desc: oval};
                        features.push(obj);
                    }else{
                        var exist = 0;
                        $.each(features,function(k,v){
                            if(v.attr==okey){
                                exist = 1;
                            }
                        })
                        if(exist == 0){
                            var obj = {};
                            obj = {attr: okey, desc: oval};
                            features.push(obj);
                        }
                    
                    }
                    
                    showFeatures();
                    
                })   
                
                function showFeatures(){
                    
                    $('#feature_result').html('')
                        $.each(features,function(k,v){
                            
                                    $('#feature_result').append(`<tr class=\"bg-light\"><td>`+v.attr+`</td><td>`+v.desc+`</td><td><a href=\"javascript:void(0)\" onclick=\"removeFeatures('`+v.attr+`')\">Remove</a></td></tr>`)
                                
                            
                        })
                }       
                
                
                function removeFeatures(okey){
                    var index = -1
                        $.each(features,function(k,v){
                            
                                if(v.attr==okey){
                                    index=k
                                    
                                }
                            
                                
                        })
                        features.splice(index, 1)
                        showFeatures(okey)
                }
        
            
       
        
        //////////////////////////////////////////
        //Save Item
        //////////////////////////////////////////

         function getFormData(form){
            var unindexed_array = form.serializeArray();
            var indexed_array = {};
        
            $.map(unindexed_array, function(n, i){
                indexed_array[n['name']] = n['value'];
            });
        
            return indexed_array;
        }

        
	
        $('#btnitemsave').on('click',function(e){
           
            e.preventDefault()
            
            var strprops = JSON.stringify(props);
            var strfeatures = JSON.stringify(features);
            var itemimages = imagearr.toString();
            $('#itemprops').val(strprops);
            $('#itemfeatures').val(strfeatures);
            $('#itemimages').val(itemimages);

                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=save\", 
                    type : \"POST\",  
                    dataType: 'json',                                				
                    data: JSON.stringify(getFormData($('#itemform'))),
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        $(\"#overlay\").fadeOut(300);
                        //const resultobj = JSON.parse(result);
                        $('#itemno').val(result['message']);
                         table.clear().draw();
                        showlastitems()
                        if(result['result']=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: 'Item No '+result['message']+' created successfully!'
                            })
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: result['message']
                            })
                        }
                        
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })
            })

            $('#btnitemupdate').on('click',function(e){
           
                e.preventDefault()
                
                var strprops = JSON.stringify(props);
                var strfeatures = JSON.stringify(features);
                var itemimages = imagearr.toString();
                $('#itemprops').val(strprops);
                $('#itemfeatures').val(strfeatures);
                $('#itemimages').val(itemimages);
    
                    $.ajax({
                                        
                        url:\"".URL."?page=itemdatabase&action=update\", 
                        type : \"POST\",  
                        dataType: 'json',                                				
                        data: JSON.stringify(getFormData($('#itemform'))),
                        contentType: 'application/json;charset=UTF-8',
                        beforeSend:function(){	
                            $(\"#overlay\").fadeIn(300);
                            
                        },
                        success : function(result) {
                            $(\"#overlay\").fadeOut(300);
                            //const resultobj = JSON.parse(result);
                             table.clear().draw();
                            showlastitems()
                            if(result['result']=='success'){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Item updated successfully!'
                                })
                            }else{
                                Toast.fire({
                                    icon: 'error',
                                    title: result['message']
                                })
                            }
                            
                            
                        },error: function(xhr, resp, text) {
                            $(\"#overlay\").fadeOut(300);
                        }
                    })
                })
                function makeinactive(itemid){
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=itemnaction\", 
                    type : \"POST\",             				
                    data: {item: itemid},
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        var status='';
                        $(\"#overlay\").fadeOut(300);
                        var obj = JSON.parse(result)
                        console.log(obj['activestat']);
                        if(obj['result']=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: 'Item No '+itemid+' status changed!'
                            });
                                if(obj['activestat']==1){
                                    status='<p class=\"text-success\">Active</p>';
                                }else{
                                    status='<p class=\"text-danger\">In-active</p>';
                                  
                                }
                            let has = '#';
                            let val = itemid+'act';
                            let hasval = has+String(val);
                            $(hasval).html(\"\");
                            $(hasval).append(status);
                           
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: obj['message']
                            })
                        }
                        
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })	
            }

            function showmodal(item, idsc){
                $('#item').html(item);
                $('#itemsl').val(item);
                $('#description').html(idsc);
                $('#cost').val('0');
                $('#qty').val('0');
				$('#stockmodal').modal('toggle');
				$('#stockmodal').modal('show');
			}
			
            //////////////////////////
            //Save Stock
            //////////////////////////

            $('#savestock').on('click',function(e){
                e.preventDefault();
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=savestock\", 
                    type : \"POST\",  
                    dataType: 'json',                                				
                    data: JSON.stringify(getFormData($('#stockform'))),
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        console.log(result);
                        $(\"#overlay\").fadeOut(300);
                        //const resultobj = JSON.parse(result);
                        if(result.result=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: 'Item No '+result['message']
                            });

                            var tqty = 0;
                            let has = '#';
                            let val = result.itemid;
                            let hasval = has+String(val);
                            let itm = $(hasval).text();
                            let oldqty = parseFloat(itm);
                            let newqty = parseFloat(result.stkqty);
                            if(result.imtype == 'Receive'){
                                tqty = (oldqty+newqty).toFixed(2);
                            }else{
                                tqty = (oldqty-newqty).toFixed(2);
                            }
                            


                        
                            $(hasval).html(\"\");
                            $(hasval).append(tqty)
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: result['message']
                            })
                        }
                        
                        
                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                    }
                })
            })
        </script>
        ";
    }
}

?>