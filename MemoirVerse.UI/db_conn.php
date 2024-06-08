<?php

$servername = "localhost"; 
$username = "root";  
$password = "";  
$dbname = "memoirverse1";  


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function sanitize_input($data) {
    global $conn;
    return $conn->real_escape_string(trim($data));
}
?>