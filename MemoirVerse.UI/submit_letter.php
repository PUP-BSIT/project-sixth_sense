<?php
session_start();
include 'db_conn.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "User not logged in"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO letters (title, content, user_id) VALUES (?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(["success" => false, "error" => "Prepare failed: " . htmlspecialchars($conn->error)]);
        exit;
    }
    $stmt->bind_param("ssi", $title, $content, $user_id);

    try {
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    $stmt->close();
    $conn->close();
}
?>
