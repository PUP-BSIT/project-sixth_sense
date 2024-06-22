<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "memoirverse1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mood'])) {
    $mood = $_POST['mood'];

$sql = "INSERT INTO moods (mood) VALUES ('$mood')
    ON DUPLICATE KEY UPDATE mood='$mood', timestamp=CURRENT_TIMESTAMP";
    if ($conn->query($sql) === TRUE) {
        echo "Mood updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Interface</title>
    <link rel="stylesheet" href="./style/mood_style.css" />
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
            <input type="text" class="search-bar" placeholder="Sorting" />
        </div>

    <div class="content">
        <div class="mood-tracker">
            <h2>Choose Your State of Mind:</h2>
            <div class="mood-icons">
                <div class="mood-icon" data-mood="happy">
                    <img src="./style/happy.png" alt="Happy" />
                </div>

                <div class="mood-icon" data-mood="content">
                    <img src="./assets/content.png" alt="Content"/>
                </div>

                <div class="mood-icon" data-mood="neutral">
                    <img src="./assets/neutral.png" alt="Neutral" />
                </div>

                <div class="mood-icon" data-mood="sad">
                    <img src="./assets/sad.png" alt="Sad" />
                </div>

                <div class="mood-icon" data-mood="angry">
                    <img src="./assets/anger.png" alt="Angry" />
                </div>

            </div>

                <div class="motivational-quote">Motivational Quote</div>
            </div>
        </div>

        <div class="footer">
            <button class="more-pages-button">More Pages</button>
            <div class="button-container">
                <a href="home-page.php">
                    <button type="submit" class="home-btn">Home Page</button>
                </a>
        </div>

            <form action="login.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
    </div>
    <script src="./script/mood_script.js"></script>
</body>
</html>
