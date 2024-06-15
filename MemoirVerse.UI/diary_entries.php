<?php
require 'db_conn.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'You need to log in first.']);
    exit();
}

$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entry = $_POST["entry"] ?? '';
    if (!empty($entry)) {
        $entryDate = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO diary_entries (entry_id, entry, entry_date, user_id, history_id, time_created, time_updated) VALUES (UUID(), ?, ?, ?, NULL, ?, ?)");
        $stmt->bind_param('sssss', $entry, $entryDate, $userId, $entryDate, $entryDate);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry saved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not save diary entry.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Entry cannot be empty.']);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sort = $_GET['sort'] ?? 'newest';
    $orderBy = $sort === 'oldest' ? 'ASC' : 'DESC';
    $stmt = $conn->prepare("SELECT * FROM diary_entries WHERE user_id=? ORDER BY entry_date $orderBy");
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    echo json_encode($entries);
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    parse_str(file_get_contents("php://input"), $put_vars);
    $entry_id = $put_vars["entry_id"] ?? '';
    $entry = $put_vars["entry"] ?? '';
    if (!empty($entry_id) && !empty($entry)) {
        $time_updated = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE diary_entries SET entry=?, time_updated=? WHERE entry_id=? AND user_id=?");
        $stmt->bind_param('ssss', $entry, $time_updated, $entry_id, $userId);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not update diary entry.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Entry ID and content cannot be empty.']);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    parse_str(file_get_contents("php://input"), $delete_vars);
    $entry_id = $delete_vars["entry_id"] ?? '';
    if (!empty($entry_id)) {
        $stmt = $conn->prepare("DELETE FROM diary_entries WHERE entry_id=? AND user_id=?");
        $stmt->bind_param('ss', $entry_id, $userId);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not delete diary entry.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Entry ID cannot be empty.']);
    }
}

$conn->close();
?>
