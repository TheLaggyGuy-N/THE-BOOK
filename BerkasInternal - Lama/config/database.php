<?php 
    class database {
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "e-berkas";
        public $conn;

        public function __construct(){
            $this->conn = mysqli_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );
        }
    }
?>
