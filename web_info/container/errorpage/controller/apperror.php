<?php
class Apperror extends Controller{
    function __construct(){
        parent::__Construct();
    }
    function init($errorno="404"){
        $this->view->render("notemplate","zerrorpage/init_view",false);
    }
}