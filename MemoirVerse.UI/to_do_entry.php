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
    $time_updated = date('Y-m-d H:i:s');

    $check_stmt = $conn->prepare("SELECT to_do_id FROM to_do_list WHERE to_do_id = ? AND user_id = ?");
    $check_stmt->bind_param("ii", $to_do_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE to_do_list SET assigned = ?, done = ?, time_updated = ? WHERE to_do_id = ? AND user_id = ?");
        $stmt->bind_param("sssii", $assigned, $done, $time_updated, $to_do_id, $user_id);
    } else {
        $time_created = $time_updated;
        $stmt = $conn->prepare("INSERT INTO to_do_list (to_do_id, user_id, assigned, done, time_created, time_updated) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iissss", $to_do_id, $user_id, $assigned, $done, $time_created, $time_updated);
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $check_stmt->close();
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
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    $to_do_id = $input['to_do_id'];

    $stmt = $conn->prepare("DELETE FROM to_do_list WHERE to_do_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $to_do_id, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
