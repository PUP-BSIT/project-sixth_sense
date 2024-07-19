<?php
require_once ('db_conn.php');

$sql = "SELECT title, content, created_at FROM letters ORDER BY created_at DESC";
$result = $conn->query($sql);

$letters = [];

while ($row = $result->fetch_assoc()) {
    $letters[] = $row;
}

echo json_encode(["letters" => $letters]);

$conn->close();
?>