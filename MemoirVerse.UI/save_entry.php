<?php
session_start();
require 'db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["entry"]) && !empty($_POST["entry"])) {
        $entry = mysqli_real_escape_string($conn, $_POST["entry"]);
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO diary_entries (user_id, entry) VALUES ('$user_id', '$entry')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>