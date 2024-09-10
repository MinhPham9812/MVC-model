<?php
    class Controller{
        public function model($model){
            if(file_exists(_DIR_ROOT.'/app/models/'.$model.'.php')){
                require_once _DIR_ROOT.'/app/models/'.$model.'.php';
                if(class_exists($model)){
                    $model = new $model();
                    return $model;
                }
            }
            return false;
        }


        public function render($view, $data = []){
            //function extract change key array to variable
            extract($data);
            if(file_exists(_DIR_ROOT.'/app/views/'.$view.'.php')){
                require_once _DIR_ROOT.'/app/views/'.$view.'.php';
                
            }else{
                require_once _DIR_ROOT.'/app/errors/404.php';
            }
        }
    }