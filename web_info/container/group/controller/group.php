<?php 
class Group extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->script="";
        $this->view->pagecss = array("./theme/assets/css/app-custom.css");
        $this->view->pagescript = array();
        Session::init();
    }

    function init(){
        $this->view->script = $this->script();
        $this->view->subjects=$this->model->any("SELECT xdesc,xitemsl FROM seitem WHERE xcat='Training Courses'");
        $this->view->render("menutemplate","group/init_view",false);
        
        
    }


    function script(){
        return "
        <script>
        
        </script>
        ";
    }

        

}
?>