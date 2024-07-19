<?php
if (!file_exists('db_conn.php')) {
    die("Database connection file is missing.");
}

include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['to_do_id'], $input['user_id'], $input['assigned'], $input['done'])) {
        $to_do_id = $conn->real_escape_string($input['to_do_id']);
        $user_id = $conn->real_escape_string($input['user_id']);
        $assigned = $conn->real_escape_string($input['assigned']);
        $done = $conn->real_escape_string($input['done']);

        $sql = "INSERT INTO to_do_list (to_do_id, user_id, assigned, done) VALUES ('$to_do_id', '$user_id', '$assigned', '$done')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid input']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>
