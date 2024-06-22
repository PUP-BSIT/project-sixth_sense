<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MemoirVerse</title>
    <link rel="stylesheet" href="./style/home_page.css">
</head>
<body>
    <div class="navbar">
        <div class="nav-left">
            <img src="profile-picture.png" alt="Profile Picture" class="profile-pic">
            <a href="#">MemoirVerse</a>
        </div>
    </div>

    <div class="content">
        <h1>Welcome to MemoirVerse!</h1>
        <p>Explore, reflect, and document your life's adventures in the MemoirVerse!</p>
        <class="features">
            <div class="feature">
                <div class="icon">📔</div>
                <a href="./diary_entries.php" class="icon">
                <h3>Diary</h3>
                <p>Keep track of your daily thoughts and experiences.</p>
            </div>
            </a>    

            <div class="feature">
                <div class="icon">😃😢</div>
                <a href="./mood.php" class="icon">
                <h3>Emotional Tracker</h3>
                <p>Monitor your emotions and well-being over time.</p>
            </div>
            </a>

            <div class="feature">
                <div class="icon">📝</div>
                <a href="./to_do_list.php" class="icon">
                <h3>To do List</h3>
                <p>Track your tasks and progress throughout the day.</p>
            </div>
            </a>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date("Y"); ?> MemoirVerse. 
                All rights reserved.</p>
            <p>MemoirVerse services collectively provide
                 a comprehensive and user-friendly platform for
                 maintaining a personal diary, ensuring that
                 users can record their thoughts and
                 memories in a secure, customizable, 
                 and enjoyable manner. </p>
            <ul class="footer-links">
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
