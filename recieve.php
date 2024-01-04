<?php 
        
        header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        require_once 'vendor/autoload.php';
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $server = $_ENV['DB_HOST'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $database = $_ENV['DB_NAME'];
        
        $connection = new mysqli($server,$username,$password,$database);
        if($connection->connect_error){
            die();
        }
        $result = $connection->query("SELECT * FROM messages ORDER BY sent_at DESC");
        $out = [];
        if($result->num_rows >0){
            while($row = $result->fetch_assoc()){
                $out[] = $row;
            }
            $result->free();
        }
        $connection->close();

        echo json_encode($out);
        exit;
?>