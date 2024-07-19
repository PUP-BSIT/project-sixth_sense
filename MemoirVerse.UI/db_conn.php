<?php
session_start();

$servername = "localhost"; 
$username = "u586757316_root";  
$password = "";  
$dbname = "memoirverse1";  

$conn = new mysqli('localhost', 'u586757316_root1', 'Escuro123!', 'u586757316_memoirverse');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>