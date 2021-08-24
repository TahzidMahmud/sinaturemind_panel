<?php

class Controller{
	 
    function __construct(){
        
        $this->view = new View();
        
    }
    
    public function loadModel($name, $modelPath="model/"){
       
        $path = './'.$modelPath . $name . '_model.php';
        
        if(file_exists($path)){ 
            require $path; 
            $modelName = ucfirst($name . '_model');
            $this->model = new $modelName();
        }
    }

    
}





