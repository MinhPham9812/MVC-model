<?php
    class Product extends Controller{
        public $data = [];
        public $model_product;
        public function __construct(){
            $this->model_product = $this->model('ProductModel');
        }

        public function index(){
            
        }
        
        public function list_product(){
            //get data from models/ProductModel.php
            $dataProduct = $this->model_product->getListProduct();
            $this->data['sub_content']['list_product'] = $dataProduct;

            //get path to list view
            $this->data['content'] = 'products/lists';

            //Load title
            $this->data['page_title'] = 'List Product';
            

            // load layout
            $this->render('layouts/client_layout', $this->data);
        }

        public function detail_product($id=0){
            //get data from models/ProductModel.php
            $dataDetail = $this->model_product->getDetailProduct($id);
            $this->data['sub_content']['detail_product'] = $dataDetail;

            //get path to detail view
            $this->data['content'] = 'products/detail';

            $this->data['page_title'] = 'Detail Product';
            $this->data['sub_content']['title'] = 'Detail Product';
            
            // load layout
            $this->render('layouts/client_layout', $this->data);
        }
        
    }