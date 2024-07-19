<?php
require 'db_conn.php';

header('Content-Type: application/json');

$mood = isset($_GET['mood']) ? $_GET['mood'] : '';

if (empty($mood)) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT age, COUNT(*) as count
        FROM users
        JOIN entries ON users.id = entries.user_id
        WHERE mood = ?
        GROUP BY age
        ORDER BY age";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $mood);
$stmt->execute();
$result = $stmt->get_result();

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
