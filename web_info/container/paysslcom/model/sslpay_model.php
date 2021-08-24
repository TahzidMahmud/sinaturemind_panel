<?php 
class Sslpay_model extends Model{
    
        function __construct(){
            parent::__construct();
        }
        function createinvoice($table,$cols, $vals){
            return $this->db->insertmultiple($table,$cols, $vals);
        }
        
        function createtxn($table,$data){
            return $this->db->insert($table,$data);
        }
        function updatetemp($st){
            return $this->db->executecrud($st);
        }
        function gettemporder($tempinvoice){
            return $this->db->select('store_temp',array(), " xtemptxn='".$tempinvoice."'");
        }
        function isordered($tempinvoice){
            return $this->db->select('storemst',array(), " xtemptxn='".$tempinvoice."' and xpaymethod='SSLCOMMERZE'");
        }
        function any($qry){
            return $this->db->dbselect($qry);
        }
        
    }

?>