<?php
    define('_DIR_ROOT', __DIR__);

    //handel http root
    if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
        $web_root = 'https://'.$_SERVER['HTTP_HOST'];
    }else{
        $web_root = 'http://'.$_SERVER['HTTP_HOST'];
    }
    $folder = str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', strtolower(_DIR_ROOT)); // /mvc

    $web_root = $web_root . $folder; //http://localhost/mvc
    define('WEB_ROOT', $web_root);

    //auto load config
    $configs_dir = scandir('configs');
    if(!empty($configs_dir)){
        $configs = array_diff($configs_dir, ['.', '..']);
        foreach($configs as $item){
            require_once 'configs/'.$item;
        }
    }
    
    require_once 'core/Route.php'; //Load route
    
   
        if (!empty($config['database'])) {
            $db_config = array_filter($config['database']);  // Lọc các giá trị trống
    
            if (!empty($db_config)) {
                require_once 'core/Connection.php';
                require_once 'core/Database.php';
                
                // Initialize the Database object and execute the query
                $db = new Database();
            }
        }
    
    require_once 'core/Model.php';    
    require_once 'core/Controller.php'; //Load base controller
    require_once 'app/App.php'; //Load app
    