<?php 
require 'db_conn.php'; 
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Mood Tracker</title>
     <link rel="stylesheet" href="./style/chart.css">
    </head>

<body>
    <header>
        <div class="header-left">
             <img src="./assets/logo.png" alt="Logo" class="logo">
        </div>

        <nav>
            <ul class="menu">
            <li><a href="./home_page.php">Home</a></li>
                <li><a href="./entry.php">Diary</a></li>
                <li><a href="./to_do_list.php">To do list</a></li>
                <li><a href="./chart.php">Chart</a></li>
                <li><a href="./letters.php">Letters from strangers</a></li>
            </ul>
            <div class="logout-logo">
                <a href="login.php" class="logout-button">Log Out</a>
            </div>
        </nav>
    </header>
    
    <main>
        <h1>Users Mood Reflections</h1>
        <p class="intro">Welcome to Users Mood Reflections! 
            Here you can explore the mood patterns of our users.
            See how others are feeling and know that you are not alone. 
            Use the options below to view moods by date, gender, 
            or see the moods of all registered users.
        </p>

        <div class="button-container">
            <div class="custom-button"
                 onclick="location.href='mood_per_date.html'">

                <img src="./assets/mood_date.png" alt="View Mood per Date">
                <span>View Mood per Date</span>
            </div>

            <div class="custom-button" 
                 onclick="location.href='mood_gender.html'">

                <img src="./assets/mood_gender.png" alt="View Mood per Gender">
                <span>View Mood per Gender</span>
            </div>

            <div class="custom-button"
                 onclick="location.href='view_users.html'">
                 
                <img src="./assets/mood_users.png" alt="View All Users">
                <span>View All Users</span>

            </div>

            <div class="custom-button"
                 onclick="location.href='age_emotion.html'">
                 
                <img src="./assets/age_mood.png" alt="View All Users">
                <span>Emotions by Age</span>

            <div>

        </div>
    </main>
</body>
</html>