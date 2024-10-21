<?php
$host = 'localhost'; 
$dbname = 'tech_support';
$port = 3306; 
$username = 'root'; 
$password = '123456'; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=utf8", $username, $password); 
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    $db->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    $error_message = $e->getMessage();  
    error_log($error_message);
    
    include('../errors/database_error.php'); 
    exit();
}
?>