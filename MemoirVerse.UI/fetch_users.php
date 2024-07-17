<?php
$host = 'localhost';
$db = 'memoirverse1';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$month = isset($_GET['month']) ? $_GET['month'] : null;

$query = "SELECT user_id, DATE_FORMAT(time_created, '%Y-%m-%d') as date FROM users";
$params = [];
$types = '';

if ($month && $month !== 'all') {
    $query .= " WHERE MONTH(time_created) = ?";
    $params[] = $month;
    $types .= 's';
}

$query .= " ORDER BY time_created DESC";

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