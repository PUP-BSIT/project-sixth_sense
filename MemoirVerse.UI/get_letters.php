<?php
$servername = "localhost"; 
$username = "u586757316_root";  
$password = "";  
$dbname = "memoirverse1";  


$conn = new mysqli('localhost', 'u586757316_root', 'Sixthsense21', 'u586757316_memoirverse1');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT title, content, created_at FROM letters ORDER BY created_at DESC";
$result = $conn->query($sql);

$letters = [];

while ($row = $result->fetch_assoc()) {
    $letters[] = $row;
}

echo json_encode(["letters" => $letters]);

$conn->close();
?>
