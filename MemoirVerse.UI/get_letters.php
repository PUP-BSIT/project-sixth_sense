<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoirverse1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
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
