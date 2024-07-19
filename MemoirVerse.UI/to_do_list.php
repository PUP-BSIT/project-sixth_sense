<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'db_conn.php';

error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST request received");

    $input = json_decode(file_get_contents('php://input'), true);

    error_log("Input received: " . print_r($input, true));

    if (isset($input['to_do_id'], $input['user_id'], $input['assigned'], $input['done'])) {
        $to_do_id = $conn->real_escape_string($input['to_do_id']);
        $user_id = $conn->real_escape_string($input['user_id']);
        $assigned = $conn->real_escape_string($input['assigned']);
        $done = $conn->real_escape_string($input['done']);

        $sql = "INSERT INTO to_do_list (to_do_id, user_id, assigned, done) VALUES ('$to_do_id', '$user_id', '$assigned', '$done')";

        error_log("SQL Query: " . $sql);

        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        error_log("Invalid input: " . print_r($input, true));
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} else {
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>
