<?php

    class ProductModel{
        protected $_table = 'products';

        public function getListProduct(){
            $data =[
                'Item 3',
                'Item 4',
                'Item 5'
            ];
            return $data;
        }

        public function getDetailProduct($id){
            $data =[
                'Item 3',
                'Item 4',
                'Item 5'
            ];
            return $data[$id];
        }
    }