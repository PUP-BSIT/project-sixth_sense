<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_conn.php';

ob_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['to_do_id'], $input['user_id'], $input['assigned'], $input['done'])) {
        $to_do_id = $input['to_do_id'];
        $user_id = $input['user_id'];
        $assigned = $input['assigned'];
        $done = $input['done'];

        $sql = "INSERT INTO to_do_list (to_do_id, user_id, assigned, done) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $to_do_id, $user_id, $assigned, $done);

        if ($stmt->execute()) {
            ob_end_clean();
            echo json_encode(["success" => true]);
        } else {
            ob_end_clean();
            echo json_encode(["success" => false, "error" => "Database error: " . $stmt->error]);
        }
    } else {
        ob_end_clean();
        echo json_encode(["success" => false, "error" => "Invalid input"]);
    }
} else {
    ob_end_clean();
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}
?>
