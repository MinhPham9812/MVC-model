<?php
    class Database{
        private $__conn;
        function __construct(){
            global $db_config;
            $this->__conn = Connection::getInstance($db_config)->getConnection();
        }

        function query($sql, $data=[]){
            $query = false;
            try{
                // Prepare the SQL statement
                $statement = $this->__conn->prepare($sql);
                
                // If no data is provided, execute the query without parameters
                if(empty($data)){
                    $query = $statement->execute();
                }else{
                    $query = $statement->execute($data);
                }
            }catch(Exception $e){
                echo "Error: " . $e->getMessage() . "<br>";
                echo "Line: " . $e->getLine();
            }
            
            // Return the statement object if the query was successful
            if($query){
                return $statement;
            }
            return $query;
        }
    
        // Insert a new record into a table
        function insert($table, $dataInsert){
            $keyArr = array_keys($dataInsert); //get key of Array: 'email' => example@gmail ($keyArray = 'email')
            $fiedStr = implode(', ', $keyArr); // email, firstname, lastname
            $valueStr = ':'.implode(', :', $keyArr);// :email, :firstname, lastname
    
            $sql = 'INSERT INTO ' . $table . '(' . $fiedStr . ') VALUES(' . $valueStr . ')';
            //echo $sql; // INSERT INTO users(email, firstname, lastname) VALUES(:email, :firstname, :lastname)
    
            return $this->query($sql, $dataInsert);
        } 
    
        // Update a record in a table
        function update($table, $dataUpdate, $condition = ''){
    
            $updateStr = '';
            foreach($dataUpdate as $key=>$value){
                $updateStr.=$key.'=:'.$key.', ';
            }
            $updateStr = rtrim($updateStr, ', ');
            //echo $updateStr;
    
            if(!empty($condition)){
                $sql = 'UPDATE ' .$table.' SET ' .$updateStr . ' WHERE ' . $condition;
            }else{
                $sql = 'UPDATE ' .$table.' SET ' .$updateStr;
            }
            
            //echo $sql;
            return $this->query($sql, $dataUpdate);
        }
    
        // Delete records from a table
        function delete($table, $condition = ''){
            if(!empty($condition)){
                $sql = "DELETE FROM $table WHERE $condition";
            }else{
                $sql = 'DELETE FROM ' . $table;
            }
            
            echo $sql;
    
            return $this->query($sql);
        }
    
        //Get raw data from SQL query
        function getRaw($sql){
            $statement = $this->query($sql);
    
            if(is_object($statement)){
                $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
                return $dataFetch;
            }else{
                 return false;
            }
        } 
    
        //Get data from SQL statment - first row
        function firstRaw($sql){
            $statement = $this->query($sql);
            if(is_object($statement)){
                $dataFetch = $statement->fetch(PDO::FETCH_ASSOC);
                return $dataFetch;
            }else{
                 return false;
            }
        }
    
        function get($table, $field = '*', $condition = ''){
            $sql = 'SELECT ' . $field . ' FROM ' . $table;
            if(!empty($condition)){
                $sql .= ' WHERE ' . $condition;
                echo $sql;
            }
            return $this->getRaw($sql); 
        }
    
        function first($table, $field = '*', $condition = ''){
            $sql = 'SELECT ' . $field . ' FROM ' . $table;
            if(!empty($condition)){
                $sql .= ' WHERE ' . $condition;
                echo $sql;
            }
            return $this->firstRaw($sql); 
        }
    
        function getRows($sql){
            $statement = $this->query($sql);
            if(!empty($statement)){
                return $statement->rowCount();
            }
        }
    }