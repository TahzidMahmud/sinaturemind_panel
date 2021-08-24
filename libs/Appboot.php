<?php

class Appboot{
		
		function __construct(){		
			
		}
	
	
	 public function init(){
		$router = null;
		
		$params = $_GET;
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$baselink =explode('?', $actual_link)[0]; //echo rtrim($baselink,'/').'='.URL ;
		if($baselink!=URL){
			$this->callerrorpage();
			exit;
		}
		if(count($params)==0){
			$params["page"]=INDEX_PAGE;
			$params["action"]=INDEX_PAGE_ACTION;
		}
		
			foreach($params as $key=>$value){
				$params[$key] = filter_var($value, FILTER_SANITIZE_STRING);
			}
			
			if(!isset($params['page'])  || !isset($params['action'])){
				$this->callerrorpage();
				exit;
				
			}
			
			$routerfile = WEB_CONF;

			if(file_exists($routerfile)){
				$router = json_decode(file_get_contents($routerfile), true);
			}
			if(!array_key_exists($params['page'],$router)){
				
				$this->callerrorpage();
				exit;
				
			}
			$file = $router[$params['page']]['routerpath']; 
			if(substr($router[$params['page']]['routerpath'],-1)!='/'){
				$file .= '/';
			}
			$controllerpath = $file.'controller/'.$router[$params['page']]['routerfile'].'.php';
			$modelpath = $file.'model/';
			
			if(!file_exists('./'.$controllerpath)){
				$this->callerrorpage();
				exit;
			}
			
			require './'.$controllerpath; 
			$controller = ucfirst($router[$params['page']]['routerfile']);
			$newcontroller = new $controller();
			
			if(!method_exists($newcontroller,$params["action"])){ 
				$newcontroller = null;
				$this->callerrorpage();
				exit;
			}
			
		
		
		$newcontroller->loadModel($router[$params['page']]['routerfile'], $modelpath);
		$newcontroller->{$params["action"]}();
	}

	private function callerrorpage(){
		$router = null;
		$params["page"]=ERROR_PAGE;
		$params["action"]=ERROR_PAGE_ACTION;

		$routerfile = WEB_CONF;

			if(file_exists($routerfile)){
				$router = json_decode(file_get_contents($routerfile), true);
			}
		
		$file = $router[$params['page']]['routerpath']; 
			if(substr($router[$params['page']]['routerpath'],-1)!='/'){
				$file .= '/';
			}
			
			$controllerpath = $file.'controller/'.$router[$params['page']]['routerfile'].'.php';
			$modelpath = $file.'model/';
			require './'.$controllerpath; 
			$controller = ucfirst($router[$params['page']]['routerfile']);
			$newcontroller = new $controller();
			
			$newcontroller->loadModel($router[$params['page']]['routerfile'], $modelpath);
		$newcontroller->{$params["action"]}();

	}

		
}
