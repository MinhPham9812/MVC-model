<?php
    
    class Route{
        // Process the URL based on the routing rules defined in $routes (from routes.php)
        public function handleRoute($url){
            global $routes;
            
            // Remove the default_controller from the routes array to avoid interfering with specific route handling
            unset($routes['default_controller']);
            
            // Trim any leading or trailing slashes from the URL
            // Example: '/admin/dashboard' -> 'admin/dashboard'
            $url = trim($url, '/');
            
            // If the URL is empty (e.g., when accessing the homepage), set it to '/'
            if(empty($url)){
                $url = '/';
            }

            $handleUrl = $url;
            if(!empty($routes)){
                foreach($routes as $key => $value){
                // Check if the current URL matches a pattern defined in the routes array
                // Example: if $key is 'admin' and $url is 'admin', this will be true
                    if(preg_match('~'.$key.'~is', $url)){
                    // Replace the matched part of the URL with the corresponding value in $routes
                    // Example: 'admin' is replaced with 'admin/dashboard'
                        $handleUrl = preg_replace('~'.$key.'~is', $value, $url);
                    }
                }
            }

            return $handleUrl;
        }
    }