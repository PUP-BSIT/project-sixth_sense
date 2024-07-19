<?php
session_start();
require 'db_conn.php';

$welcomeName = "MemoirVerse";

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    error_log("User ID from session: " . $userId);

    $query = "SELECT firstName, lastName FROM users WHERE id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('i', $userId);
        if ($stmt->execute()) {
            $stmt->bind_result($firstName, $lastName);
            if ($stmt->fetch()) {
                $welcomeName = "$firstName $lastName";
                error_log("Fetched Name: " . $welcomeName);
            } else {
                error_log("Failed to fetch user name from result set.");
            }
        } else {
            error_log("Query execution failed: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Query Preparation Failed: " . $conn->error);
    }
} else {
    error_log("User ID session variable not set.");
    header('Location: login.php'); // Redirect to login if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse</title>
    <link rel="stylesheet" href="./style/home_page.css">
</head>
<body>
    <header>
        <div class="header-left">
            <div class="user-profile">
                <img src="profile.jpg" alt="Profile Picture" class="profile-pic">
                <span class="user-info"><?php echo htmlspecialchars($welcomeName); ?></span>
            </div>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="./entry.php">Diary</a></li>
                <li><a href="./to_do_list.html">To do list</a></li>
                <li><a href="./chart.php">Chart</a></li>
                <li><a href="./letters.php">Letters from strangers</a></li>
            </ul>

            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
            
            <img src="./assets/logo.png" alt="Logo" class="logo">
        </nav>
    </header>

    <main>
        <h1>Welcome <?php echo htmlspecialchars($welcomeName); ?>!</h1>
        <p>Explore, reflect, and document your life's adventures in the MemoirVerse!</p>
        <div class="features">
            <div class="feature-box">
                Keep track of your daily thoughts and experiences.
            </div>

            <div class="feature-box">
                Monitor your emotions and well-being over time.
            </div>

            <div class="feature-box">
                Track your tasks and process throughout the day.
            </div>
            
            <div class="feature-box">
                Gain insights into your emotional well-being by charting your moods over time.
            </div>
        </div>
    </main>
</body>
</html>
