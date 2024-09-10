<?php
    //
    class Route{
        // Initialize the virtual path 
        //and check if it matches the routes created in configs/routes.php
        public function handleRoute($url){
            global $routes;
            unset($routes['default_controller']);
            
            $url = trim($url, '/');

            $handleUrl = $url;
            if(!empty($routes)){
                foreach($routes as $key => $value){
                    if(preg_match('~'.$key.'~is', $url)){
                        $handleUrl = preg_replace('~'.$key.'~is', $value, $url);
                    }
                }
            }

            return $handleUrl;
        }
    }