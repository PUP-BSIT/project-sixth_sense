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
    $input = json_decode(file_get_contents("php://input"), true);
    $entry = $input["entry"] ?? '';
    if (!empty($entry)) {
        $entryDate = date('Y-m-d H:i:s');
        $entryId = uniqid()

        $stmt = $conn->prepare("INSERT INTO diary_entries (entry_id, entry, entry_date, user_id, time_created, time_updated) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $entryId, $entry, $entryDate, $userId, $entryDate, $entryDate);
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
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $input = json_decode(file_get_contents("php://input"), true);
    $entryId = $input['entry_id'] ?? '';
    if (!empty($entryId)) {
        $stmt = $conn->prepare("DELETE FROM diary_entries WHERE entry_id=? AND user_id=?");
        $stmt->bind_param('ss', $entryId, $userId);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not delete diary entry.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Entry ID is required.']);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $input = json_decode(file_get_contents("php://input"), true);
    $entryId = $input['entry_id'] ?? '';
    $entry = $input['entry'] ?? '';
    if (!empty($entryId) && !empty($entry)) {
        $entryDate = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("UPDATE diary_entries SET entry=?, time_updated=? WHERE entry_id=? AND user_id=?");
        $stmt->bind_param('ssss', $entry, $entryDate, $entryId, $userId);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Diary entry updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: Could not update diary entry.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Entry ID and content are required.']);
    }
}
?>
