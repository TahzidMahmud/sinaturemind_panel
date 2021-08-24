<?php
class Forgotpass_model extends Model{
    function __construct(){
        parent::__construct();
    }

   function any($qry){
       return $this->db->dbselect($qry);
   }

}

?>