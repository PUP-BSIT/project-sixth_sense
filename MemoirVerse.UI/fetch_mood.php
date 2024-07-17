<?php

require 'db_conn.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$gender = isset($_GET['gender']) ? $_GET['gender'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

$query = "SELECT mood, COUNT(*) as count FROM entries WHERE 1=1";
$params = [];
$types = '';

if ($gender) {
    $query .= " AND user_id IN (SELECT id FROM users WHERE gender = ?)";
    $params[] = $gender;
    $types .= 's';
}
if ($date) {
    $query .= " AND DATE(entry_date) = ?";
    $params[] = $date;
    $types .= 's';
}
$query .= " GROUP BY mood";

$stmt = $conn->prepare($query);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($data);
?>