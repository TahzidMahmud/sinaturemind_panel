<?php

class View{

    function __construct(){

    }

	
	public function render($type,$name, $noinclude = false){
		
		if ($noinclude==true){
			require 'views/' . $name . '.php';
		}else{		
		$settings = $this->getviewfiles($type);
		require 'html/'.$settings['header'].'.php';
		require 'views/' . $name . '.php';
		require 'html/'.$settings['footer'].'.php';	
		}	
	}

	
	public static function getviewfiles($type){
		
		$views=array();
		if(file_exists(VIEW_CONF)){
			$views = json_decode(file_get_contents(VIEW_CONF), true);
		}
		$settings = array();
		if(array_key_exists($type,$views)){
			$settings["header"]=$views[$type]["header"];
			$settings["footer"]=$views[$type]["footer"];
		}
        
        return $settings;
    }
}