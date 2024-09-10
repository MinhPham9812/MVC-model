<?php
    //Setup path to controller
    class App{
        private $__controller, $__action, $__params, $__route;
        function __construct(){
            global $routes;
            $this->__route = new Route();
            $this->__controller = $routes['default_controller'];
            $this->__action = 'index';
            $this->__params = [];
            
            $this->handleUrl();
        }

        function getUrl(){
            if(!empty($_SERVER['PATH_INFO'])){
                $url = $_SERVER['PATH_INFO'];
            }else{
                $url = '/';
            }
            return $url;
        }

        function handleUrl(){
            

            $url = $this->getUrl();
            
            //call handleRoute from Route
            $url = $this->__route->handleRoute($url);
            
            $urlArr = array_filter(explode('/', $url));
            $urlArr = array_values($urlArr);
            // Example: we have $urlArr = ['admin', 'dashboard', 'index'];
            
            $urlCheck = '';// Initialize an empty string to build the path
            if(!empty($urlArr)){
                foreach($urlArr as $key => $value){
                    $urlCheck .= $value.'/'; // Append the current part of the URL with a '/'
                    // Example after first loop iteration:
                    // $urlCheck = 'admin/'
                    
                    // Example after second loop iteration:
                    // $urlCheck = 'admin/dashboard/'
    
                    // Remove trailing '/' for file path check
                    $fileCheck = rtrim($urlCheck, '/');  
                    // $fileCheck = 'admin/dashboard'
    
                    // Split into an array to capitalize the last part
                    $fileArr = explode('/', $fileCheck);
                    // $fileArr = ['admin', 'dashboard']
    
                    // Capitalize the last part (controller name)
                    $fileArr[count($fileArr)-1] = ucfirst($fileArr[count($fileArr)-1]);
                    // $fileArr = ['admin', 'Dashboard']
    
                    // Rebuild the path
                    $fileCheck = implode('/', $fileArr);  
                    // $fileCheck = 'admin/Dashboard'
    
                    // Check if there's a previous part of URL and remove it (clean up $urlArr)
                    // Remove admin
                    if(!empty($urlArr[$key-1])){
                        unset($urlArr[$key-1]);
                    }
    
                    // Check if the file exists
                    
                    if(file_exists('app/controllers/'.$fileCheck.'.php')){
                        // If the file exists, set $urlCheck and stop the loop, That why don't see the index
                        $urlCheck = $fileCheck; // $urlCheck = 'admin/Dashboard'
                        break;
                    }
                }
                
                //admin removed above
                // before array_values: $urlArr Array ( [1] => dashboard [2] => index)
                $urlArr = array_values($urlArr);
                // after array_values: $urlArr Array ( [0] => dashboard [1] => index)
            }
            
            
            
            

            //handle controller
            if(!empty($urlArr[0])){
                $this->__controller = ucfirst($urlArr[0]);
                
            }else{
                $this->__controller = ucfirst($this->__controller);
            }

            if(file_exists('app/controllers/'.$urlCheck.'.php')){
                require_once 'app/controllers/'.$urlCheck.'.php';
                //check class exists or not
                if(class_exists($this->__controller)){
                    // $this->__controller into object
                    $this->__controller = new $this->__controller;
                    unset($urlArr[0]);
                }else{
                    $this->loadError();
                }
            }else{
                $this->loadError();
            }

            //handle action
            if(!empty($urlArr[1])){
                //this action like a function in class
                $this->__action = $urlArr[1];
                unset($urlArr[1]);
            }

            //handle params
            $this->__params = array_values($urlArr);

            //check controller and action
            if(method_exists($this->__controller, $this->__action)){
                call_user_func_array([$this->__controller, $this->__action], $this->__params);
            }else{
                $this->loadError();
            }
        }

        function loadError($name = '404'){
            require_once 'app/errors/'.$name.'.php';
        }

    }