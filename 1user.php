<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <style>
        
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
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

        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Reset the default margin */
        }

        
    </style>
</head>
<body>
<div class="navbar">
        <div>
            <a href="user_dashboard.php">Home</a>
            <a href="profile_settings.php" >Profile</a>
            <a href="#" onclick="openFeedbackPopup()">Feedback</a>
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


    <script>
        // Other JavaScript functions for navbar and popup forms

        function openFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "block";
        }

        function closeFeedbackPopup() {
            document.getElementById("feedbackPopup").style.display = "none";
        }
    </script>
</body>
</html>
