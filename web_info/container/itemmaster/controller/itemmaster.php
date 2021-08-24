<?php
class Itemmaster extends Controller{

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
        $data = array(
            'xstdprice'=>$price,
            'xmrp'=>$mrp,
            'ablpercent'=>$percentage,
            'xlongdesc'=>$longdsc
        );

            $where = " xstoreid=".Session::get('ssl')." and xitemid = ".$itmid;
       
            $result = $this->model->update("seitem",$data,$where);
            
                //   Logdebug::appendlog(print_r($result, true));
       if($result){
                echo json_encode(array("result"=>"success", "message"=>'Item Updated!'));
                
            }else{
                echo json_encode(array("result"=>"error", "message"=>'Item Update failed!'));
            }
      
    

    
}

    function init(){
         $storeid = Session::get('ssl');
        $this->view->script = $this->script();
          $categories= $this->model->any("SELECT * FROM onlinecat WHERE xstoreid='15' OR xstoreid='$storeid'");
        $brands= $this->model->fetchbrands("onlinebrand","*");
        // Logdebug::appendlog(print_r($categories,true));
        //   Logdebug::appendlog(print_r($_SESSION,true));
        $this->view->allcategories=$categories;
        $this->view->allbrands=$brands;

        $this->view->render("menutemplate","appsettings/itemdatabase_view",false);
        
    }

    function savestock(){
        $date = date('Y-m-d');
        $data = json_decode(file_get_contents('php://input'));
        $imtype = filter_var($data->imtype, FILTER_SANITIZE_STRING);
        $itemsl = filter_var($data->itemsl, FILTER_SANITIZE_STRING);
       

        $cost = $data->cost;
        $qty = $data->qty;
        $storeid = Session::get('ssl');
        $zemail = Session::get('suser');

        if(!is_numeric($cost)){
            echo json_encode(array("result"=>"success","message"=>"Invalid cost. only number is allowed!"));
            exit;
        }

        if(!is_numeric($qty)){
            echo json_encode(array("result"=>"error","message"=>"Invalid quantity. only number is allowed!"));
            exit;
        }

        if(!is_numeric($itemsl)){
            echo json_encode(array("result"=>"error","message"=>"Invalid item signature!"));
            exit;
        }

        $item = $this->model->finditembyid($itemsl);

        if(count($item)==0){
            echo json_encode(array("result"=>"error","message"=>"Item not in database!"));
            exit;
        }
        
        $sign = ($imtype=='Receive'? 1 : -1);
   
        
        $doctype = ($imtype=='Receive'? 'Stock Receive' : 'Stock Issue');
        //Logdebug::appendlog(print_r($data, true));
        //Logdebug::appendlog($doctype);
        $sdata = array(
            "xdate"=>$date,
            "bizid"=>100,
            "xstoreid"=>$storeid,
            "xitemid"=>$itemsl,
            "xcost"=>$cost,
            "xqty"=>$qty,
            "xsign"=>$sign,
            "xdoctype"=>$doctype,
            "zemail"=>Session::get('suser')
        );
        
        // $result = $this->model->create('imtrnonline', $sdata);
       


        // if($result>0){
            $stock = ($imtype=='Receive'? floatval($item[0]['stock'])+$qty : floatval($item[0]['stock'])-$qty);
            //Logdebug::appendlog($stock);
            $where = " xitemid = ".$itemsl;
            $udata = array("xstock"=>$stock); 
            $result = $this->model->update('seitem',$udata, $where);
        
            echo json_encode(array("result"=>"success","message"=>"Stock Create successfully!","itemid"=>$itemsl,"stkqty"=>$qty,"imtype"=>$imtype));
            exit;
        // }else{
        //     echo json_encode(array("result"=>"error","message"=>"Failed to create stock!"));
        //     exit;
        // }
        
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
      
        // Logdebug::appendlog(print_r($data, true));

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
function deleteitem(){
        $itmid=filter_var($_POST['itmid'], FILTER_SANITIZE_STRING);
          $storeid = Session::get('ssl');
        $this->model->any("DELETE FROM seitem
            WHERE xitemid = '$itmid' and xstoreid='$storeid'");
             echo json_encode(array("result"=>"success","message"=>" Delted successfully!"));
            
        
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


    function update(){
        try{

            $data = json_decode(file_get_contents('php://input'));

            $itemno = $data->itemno;
            $ablp = filter_var($data->ablpercent, FILTER_SANITIZE_STRING);
            $sku = filter_var($data->skucode, FILTER_SANITIZE_STRING);
             $stock = filter_var($data->stock, FILTER_SANITIZE_STRING);
            $mrp = filter_var($data->mrp, FILTER_SANITIZE_STRING);
            $itemdesc = filter_var($data->itemdesc, FILTER_SANITIZE_STRING);
            $longdesc = $data->longdesc;
            $cat = filter_var($data->cat, FILTER_SANITIZE_STRING);
            $cat=$cat[0]["xcat"];
            $subcat = filter_var($data->subcat, FILTER_SANITIZE_STRING);
             $subcat=$this->model->any("SELECT * FROM onlinesubcat WHERE xsubcatsl='$subcat'");
            $subcat=$subcat[0]["xsubcat"];
            $brand = filter_var($data->brand, FILTER_SANITIZE_STRING);
            $salesprice = $data->salesprice;
            $pricebasis = filter_var($data->pricebasis, FILTER_SANITIZE_STRING);
            $relateditems = filter_var($data->relateditems, FILTER_SANITIZE_STRING);    
            $itemprops = $data->itemprops;
            $itemfeatures = $data->itemfeatures;
           
           
            $itemunit = filter_var($data->itemunit, FILTER_SANITIZE_STRING);
    
            if($itemdesc==""){
                echo json_encode(array("result"=>"error", "message"=>"Item Description not found!"));
                exit;
            }
            if($cat==""){
                echo json_encode(array("result"=>"error", "message"=>"Item category not found!"));
                exit;
            }
            if(!is_numeric($salesprice)){
                echo json_encode(array("result"=>"error", "message"=>"Invalid sales price!"));
                exit;
            }
            //  Logdebug::appendlog(print_r($data->itemimages, true));
            if( $data->itemimages &&  $data->itemimages!=""){
                 $itemimages = $data->itemimages;
                  $data = array(
                     "ablpercent"=> $ablp,
                    "xitemcode"=>$sku,                
                    "xdesc"=>$itemdesc,
                    "xlongdesc"=>$longdesc,
                    "xcat"=>$cat,
                    "xsubcat"=>$subcat,
                    "xbrand"=>$brand,
                    "xstdprice"=>$salesprice,
                    "xpricebasis"=>$pricebasis,
                    "xrelated"=>$relateditems,
                    "xprops"=>$itemprops,
                    "xfeature"=>$itemfeatures,
                    "ximages"=>$itemimages,
                     "xmrp"=>$mrp,
                       "xstock"=>$stock,
                    "zactive"=>1,
                    "xunitstk"=>$itemunit
                );
            }else{
                 $data = array(
                "ablpercent"=> $ablp,
                "xitemcode"=>$sku,                
                "xdesc"=>$itemdesc,
                "xlongdesc"=>$longdesc,
                "xcat"=>$cat,
                "xsubcat"=>$subcat,
                "xbrand"=>$brand,
                "xstdprice"=>$salesprice,
                "xpricebasis"=>$pricebasis,
                "xrelated"=>$relateditems,
                "xprops"=>$itemprops,
                "xfeature"=>$itemfeatures,
                "xstock"=>$stock,
                "xmrp"=>$mrp,
                "zactive"=>1,
                "xunitstk"=>$itemunit
            );
            }
    
           
            $where = " xstoreid=".Session::get('ssl')." and xitemid = ".$itemno;
            $result = $this->model->update("seitem",$data,$where);
            if($result){
                echo json_encode(array("result"=>"success", "message"=>$result));
                exit;
            }
    
            }catch(Exception $e){
                echo json_encode(array("result"=>"error", "message"=>$e->getMessage()));
            }
    }

    function save(){
        
        try{

        $data = json_decode(file_get_contents('php://input'));
                // Logdebug::appendlog(print_r($data, true));
        $sku = filter_var($data->skucode, FILTER_SANITIZE_STRING);
        $ablp = filter_var($data->ablpercent, FILTER_SANITIZE_STRING);
        $mrp = filter_var($data->mrp, FILTER_SANITIZE_STRING);
        $stock = filter_var($data->stock, FILTER_SANITIZE_STRING);
        $itemdesc = filter_var($data->itemdesc, FILTER_SANITIZE_STRING);
        $longdesc = $data->longdesc;
        $cat = filter_var($data->cat, FILTER_SANITIZE_STRING);
        $cat=$this->model->any("SELECT * FROM onlinecat WHERE xcatsl='$cat'");
        $cat=$cat[0]["xcat"];
        $subcat = filter_var($data->subcat, FILTER_SANITIZE_STRING);
         $subcat=$this->model->any("SELECT * FROM onlinesubcat WHERE xsubcatsl='$subcat'");
        $subcat=$subcat[0]["xsubcat"];
        $brand = filter_var($data->brand, FILTER_SANITIZE_STRING);
        $salesprice = $data->salesprice;
        $pricebasis = filter_var($data->pricebasis, FILTER_SANITIZE_STRING);
        $relateditems = filter_var($data->relateditems, FILTER_SANITIZE_STRING);    
        $itemprops = $data->itemprops;
        $itemfeatures = $data->itemfeatures;
        $itemimages = $data->itemimages;
        $itemunit = filter_var($data->itemunit, FILTER_SANITIZE_STRING);

        if($itemdesc==""){
            echo json_encode(array("result"=>"error", "message"=>"Item Description not found!"));
            exit;
        }
        if($cat==""){
            echo json_encode(array("result"=>"error", "message"=>"Item category not found!"));
            exit;
        }
        if(!is_numeric($salesprice)){
            echo json_encode(array("result"=>"error", "message"=>"Invalid sales price!"));
            exit;
        }


        $data = array(
            "bizid"=>100,
            "xitemcode"=>$sku,
            "ablpercent"=> $ablp,
            "xstoreid"=>Session::get('ssl'),
            "zemail"=>Session::get('suser'),
            "xdesc"=>$itemdesc,
            "xlongdesc"=>$longdesc,
            "xcat"=>$cat,
            "xsubcat"=>$subcat,
            "xbrand"=>$brand,
            "xmrp"=>$mrp,
            "xstdprice"=>$salesprice,
            "xpricebasis"=>$pricebasis,
            "xrelated"=>$relateditems,
            "xprops"=>$itemprops,
            "xfeature"=>$itemfeatures,
            "ximages"=>$itemimages,
            "zactive"=>1,
            "xstock"=>$stock,
            "xunitstk"=>$itemunit
        );
        // Logdebug::appendlog(print_r(array("hit"), true));
        $result = $this->model->create("seitem",$data);
        //  Logdebug::appendlog(print_r($result, true));
        
        
        
        if($result>0){
            echo json_encode(array("result"=>"success", "message"=>$result));
            exit;
        }

        }catch(Exception $e){
            echo json_encode(array("result"=>"error", "message"=>$e->getMessage()));
        }
    }

    function uploadimage(){

        if (!file_exists(PRODUCT_IMAGE_LOCATION.'/15/')) {
            mkdir(PRODUCT_IMAGE_LOCATION."/15/", 0777, true);
        }

        $storeFolder = PRODUCT_IMAGE_LOCATION."/15/";   //2
		
        try{
            
            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            switch($ext){
                case 'jpg':
                    break;
                case 'jpeg':
                    break;   
                case 'png':
                    break; 
                default:
                    throw new RuntimeException('Only jpg,jpeg,png accepted!');    
            }
            //Logdebug::appendlog($ext);         
            if ($_FILES['file']['size'] > 5000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }
            if (
                !isset($_FILES['file']['error']) ||
                is_array($_FILES['file']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            if (false === $ext = array_search(
                $finfo->file($_FILES['file']['tmp_name']),
                array(
                    'jpg' => 'image/jpg',
                    'jpeg' => 'image/jpeg',
                    'png' => 'image/png',
                ),
                true
            )) {
                
                throw new RuntimeException('Invalid file format.');
               
            }

            if (!empty($_FILES)) {
            
				$uploadfile = new ImageUpload();
                $result = $uploadfile->store_uploaded_image($storeFolder,'file',160, 80, "thumb");                
                $result = $uploadfile->store_uploaded_image($storeFolder,'file',500, 300);
				
                echo json_encode(array("result"=>"success", "message"=>$result));
                exit;
		    }
		
            echo json_encode(array("result"=>"error", "message"=>"Failed to upload image"));

        }catch(RuntimeException $e){   
            //Logdebug::appendlog($e->getMessage());         
            echo json_encode(array("result"=>"error", "message"=>$e->getMessage()));
            exit;
        }

		
    }

    public function dropimage(){
		$storeFolder = PRODUCT_IMAGE_LOCATION."/15/";   //2
		$request = $_POST['request'];
        if($_POST['name']==""){
            echo json_encode(array("result"=>"error", "message"=>'No image to deleted!'));
            exit;
        }
		if($request == 2){ 
			
			$targetFile =  $storeFolder.$_POST['name'];  //5
            $thumbfile = $storeFolder.'thumb_'.$_POST['name'];
			if(file_exists($targetFile))
			    unlink($targetFile); //6
            if(file_exists($thumbfile))
			    unlink($thumbfile); //6    
			
		}	
		echo json_encode(array("result"=>"error", "message"=>'image deleted!'));
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

    function lastitems(){
        $itemcount = $_GET['itemcount'];
        //Logdebug::appendlog($itemcount);
        $data = $this->model->findlastitems($itemcount);
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
    public function searchitems(){

        $cat=$_POST['cat'];
        $subcat=$_POST['subcat'];
        $query=$_POST['query'];
        $data= $this->model->filtersearch($cat,$subcat,$query);
       echo json_encode($data);

    }

    function script(){
        return "
        <script>
            /////////////////////////
            //Filter Search
            ////////////////////////
                $('#srcfbtn').on('click', function(e){
                    var cat =$('#fcat').find(\":selected\").text();
                    var subcat = $('#fsubcat').find(\":selected\").text();
                    var query = $(\"#searchfilter\").val();
             

                    
                    $.ajax({
                                        
                        url:\"".URL."?page=itemdatabase&action=searchitems\", 
                        type : 'POST',  
                        dataType:'json',                     				
                        data: {
                            cat : cat,
                            subcat : subcat,
                            query : query
                        },
                        beforeSend:function(){	
                            $(\"#overlay\").fadeIn(300);
                            
                        },
                        success : function(result) {
                            $(\"#overlay\").fadeOut(300);
                         
                            document.getElementById(\"lastitems\").innerHTML=\"\";
                           for(let i=0;i<result.length;i++ ){
                               let propstr=\"\";
                                let props=JSON.parse(result[i].xprops);
                                
                               let clr=\"\";
                               let size=\"\";
                                props.forEach(function(itm){
                                 if(itm.color){
                                    clr+=\"\"+itm.color.attr+\",\"
                                 }if(itm.size){
                                    size+=\"\"+itm.size.attr+\",\"
                                 }
                                  
                                })
                                if(clr!=\"\"){
                                    propstr+=`<span class=\"text-danger\">color:</span> `+clr+`  <span class=\"text-danger\">size:</span> `+size
                                }else{
                                    propstr+=`<span class=\"text-danger\">size:</span> `+size
                                }
                                
                                let longdes=resp.longdesc.replace(/<[^>]+>/g, '')
                                // console.log(longdes)

                            $('#lastitems').append(`
                            <tr>                                                       
                                <td>
                                    <div class=\"media\">
                                        <img src=\"./public/images/uploads/products/15/`+result[i].ximages+`\" height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+result[i].xdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+result[i].xitemid+`)\" class=\"font-12 text-primary\">ID: `+result[i].xitemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+result[i].xunitstk+`</td><td>`+result[i].xstdprice+`</td><td id=\"`+result[i].itemid+`\">`+result[i].xstock+`</td><td>`+propstr+`</td><td>`+(result[i].xstatus==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+result[i].xitemid+`','`+result[i].xdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                                <a href=\"javascript:void(0)\" id=\"`+result[i].xitemid+`act\" onclick=\"makeinactive(`+result[i].xitemid+`)\" class=\"mr-2\">`+(result[i].zactive==1?'Make Inactive': 'Make Active')+`</a>
                                  <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+longdes+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a>
                                </td>
                            </tr>
                            `)
                           }
                        

                            
                            
                            
                        },error: function(xhr, resp, text) {
                            $(\"#overlay\").fadeOut(300);
                        }
                    })
                

                })




        ///////////////////////////////////
        //Auto Complete Item Search Section
        ///////////////////////////////////

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
                    showitem(suggestion.data);
                    //console.log('You selected: ' + suggestion.value + ', ' + suggestion.data);
                },
                showNoSuggestionNotice: true,
                noSuggestionNotice: 'Sorry, no matching results'
            });

            function showitem(item){
                $('.attr_result').html('')
                let props = []
                let features = []
                let relatedarr = []
                let imagarr = []
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
                        // console.log(data)
                        $('#itemno').val(data.itemid)
                        $('#itemdesc').val(data.itemdesc)
                        $('#skucode').val(data.itemcode)
                        $('#cat').val(data.cat)
                        $('#subcat').val(data.subcat)
                        $('#mrp').val(data.mrp)
                        $('#brand').val(data.brand)
                        $('#salesprice').val(data.salesprice)
                        $('#ablpercent').val(data.ablpercent)
                        $('#itemunit').val(data.itemunit)
                          $('#stock').val(data.stock)
                        
                        props = JSON.parse(data.props)
                        features = JSON.parse(data.fetures)
                        if(data.relateditem!=''){
                            relatedarr = data.relateditem.split(',');
                        }
                        if(data.images!=''){
                            imagarr = data.images.split(',');
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
            $('#showcount').on('change', function() {
                showlastitems()
              });

            /////////////////////////
            //Show Items in table
            ////////////////////////

            showlastitems()
            function showlastitems(){
                var count =$('#showcount').find(\":selected\").text();
                $('#lastitems').html('')
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=lastitems&itemcount=\"+count,  
                    type : \"GET\",  
                    dataType: 'json',
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        $(\"#overlay\").fadeOut(300);
                        
                        result.forEach(function(resp){
                            // console.log(resp);
                            let images=''
                            if(resp.images){
                                  images = resp.images.split(',');
                            }
                           
                            let attrs = JSON.parse(resp.props); 
                            let propstr = ''
                            let keys = []
                           if( JSON.parse(resp.props)){
                            for(const [key, value] of Object.entries(attrs)){
                                if(keys.indexOf(Object.keys(value)[0]) === -1){
                                    keys.push(Object.keys(value)[0]); 
                                }
                                
                            }
                            let itmid = 1;
                            keys.forEach(function(val){
                                propstr += '<span class=\"text-danger\"><strong>'+val+': </strong></span>';
                                for(const [key, value] of Object.entries(attrs)){
                                    let valstr = Object.keys(value)[0];
                                    if(val == valstr){
                                        propstr += value[valstr].attr+',';
                                    }
                                    
                                }
                                propstr = propstr.substring(0, propstr.length - 1)+'  ';

                            })
                           }
                            let longdes=resp.longdesc.replace(/<[^>]+>/g, '')
                            
                            $('#lastitems').append(`
                            <tr>                                                       
                                <td>
                                    <div class=\"media\">
                                        <img src=\"./public/images/uploads/products/15/`+(images.length>0?images[0]:'01.png')+`\"+ height=\"30\" class=\"mr-3 align-self-center rounded\" alt=\"...\">
                                        <div class=\"media-body align-self-center\"> 
                                            <h6 class=\"m-0\">`+resp.itemdesc+`</h6>
                                            <a href=\"javascript:void(0)\" onclick=\"showitem(`+resp.itemid+`)\" class=\"font-12 text-primary\">ID: `+resp.itemid+`</a>                                                                                           
                                        </div>
                                    </div>
                                </td>
                                <td>`+resp.unit+`</td><td>`+resp.salesprice+`</td><td id=\"`+resp.itemid+`\">`+resp.stock+`</td><td>`+propstr+`</td><td>`+(resp.status==0?'Pending':'Approved')+`</td>
                                
                                <td>
                                <a href=\"javascript:void(0)\" class=\"mr-2\" onclick=\"showmodal('`+resp.itemid+`','`+resp.itemdesc+`')\" id=\"mangestock\">Manage Stock</a><br>
                                <a href=\"javascript:void(0)\" id=\"`+resp.itemid+`act\" onclick=\"makeinactive(`+resp.itemid+`)\" class=\"mr-2\">`+(resp.active==1?'Make Inactive': 'Make Active')+`</a>
                                <a href=\"javascript:void(0)\" class=\"mr-2 text-primary\" onclick=\"openmodal2('`+resp.itemid+`','`+resp.mrp+`','`+resp.salesprice+`','`+resp.ablpercent+`','`+longdes+`')\" >Edit Item</a>
                                 <a href=\"javascript:void(0)\" class=\"mr-2 text-danger\" onclick=\"deleteitm('`+resp.itemid+`')\" >Delete Item</a></td>
                            </tr>
                            `)
                        })
                       

                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(text)
                    }
                })
            }

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
                                    status='Make Inactive';
                                }else{
                                    status='Make Active';
                                  
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



            //////////////////////////
            //Add Category
            //////////////////////////

            $('#categoryimage').change(
                function(){
                    var img=$(this).val();
                    let file = document.querySelector('input[type=file]').files[0];
                    const preview = document.querySelector(\"#selectedimage\");
                    const cross = document.querySelector(\"#crossbutton\");

                    let reader = new FileReader();

                    reader.addEventListener(\"load\", function () {
                      
                        preview.src = reader.result;
                        preview.style=\"height:200px;width:200px;border-radius:5px;\"
                        cross.style=\"height:20px;width:20px;background:darkred;border-radius:50%;color:white;cursor:pointer;\"
                      }, false);
                    
                      if (file) {
                        reader.readAsDataURL(file);
                      }
                }
            );
            $('#crossbutton').click(function(){

                const cross = document.querySelector(\"#crossbutton\");
                cross.style=\"display:none;\"
                const preview = document.querySelector(\"#selectedimage\");
               preview.src=\"\";
               preview.style=\"display:none;\"
               const imginput = document.querySelector(\"#categoryimage\");
               imginput.value=\"\";
            });



            $('#addcategory').on('click',function(e){
                e.preventDefault();
                var form = new FormData(document.getElementById('addcategoryform'));
               
                //append files
                var file = document.getElementById('categoryimage').files[0];
                var cat=document.getElementById('category').value;
                form.append('category',cat);

               
                if (file) {   
                    form.append('uploaded-image', file);
                }
                
               
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=addcategory\", 
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
            })

            //////////////////////////
            //Add Brand
            //////////////////////////

            $('#addbrand').on('click',function(e){
                e.preventDefault();
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=addbrand\", 
                    type : \"POST\",  
                    dataType: 'json',                                				
                    data: JSON.stringify(getFormData($('#addbrandform'))),
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                      
                        $(\"#overlay\").fadeOut(300);
                        //const resultobj = JSON.parse(result);
                        if(result['result']=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: ''+result['message']
                            })
                            setTimeout(function(){
                                location.reload();
                             }, 301);
                            
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
            function openmodal2(val,mrp,price,percent,long){
            // console.log('hit')
           
                $('#addmodal2').modal('show');
                $('#saleprice2').val(price);
                $('#ablpercent2').val(percent);
                $('#mrp2').val(mrp);
                $('#longdesc2').val(long)
                document.getElementById(\"itmid\").value=val;
                
            }


              $('#edititm').submit(function(event) {
                event.preventDefault();
                let price =$('#saleprice2').val();
                let mrp =$('#mrp2').val();
                let percentage=$('#ablpercent2').val();
                let itmid=$('#itmid').val();
                let longdsc= $('#longdesc2').val()
                // console.log(percentage)

                $.ajax({
                                    
                    url:\"".URL."?page=additems&action=updateitm\", 
                    type : 'POST',  
                    dataType:'json',                     				
                    data: {
                        price : price,
                        percentage : percentage,
                        mrp:mrp,
                        itmid : itmid,
                        longdsc:longdsc
                        
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



            //////////////////////////
            //Add Sub-Category
            //////////////////////////

            $('#addsubcategory').on('click',function(e){
                e.preventDefault();
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=addsubcategory\", 
                    type : \"POST\",  
                    dataType: 'json',                                				
                    data: JSON.stringify(getFormData($('#addsubcategoryform'))),
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        
                        $(\"#overlay\").fadeOut(300);
                        //const resultobj = JSON.parse(result);
                        if(result['result']=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: ''+result['message']
                            })
                            setTimeout(function(){
                                location.reload();
                             }, 301);
                            
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

            ///////////////////////////////////
            //Sub category fetch
            ///////////////////////////////////
            $('#cat').on('change', function (e) {
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
                       result.forEach(
                         function(val){
                            //  console.log($(\"#subcat\"));
                             
                            $(\"#subcat\").append(
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



            ///////////////////////////////////
            //Brand fetch
            ///////////////////////////////////
            $('#cat').on('change', function (e) {
                var optionSelected = $('option:selected', this);
                var valueSelected = this.value;
              
               
                $.ajax({
                                    
                    url:\"".URL."?page=itemdatabase&action=fetchbrand&xcatsl=\"+valueSelected,  
                    type : \"GET\",  
                    dataType: 'json',
                    contentType: 'application/json;charset=UTF-8',
                    beforeSend:function(){	
                        $(\"#overlay\").fadeIn(300);
                        
                    },
                    success : function(result) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(result);
                       result.forEach(
                         function(val){
                            //  console.log($(\"#subcat\"));
                             
                            $(\"#brand\").append(
                               '<option value=\"'+val.xbrandsl+'\">'+val.xbrand+'</option>'
                            );
                         }
                        );
                        

                    },error: function(xhr, resp, text) {
                        $(\"#overlay\").fadeOut(300);
                        console.log(text)
                    }
                })
            
               
            })



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
			
        ////////////////////////
        //Image Add
        ////////////////////////

        var imagearr = []
        Dropzone.autoDiscover = false;
		$('#itemimage').dropzone({			
            addRemoveLinks: false,	
            acceptedFiles: 'image/*',	
            maxFilesize: 2, // MB
            dictDefaultMessage: 'Drop files here or click here to upload. <br /> Only Images Allowed',
            success: function (file, response) {
				
				const myObjStr = JSON.parse(response);
				
                if(myObjStr['result']=='success'){
                    // if(imagearr.indexOf(myObjStr['message']) === -1){
                    // console.log(myObjStr['message'])
                      console.log(imagearr)
                        imagearr.push(myObjStr['message'])
                          console.log(imagearr)
                    // }
                    showImages();
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: myObjStr['message']
                    })
                   
                }
				
				
            }
           
		});



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


        ////////////////////////
        //CK EDITOR
        ////////////////////////
        var cklongdesc = CKEDITOR.replace('longdesc', {
			
			on: {
			   pluginsLoaded: function(event) {
				  event.editor.dataProcessor.dataFilter.addRules({
					 elements: {
						script: function(element) {
						   return false;
						}
					 }
				  });
			   }
			}
		 });
		
		 cklongdesc.on('change', function() {
			cklongdesc.updateElement();         
		 });

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
                                $('#'+key+'_result').append(`<tr class=\"bg-light\"><td>`+value.attr+`</td><td>`+value.price+`</td><td><a href=\"javascript:void(0)\" onclick=\"removeAttr('`+okey+`','`+escape(value.attr)+`')\">Remove</a></td></tr>`)
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
                            	showlastitems()
						}, 
						dataType:'json'
					});	
		
			    
			})
        
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
            // console.log('from save')
            // console.log(imagearr)
            var itemimages = imagearr.toString();
            // console.log('after str')
            //  console.log(itemimages)
            $('#itemprops').val(strprops);
            $('#itemfeatures').val(strfeatures);
            $('#itemimages').val(itemimages);
            // console.log('hit')

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
                    // console.log('came')
                    // console.log(result)
                        $(\"#overlay\").fadeOut(300);
                        //const resultobj = JSON.parse(result);
                        $('#itemno').val(result['message']);
                        showlastitems()
                        if(result['result']=='success'){
                            Toast.fire({
                                icon: 'success',
                                title: 'Item No '+result['message']+' created successfully!'
                            })
                            $('#skucode').val('');
                            $('#itemdesc').val('');
                            $('#stock').val(0);
                            $('#itemprops').val('');
                            $('#itemfeatures').val('');
                           $('#mrp').val(0);
                           $('#salesprice').val(0);
                           $('#ablpercent').val(0);
                           $('#cat').val('');
                           $('#subcat').val('');
                           $('#brand').val('');
                           $('#longdesc').val('');
                           $('#itemimages').val('');
                         
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
                console.log(imagearr)
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
                            showlastitems()
                            if(result['result']=='success'){
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Item updated successfully!'
                                })
                                location.reload()
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