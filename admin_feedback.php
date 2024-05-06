<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
        body {
            margin: 0;
            padding: 0;
            background-color: #e4f2f2; /* Set background color */
        }
        .navbar {
            background-color: #e4f2f2; /* Set navbar background color */
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
        .navbar .logo {
            font-weight: bold; /* Added bold font weight */
            margin-left: 10px; /* Adjusted left margin */
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

        .navbar .logo {
            font-weight: bold; /* Added bold font weight */
            margin-left: -10px; /* Adjusted left margin */
            font-size: 20px; /* Increased font size */
        }

        /* Feedback container */
        .feedback {
            margin-top: 20px;
        }

       /* Container for feedback rectangles */
        /* Feedback container */
.feedback {
    margin-top: 50px;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start; /* Align items to the start of the flex container */
    margin-left: 70px;
}

/* Feedback rectangle */
.feedback-rectangle {
    background-color: #ffffff; /* White background */
    padding: 10px; /* Add padding */
    margin: 10px; /* Reduce margin around each rectangle */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.1); /* Add shadow */
    width: 300px; /* Set specific width */
    height: 150px;
    max-height: 300px; /* Set maximum height */
    overflow-y: auto; /* Enable vertical scrollbar if needed */
    word-wrap: break-word; /* Allow text to wrap to the next line */
    margin-left: 30px;
    
}


    </style>
</head>
<body>
<div class="navbar">
        <div>
            <a href="admin_dashboard.php" class="logo">TUPM-COS EBBS</a>
        </div>
        <div>
            
            <a href="admin_upload.php">Upload</a>
            <a href="admin_archive.php">Archive</a>
            <a href="admin_profile_settings.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="feedback">
    <?php
        // Connect to the database
        $db = new mysqli("localhost", "root", "", "ebulletin_system");
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Fetch feedback from the feedback table
        $sql = "SELECT * FROM feedback ORDER BY created_at DESC";
        $result = $db->query($sql);

        // Display feedback items
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="feedback-item">';
                echo '<div class="feedback-rectangle">'; // Start feedback rectangle
                // Check if the "feedback" key exists in the $row array
                if (isset($row["created_at"])) {
                    echo '<p><strong>Date:</strong> ' . $row["created_at"] . '</p>';
                } else {
                    echo '<p><strong>Date:</strong> Date not available</p>'; // Display a default message if "created_at" key is not present
                }
                // Check if the "feedback" key exists in the $row array
                if (isset($row["feedback"])) {
                    echo '<p>' . $row["feedback"] . '</p>';
                } else {
                    echo '<p>Feedback not available</p>'; // Display a default message if "feedback" key is not present
                }
                echo '</div>'; // End feedback rectangle
                echo '</div>'; // End feedback item
            }
        } else {
            echo "No feedback available.";
        }

        // Close the database connection
        $db->close();
    ?>
</div>




</div>


    <script>

        function redirectToUploadPage() {
            window.location.href = "upload.html";
        }

        function redirectToAdminBulletin() {
    window.location.href = "admin_bulletin.php";
}
    </script>
</body>
</html>
