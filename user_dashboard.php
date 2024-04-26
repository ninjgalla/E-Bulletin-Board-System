<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
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
         html, body {
            margin: 0;
            padding: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

        /* Inherit font-family for all other elements */
        * {
            font-family: inherit;
        }
       
        .navbar {
            background-color: white; /* Set navbar background color */
            color: maroon;
            padding: 15px 40px; /* Adjust padding to increase width */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1); /* Add shadow */
        }
        .navbar a {
            color: maroon;
            text-decoration: none;
            margin-right: 15px;
            position: relative;
            transition: font-weight 0s; /* Add transition effect */
            font-weight: normal; /* Set normal font weight */
        }

        .navbar a:hover {
            font-weight: bold; /* Make text bold on hover */
        }
        .navbar a:hover::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -3px;
            width: 100%;
            height: 2px;
            background-color: maroon;
        }

         .file-container {
            overflow: hidden;
            position: absolute; /* Position the container */
            right: 100px; /* Adjust the distance from the right side */
            top: 55%; /* Position from the vertical center */
            transform: translateY(-50%); /* Adjust to vertically center */
            
        }
        .file-inner {
            display: flex;
            flex-direction: column;
        }

       /* Updated CSS for file-item */
                /* CSS for file-item */
        .file-item {
            display: flex;
            align-items: center;
            padding: 10px; /* Adjust spacing */
            margin: 10px 0; /* Adjust margin to add space between items */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
        }

        /* CSS for file-media */
        .file-media {
            flex-shrink: 0; /* Prevent media from shrinking */
        }

        /* CSS for file-media img and video */
        .file-media img,
        .file-media video {
            width: 100%; /* Set width to 100% */
            height: auto; /* Let the height adjust proportionally */
            max-width: 200%; /* Adjust as needed */
            max-height: 400px; /* Adjust as needed */
            border-radius: 8px; /* Add border radius */
        }


        /* Close button style */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        
        /* CSS for feedback popup form */
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

        .file-info {
            float: left;
            width: 600px; /* Adjust width as needed */
            padding-right: 20px; /* Add some spacing */
            text-align: center; /* Center-align text */
            margin-top: 40px;
            position: fixed; /* Fix position */
            left: 50px; /* Adjust left spacing */
        }

        .file-info h2 {
            text-transform: uppercase; /* Convert text to uppercase */
            color: maroon;
            text-align: center;
            
            
        }


        .file-description {
            margin-bottom: 20px; /* Add some spacing between items */
        }


        .file-container {
            overflow: hidden;
            
        }

        .file-info p {
            font-size: 19px;
            text-align: justify;
            white-space: pre-wrap; /* Preserve spaces and line breaks */
        }

    </style>
</head>
<body>
<div class="navbar">
    <div>
        <a href="user_dashboard.php">Home</a>
        <a href="profile_settings.php">Profile</a>
        <a href="#" onclick="openFeedbackPopup()">Feedback</a>
        <a href="bulletin_feed.php">Bulletin Feed</a>
    </div>
    <div>
        <a href="logout.php">Logout</a>
    </div>
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

<div class="file-info">
    <!-- Placeholder for title and description -->
    <h2 id="fileTitle"></h2>
    <p id="fileDescription"></p>
</div>

<div class="file-container">
    <div class="file-inner" id="fileInner">
        <?php
        // Fetch uploaded files from the database
        $sql = "SELECT * FROM bulletin_files WHERE schedule <= NOW() ORDER BY upload_time DESC";
        $result = $conn->query($sql);
        $count = 0;

        // Display uploaded files
        while ($row = $result->fetch_assoc()): ?>
            <div class="file-item<?php echo ($count == 0) ? ' active' : ''; ?>" style="display: <?php echo ($count == 0) ? 'block' : 'none'; ?>;" 
                data-title="<?php echo $row["title"]; ?>" data-description="<?php echo $row["description"]; ?>">
                <div class="file-media">
                    <?php if ($row["filetype"] == "photo"): ?>
                        <img src="uploads/<?php echo $row["filename"]; ?>" alt="<?php echo $row["title"]; ?>">
                    <?php elseif ($row["filetype"] == "video"): ?>
                        <video controls>
                            <source src="uploads/<?php echo $row["filename"]; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
            </div>
            <?php $count++; ?>
        <?php endwhile; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const items = document.querySelectorAll('.file-item');
    let currentIndex = -1;

    function showNextItem() {
        currentIndex = (currentIndex + 1) % items.length;

        items.forEach(item => {
            item.style.display = 'none';
        });

        items[currentIndex].style.display = 'block';

        const currentVideo = items[currentIndex].querySelector('video');

        if (currentVideo) {
            currentVideo.autoplay = true;
            currentVideo.muted = true;

            currentVideo.currentTime = 0;
            currentVideo.play();

            currentVideo.addEventListener('ended', function() {
                showNextItem(); // Call showNextItem() when the video ends
            });

            currentVideo.onerror = function() {
                setTimeout(showNextItem, 3000);
            };
        } else {
            setTimeout(showNextItem, 3000);
        }

        // Update title and description
        const titleElement = document.getElementById('fileTitle');
        const descriptionElement = document.getElementById('fileDescription');

        const currentFile = items[currentIndex];
        const title = currentFile.dataset.title;
        const description = currentFile.dataset.description;

        titleElement.textContent = title;
        descriptionElement.textContent = description;
    }

    showNextItem();
});
</script>

    <script>
    function openFeedbackPopup() {
        document.getElementById("feedbackPopup").style.display = "block";
    }

    function closeFeedbackPopup() {
        document.getElementById("feedbackPopup").style.display = "none";
    }
</script>
</body>
</html>
