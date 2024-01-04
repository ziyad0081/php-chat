<?php
session_start();
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


$query = $connection->prepare("INSERT INTO messages(body,sender) VALUES (?,?)");
if (!isset($_SESSION["name"])) {
    if($_POST['color'] == ''){
        header("location: index.php");
        exit;
    }
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['color'] = $_POST['color'];
}
if($_POST['msg'] == ''){
    header("location: index.php");
    exit;
}
$query->bind_param("ss",$_POST['msg'],$_SESSION['name']);

$query->execute();
$result = $query->get_result();

$query->close();
$connection->close();
header("location: index.php");
exit;

?>
