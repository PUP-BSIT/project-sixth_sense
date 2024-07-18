<?php
require 'db_conn.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function output_error($message) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entries = $_POST['entry'] ?? '';
    $mood = $_POST['mood'] ?? '';
    $user_id = $_SESSION['user_id'] ?? 0;
    $entry_date = date('Y-m-d H:i:s');
    $entry_image = '';

    if (empty($entries) || $user_id == 0) {
        output_error('Invalid input data: entries or user_id is missing.');
    }
  
    if (isset($_FILES['entry_image']) && $_FILES['entry_image']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_tmp = $_FILES['entry_image']['tmp_name'];
        $file_name = basename($_FILES['entry_image']['name']);
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '.' . $file_ext;
        $target_file = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $target_file)) {
            $entry_image = $target_file;
        } else {
            output_error('Failed to upload image.');
        }
    }

    $stmt = $conn->prepare("INSERT INTO entries (user_id, entries, mood, entry_date, entry_image) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        output_error('Database prepare error: ' . $conn->error);
    }
    $stmt->bind_param("issss", $user_id, $entries, $mood, $entry_date, $entry_image);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Entry saved successfully.']);
    } else {
        output_error('Failed to save entry: ' . $stmt->error);
    }

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $user_id = $_SESSION['user_id'] ?? 0;
    $sortOrder = $_GET['sort'] == 'ASC' ? 'ASC' : 'DESC';

    if ($user_id == 0) {
        output_error('Invalid user ID');
    }

    $stmt = $conn->prepare("SELECT * FROM entries WHERE user_id = ? ORDER BY entry_date $sortOrder");
    if (!$stmt) {
        output_error('Database prepare error: ' . $conn->error);
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($entries);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $_PUT);
    $entry_id = $_PUT['entry_id'] ?? 0;
    $entries = $_PUT['entry'] ?? '';

    if ($entry_id == 0 || empty($entries)) {
        output_error('Invalid input data: entry_id or entries is missing.');
    }

    $stmt = $conn->prepare("UPDATE entries SET entries = ? WHERE id = ?");
    if (!$stmt) {
        output_error('Database prepare error: ' . $conn->error);
    }
    $stmt->bind_param("si", $entries, $entry_id);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Entry updated successfully.']);
    } else {
        output_error('Failed to update entry: ' . $stmt->error);
    }

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $entry_id = $_DELETE['entry_id'] ?? 0;

    if ($entry_id == 0) {
        output_error('Invalid entry ID');
    }

    $stmt = $conn->prepare("DELETE FROM entries WHERE id = ?");
    if (!$stmt) {
        output_error('Database prepare error: ' . $conn->error);
    }
    $stmt->bind_param("i", $entry_id);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Entry deleted successfully.']);
    } else {
        output_error('Failed to delete entry: ' . $stmt->error);
    }

    exit();
}

output_error('Unsupported request method');
?>
