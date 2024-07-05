<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoirverse1";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
$sql = "SELECT mood, COUNT(*) as count FROM moods WHERE DATE(entry_date) = '$date' GROUP BY mood";
$result = $conn->query($sql);

$moods = array();
while($row = $result->fetch_assoc()) {
    $moods[] = $row;
}

echo json_encode($moods);

$conn->close();
?>