<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit; // Stop further execution
}

// Include database connection
include('config.php');

// Fetch username from the session
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        /* Your existing CSS styles */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: maroon;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px; /* Adjust the margin to add space between menu items */
            position: relative;
        }

        .navbar a:hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px; /* Adjust the value to control the distance of the underline from text */
            width: 100%;
            height: 2px;
            background-color: white;
        }

        .file-container {
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Hide overflow content */
            position: relative; /* Position relative for absolute positioning */
            height: 100vh; /* Full height */
            max-width: 800px; /* Adjust max width as needed */
            margin: 0 auto; /* Center horizontally */
        }
        .file-inner {
            display: flex;
            flex-direction: column;
            transition: transform 0.5s ease; /* Smooth slide transition */
        }
        .file-item {
            padding: 10px; /* Adjust spacing */
            text-align: center;
            margin: 10px 0; /* Adjust margin to add space between items */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        .file-item img,
        .file-item video {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
            border-radius: 8px; /* Add border radius */
        }
        .file-content {
            text-align: center;
        }

        /* Style for side navbar */
        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        /* Close button style */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        /* Side navbar links */
        .sidenav a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 25px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        /* Side navbar links on hover */
        .sidenav a:hover {
            background-color: #444;
        }
        
        /* CSS for popup form */
        .feedback-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .feedback-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        .feedback-form h2 {
            margin-top: 0;
        }

        .feedback-form label {
            display: block;
            margin-bottom: 10px;
        }

        .feedback-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
        }

        .feedback-form input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: maroon;
            color: white;
            border: none;
            cursor: pointer;
        }

        .feedback-form .close-btn {
            margin-top: 10px;
            background-color: #ccc;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <a href="user_dashboard.php">Home</a>
            <a href="#" onclick="openNav()">Profile</a>
            <a href="#" onclick="openFeedbackPopup()">Feedback</a>
        </div>
        <div></div> <!-- Placeholder for menu options on the right if needed -->
    </div>

    <!-- Side navbar content -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="#">Profile Settings</a>
        <a href="change_password.php">Change Password</a>
        <a href="logout.php">Logout</a> <!-- Logout button -->
    </div>

    <!-- Feedback popup form -->
    <div id="feedbackPopup" class="feedback-popup">
        <form class="feedback-form" action="submit_feedback.php" method="post">
            <h2>Feedback Form</h2>
            <label for="feedback">Your Feedback:</label>
            <textarea id="feedback" name="feedback" required></textarea>
            <input type="submit" value="Submit">
            <button type="button" class="close-btn" onclick="closeFeedbackPopup()">Close</button>
        </form>
    </div>

    <h2>Welcome, <?php echo $username; ?></h2>

    <div class="file-container">
        <div class="file-inner" id="fileInner">
            <?php
            // Fetch uploaded files from the database
            $sql = "SELECT * FROM bulletin_files ORDER BY upload_time DESC";
            $result = $conn->query($sql);

            // Display uploaded files
            while ($row = $result->fetch_assoc()): ?>
                <div class="file-item">
                    <?php if ($row["filetype"] == "photo"): ?>
                        <img src="uploads/<?php echo $row["filename"]; ?>" alt="<?php echo $row["title"]; ?>">
                    <?php elseif ($row["filetype"] == "video"): ?>
                        <video controls>
                            <source src="uploads/<?php echo $row["filename"]; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                    <div class="file-content">
                        <h3><?php echo $row["title"]; ?></h3>
                        <p><?php echo $row["description"]; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Function to create carousel slide effect
        function carouselSlide() {
            const container = document.getElementById('fileInner');
            const items = container.querySelectorAll('.file-item');
            const totalItems = items.length;
            const itemHeight = items[0].offsetHeight;
            let currentIndex = 0;

            function moveNext() {
                currentIndex = (currentIndex + 1) % totalItems;
                container.style.transition = 'transform 0.5s ease';
                container.style.transform = `translateY(-${currentIndex * itemHeight}px)`;
            }

            // Automatically switch between items every 7 seconds
            setInterval(moveNext, 7000);
        }

        carouselSlide(); // Call the function to initialize carousel slide
    </script>

    <script>
        // Other JavaScript functions for navbar and popup forms
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function openFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "block";
        }

        function closeFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "none";
        }
    </script>
</body>
</html>
