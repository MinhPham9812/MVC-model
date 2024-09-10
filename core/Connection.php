<?php
    class Connection{
        private static $instance = null;
        private $conn; // Property to hold the PDO connection

        private function __construct($config){
        
            // Set up the DSN from the config array
            $host = $config['host'] ?? 'localhost';  // Default to 'localhost' if not set
            $db = $config['dbname'] ?? '';         // Database name (empty string if not provided)
            $user = $config['username'] ?? 'root';   // Default to 'root' if not set
            $pass = $config['password'] ?? '';       // Default to empty password if not set
            $charset = 'utf8mb4';                    // Default charset
            
            // Build the DSN string
            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

            // PDO options to handle error modes and fetch modes
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on error
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch results as associative arrays
                PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
            ];

            // Try to create a PDO instance and assign it to $this->pdo
            try {
                $this->conn = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // If there is an error during connection, throw an exception
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        }

        public static function getInstance($config){
            if(self::$instance == null){
                self::$instance = new Connection($config);
            }
            return self::$instance;
        }

        // Method to get the PDO connection
        public function getConnection() {
            return $this->conn;
        }

        // Prevent cloning
        private function __clone() {}

        // Prevent unserializing
        private function __wakeup() {}
    }