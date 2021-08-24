<?php
class Sms extends Controller{

    function __construct(){
        parent::__construct();
        Session::init();
        if(!Session::get('adminlogin')){
            header('location: '. URL);
            exit;
        }
        $this->view->pagescript = array("./theme/plugins/dropzone/dropzone.min.js","./theme/assets/js/jquery.autocomplete.js","./theme/plugins/datatables/jquery.dataTables.min.js");
        $this->view->pagecss = array("./theme/plugins/dropzone/dropzone.min.css","./theme/assets/css/app-custom.css");
    }

    function init(){
        $ssl=Session::get('ssl');
        $this->view->script = $this->script();
        $st=$this->model->getstore();
        $bel=$this->model->any("SELECT COALESCE(SUM(xbel),0) as bel  FROM smsbel WHERE xstoreid=$ssl");
        $txn=$this->model->any("SELECT COUNT(xstoreid)as txn  FROM smstxn WHERE xstoreid=$ssl");
        // Logdebug::appendlog(print_r($txn,true));
        
        $this->view->balance=($bel[0]["bel"]-$txn[0]["txn"]);
        $this->view->render("menutemplate","appsettings/sms_view",false);
        
    }
    function getsms(){
        $lastsl=$_POST['lastsl'];
        $channel=$_POST['channel'];
        $res=$this->model->any("SELECT * FROM smstxn WHERE xsl > $lastsl AND  xchannel='$channel' LIMIT 50");
        echo json_encode(array("result"=>$res));
    }
    function send(){
        $number=$_POST["numbers"];
        $numbers=explode(",",$number);
        $body=$_POST["body"];
        $ssl=Session::get('ssl');
        foreach($numbers as $nm){
            $t=time();
            $res=$this->model->any("SELECT xchannel FROM smstxn ORDER BY xsl DESC LIMIT 1");
            $channel=array("A","B","C");
            $ind=array_search($res[0]['xchannel'], $channel);
            $c=array_splice($channel,$ind,1); 
            $xchannel=array_rand($channel,1);
        
            // Logdebug::appendlog(print_r($channel[$xchannel],true));
            $sdata = array(
                "xnumber"=>$nm,
                "bizid"=>100,
                "xstoreid"=>$ssl,
                "xbody"=>$body,
                "xchannel"=>$channel[$xchannel],
                "xdate"=>date("Y-m-d",$t),
                "xtime"=>$t,
                "zemail"=>Session::get('suser')
            );
            $this->model->create('smstxn', $sdata);

       }

        $bel=$this->model->any("SELECT COALESCE(SUM(xbel),0) as bel  FROM smsbel WHERE xstoreid=$ssl");
        $txn=$this->model->any("SELECT COUNT(xstoreid) as txn  FROM smstxn WHERE xstoreid=$ssl");
        $balance=($bel[0]["bel"]-$txn[0]["txn"]);
       echo json_encode(array("balance"=>$balance));


    }
    function add_to_contact(){
        $ssl=Session::get('ssl');
        $number=$_POST['number'];
        $name=$_POST['name'];

        
        $sdata = array(
            "xnumber"=>$number,
            "xstoreid"=>$ssl,
            "xname"=>$name
        );
        
        $res=$this->model->create('contacts', $sdata);
        echo json_encode(array("contact"=>$res));

    }
    function get_contacts(){
        $ssl=Session::get('ssl');
        $contacts=$this->model->any("SELECT * FROM contacts WHERE xstoreid=$ssl");
        echo json_encode(array("contacts"=>$contacts));
    }
    function script(){
        return "
        <script>
        $('#cls').on('click',()=>{
            $('#smsmodal').hide();
        })

        var table = $('#example').DataTable({
            \"pageLength\": 25,
            // src=\"./public/images/uploads/products/15/'+JsonResultRow.ximages+'
            \"columnDefs\": [
                
                { \"title\": \"Name\",\"width\": \"40%\" ,\"targets\":\"0\" },
                { \"title\": \"Number\", \"width\": \"40%\" ,\"targets\":\"1\"},   
                { \"title\": \"Action\", \"width\": \"10%\" ,\"targets\":\"2\"},          
            ],
            \"columns\": [
                // { \"width\": \"25%\", \"render\": function (data, type, JsonResultRow, meta) {
                //     return '<img style=\"height:5rem;width:5rem;\" src=\"./public/images/uploads/products/15/'+JsonResultRow.ximages+'\">';
                // } },
                { \"data\": \"name\" },
                { \"data\": \"number\" }, 
                {  \"width\": \"10%\" , \"render\": function (data, type, JsonResultRow, meta) {
                    // console.log(JsonResultRow)
                    return '<button class=\"btn btn-primary\" onClick=\"add_to_sms_list('+JsonResultRow.number+')\">Add</button>';
                } }
            ]
        });
        function add_to_sms_list(number){
        
            if($('#number').val()==\"\"){
                // console.log('empty')
                $('#number').val(number)
            }else{
                // console.log('notempty')
                var tmp= $('#number').val()
                tmp=tmp.concat(',')
                tmp=tmp.concat(number)
                $('#number').val(tmp)
            }
        }
        var contacts=[];
        $('#addctnbtn').on('click',(e)=>{
            e.preventDefault();
            var number=$('#ctnnumber').val();
            var name=$('#ctnname').val();
            $.ajax({
                url:\"".URL."?page=sms&action=add_to_contact\", 
                type:'POST',
                data: {
                    number:number,
                    name:name
                },					
                success: function (result) {
                    var res=JSON.parse(result)
                    // console.log(res.contact);
                    if(res.contact!=0){
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Successfull..!!'
                        })
                        var temp ={};
                        temp[\"xsl\"]=res.contact
                        temp[\"xname\"]=name
                        temp[\"xnumber\"]=number
                        // console.log(contacts.contacts)
                        contacts.contacts.push(temp);
                        table.clear().draw();
                        drawtable( contacts.contacts)
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'Couldn`t Add..!!'
    
                        })
                    }
                   
                },
            });

        })
       
        $('#contact-btn').on('click',(e)=>{
            e.preventDefault();
            $.ajax({
                url:\"".URL."?page=sms&action=get_contacts\", 
                type:'GET',					
                success: function (result) {
                    contacts=JSON.parse(result)
                    table.clear().draw();
                    drawtable(contacts.contacts)
                    // console.log(res.contacts)
                },
            });
            // $('#contacts').append('<button class=\"btn btn-warning\" onclick=\"selectall()\">Select All</button>');
            $('#smsmodal').show();
           
        })
        function selectall(){
         
            console.log('hit')
            $.each(contacts.contacts, function(key,val){

                add_to_sms_list(val.xnumber)
            })  
        }
        function drawtable(res){
            $.each(res, function(key,val){
                var temp ={};
                temp[\"name\"]=val.xname
                temp[\"number\"]=val.xnumber
                temp[\"xsl\"]=val.xsl
                table.row.add(temp).draw();
        
            })  
        }
          $('#btn-smt').on('click',(e)=>{
            e.preventDefault();
            Toast.fire({
                    icon: 'error',
                    title: 'This Feature Is Under Development..!!'

                })
            // var number=$('#number').val();
            // var body=$('#body').val();
            // var balance=parseInt($('#balance').text());
            // if(balance>0){
            //     $.ajax({
            //         url:\"".URL."?page=sms&action=send\", 
            //         type:'POST',
            //         data: {
            //             numbers:number,
            //             body:body,
            //         },					
            //         success: function (result) {
            //             // console.log(result)
            //             Toast.fire({
            //                 icon: 'success',
            //                 title: 'Sent Successfull..!!'
    
            //             })
            //             var p=JSON.parse(result)
                      
            //             $('#balance').empty().append(p.balance);

            //         },
            //     });
            // }else{
            //     Toast.fire({
            //         icon: 'error',
            //         title: 'In Sufficient Balance..!!'

            //     })
            // }
           	
          })
        </script>
        ";
    }
}

?>