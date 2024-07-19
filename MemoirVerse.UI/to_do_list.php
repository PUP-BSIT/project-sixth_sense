<?php
session_start();
require 'db_conn.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

function sendJsonResponse($success, $data = null, $error = null) {
    echo json_encode(['success' => $success, 'data' => $data, 'error' => $error]);
    exit();
}

if (!isset($_SESSION['user_id'])) {
    sendJsonResponse(false, null, 'User not authenticated');
}

$user_id = $_SESSION['user_id'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            sendJsonResponse(false, null, 'Invalid JSON input');
        }

        $to_do_id = $data['to_do_id'];
        $assigned = $data['assigned'];
        $done = $data['done'];
        $time_created = date('Y-m-d H:i:s');

        $sql = "INSERT INTO to_do_list (to_do_id, user_id, assigned, done, time_created) VALUES ('$to_do_id', '$user_id', '$assigned', '$done', '$time_created')";

        if ($conn->query($sql) === TRUE) {
            sendJsonResponse(true);
        } else {
            sendJsonResponse(false, null, $conn->error);
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $result = $conn->query("SELECT * FROM to_do_list WHERE user_id = '$user_id'");
        if (!$result) {
            sendJsonResponse(false, null, $conn->error);
        }
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        sendJsonResponse(true, $tasks);
    } else {
        sendJsonResponse(false, null, 'Invalid request');
    }
} catch (Exception $e) {
    sendJsonResponse(false, null, $e->getMessage());
}

$conn->close();
?>
