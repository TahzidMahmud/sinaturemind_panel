<?php

// if (!defined('PAYGATE_URL')) {
//     define('PAYGATE_URL', 'https://nagbak.com/?page=paynow');
// }
                if (!defined('PAYGATE_URL')) {
                    define('PAYGATE_URL', 'http://localhost/signaturemind_panel/?page=paynow');
                }

                if (!defined('API_DOMAIN_URL')) {
                    define('API_DOMAIN_URL', 'https://sandbox.sslcommerz.com');
                }

                if (!defined('STORE_ID')) {
                    define('STORE_ID', 'test_amarbazarltd');
                }

                if (!defined('STORE_PASSWORD')) {
                    define('STORE_PASSWORD', 'test_amarbazarltd@ssl');
                }

                if (!defined('IS_LOCALHOST')) {
                    define('IS_LOCALHOST', true);
                }


                    if (!defined('LIBS')) { 
                        define ('LIBS','./libs/');
                    }
                    
                    if (!defined('URL')) { 
                        define('URL',(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http").'://localhost/signaturemind_panel/');  
                    }
                     
                    
                    if (!defined('PROJECT_PATH')) {     
                        define('PROJECT_PATH', 'http://'.$_SERVER['HTTP_HOST'].'/signaturemind_panel/');
                    }   
                    if (!defined('APPNAME'))      
                        define ('APPNAME','DOTERP');
                    
                    if (!defined('WEB_CONF'))   
                        define ('WEB_CONF','./web_info/router.json');
                    
                    
                    if (!defined('VIEW_CONF'))   
                        define ('VIEW_CONF','./web_info/view_conf.json');

                    if (!defined('INDEX_PAGE'))   
                        define ('INDEX_PAGE','nagbakpages');

                    if (!defined('INDEX_PAGE_ACTION'))   
                        define ('INDEX_PAGE_ACTION','init');

                    if (!defined('ERROR_PAGE'))   
                        define ('ERROR_PAGE','errorpage');

                    if (!defined('ERROR_PAGE_ACTION'))   
                        define ('ERROR_PAGE_ACTION','init');

                    if (!defined('USER_IMAGE_LOCATION'))   
                        define ('USER_IMAGE_LOCATION','./public/images/uploads/users/');

                    if (!defined('PRODUCT_IMAGE_LOCATION'))   
                        define ('PRODUCT_IMAGE_LOCATION','./public/images/uploads/products/');
                
                
                
                    if (!defined('HASH_KEY'))
                        define ('HASH_KEY', 'donotchangeitmylove');
                                       
                

                    if (!defined('API_KEY'))  
                        define ('API_KEY', '36cfce7372fc99723569236e883dc4db39669cdf116a57d6d126e05fdea7be3c');
                                       
                    if (!defined('DB_TYPE')) 
                        define ('DB_TYPE','mysql');
                    
                    if (!defined('DB_HOST')) 
                        define ('DB_HOST','localhost');
                        
                    // if (!defined('DB_NAME')) 
                    //     define ('DB_NAME','nagbak_test');
                    
                    // if (!defined('DB_USER')) 
                    //     define ('DB_USER','nagbak_root');
                    
                    // if (!defined('DB_PASS')) 
                    //     define ('DB_PASS','Dbsl@2021');

                        if (!defined('DB_NAME')) 
                        define ('DB_NAME','annexnewtest');
                    
                    if (!defined('DB_USER')) 
                        define ('DB_USER','root');
                    
                    if (!defined('DB_PASS')) 
                        define ('DB_PASS','');
            
              
    
  
    return [
        'projectPath' => constant("PROJECT_PATH"),
        'apiDomain' => constant("API_DOMAIN_URL"),
        'apiCredentials' => [
            'store_id' => constant("STORE_ID"),
            'store_password' => constant("STORE_PASSWORD"),
        ],
        'apiUrl' => [
            'make_payment' => "/gwprocess/v4/api.php",
            'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
            'order_validate' => "/validator/api/validationserverAPI.php",
            'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
            'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        ],
        'connect_from_localhost' => constant("IS_LOCALHOST"),
        'success_url' => '?page=sslpay&action=sslsuccess',
        'failed_url' => '?page=sslpay&action=sslfail',
        'cancel_url' => '?page=sslpay&action=sslcancel',
        'ipn_url' => '?page=sslpay&action=sslipn',
    ];
        