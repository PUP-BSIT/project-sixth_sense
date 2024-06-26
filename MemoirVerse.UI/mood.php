<?php

if (!file_exists('db_conn.php')) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection file is missing.']));
}

include 'db_conn.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mood = $_POST['mood'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO moods (user_id, mood) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $mood);

    header('Content-Type: application/json');

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Mood recorded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to record mood.']);
    }

    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM moods WHERE user_id = ? ORDER BY entry_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$mood_entries = [];
while ($row = $result->fetch_assoc()) {
    $mood_entries[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Mood Tracker</title>
    <link rel="stylesheet" href="style/mood_style.css"/>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <div class="profile-pic"></div>
                <span class="profile-name">Memories</span>
            </div>

            <div class="menu">
                <div class="menu-item">Home</div>
                <div class="menu-item active">Mood Tracker</div>
                <div class="menu-item">To do List</div>
                <div class="menu-item">Pinned</div>
            </div>
        </div>

        <div class="main">
            <div class="header">
                <input type="text" class="search-bar" placeholder="Sorting"/>
            </div>

            <div class="content">
                <div class="mood-tracker">
                    <h2>Choose Your State of Mind:</h2>
                    <div class="mood-icons">
                        <div class="mood-icon" data-mood="happy">
                            <img src="assets/happy.png" alt="Happy"/>
                        </div>
                        <div class="mood-icon" data-mood="content">
                            <img src="assets/content.png" alt="Content"/>
                        </div>
                        <div class="mood-icon" data-mood="neutral">
                            <img src="assets/neutral.png" alt="Neutral"/>
                        </div>
                        <div class="mood-icon" data-mood="sad">
                            <img src="assets/sad.png" alt="Sad"/>
                        </div>
                        <div class="mood-icon" data-mood="angry">
                            <img src="assets/anger.png" alt="Angry"/>
                        </div>
                    </div>
                    <div class="motivational-quote">Motivational Quote</div>
                    <button id="submitMoodButton">Submit Mood</button>
                </div>
                <div id="mood_entries">
                    <h2>Mood Entries</h2>
                    <?php foreach ($mood_entries as $entry): ?>
                        <div class="entry">
                            <p>Mood: <?php echo htmlspecialchars($entry['mood']); ?></p>
                            <span class="timestamp"><?php echo htmlspecialchars($entry['entry_date']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="footer">
                <button class="more-pages-button">More Pages</button>
                <div class="button-container">
                    <a href="home-page.php">
                        <button type="button" class="home-btn">Home Page</button>
                    </a>
                </div>

                <form action="login.php" method="post">
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>
    </div>
    <script src="script/mood_script.js"></script>
</body>
</html>
