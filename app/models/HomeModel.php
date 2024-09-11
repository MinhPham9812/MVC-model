<?php
    class HomeModel extends Model{
        protected $_table = 'users';

        

        public function getList(){
            $data = $this->db->query("SELECT * FROM $this->_table")->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
    }