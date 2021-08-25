<?php 
class Group_model extends Model{
    
        function __construct(){
            parent::__construct();
        }
        function createlog($table, $data){
            return $this->db->insert($table,$data);
        }
        function  any($qry){
            return $this->db->dbselect($qry);
        }
        function createinvoice($table,$cols, $vals){
            return $this->db->insertmultiple($table,$cols, $vals);
        }
        function createtemp($st){
            return $this->db->executecrud($st);
        }
        
        
        function getstno(){
            return $this->db->select('ablstatement',array("COALESCE(max(stno),0) as stno"));
        }
    }

?>