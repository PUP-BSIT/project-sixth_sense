<?php
require 'db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $to_do_id = $input['to_do_id'];
    $assigned = $input['assigned'];
    $done = $input['done'];
    $time_created = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO to_do_list (to_do_id, user_id, assigned, done, time_created, time_updated) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $to_do_id, $user_id, $assigned, $done, $time_created, $time_created);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT * FROM to_do_list WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tasks = [];
        while($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $tasks]);
    } else {
        echo json_encode(['success' => false, 'error' => 'No tasks found']);
    }

    $stmt->close();
}

$conn->close();
?>
