<?php
session_start();

$servername = "localhost"; 
$username = "root";  
$password = "";  
$dbname = "memoirverse1";  

$conn = new mysqli('localhost', 'u586757316_root', 'Sixthsense21', 'u586757316_memoirverse1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>