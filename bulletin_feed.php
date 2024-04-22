<?php
$host = 'localhost';
$dbname = 'ebulletin_system';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


try {
    $stmt = $db->query("SELECT id, title, description, uploader, upload_time, filename, filetype FROM bulletin_files WHERE is_archived = 0 ORDER BY upload_time DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching posts: " . $e->getMessage();
    exit; // Stop execution if there's an error
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

       /* Bulletin Feed */
.container {
    max-width: 600px;
    margin: 0 auto;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 100px;
    margin-bottom: 100px;
}

.post-container {
    margin-bottom: 30px;
}

.post {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
}

.post h2 {
    margin: 0;
    color: #333;
}

.post p {
    margin: 10px 0;
    color: #555;
}

.post .meta {
    font-size: 12px;
    color: #777;
}

.post .meta span {
    margin-right: 10px;
}

.description {
    margin-bottom: 10px;
}

.more,
.less {
    cursor: pointer;
    color: blue;
}

/* CSS for comment field */
.post form {
    margin-top: 20px;
}

.post form label {
    display: block;
    margin-bottom: 5px;
}

.post form input[type="text"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

.post form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.post form input[type="submit"]:hover {
    background-color: #45a049;
}


.comment-form {
    position: relative;
    display: flex;
    align-items: center;
}

#comment {
    width: calc(100% - 40px); /* Adjust width as needed */
}

.comment-button {
    position: absolute;
    top: 50%;
    right: 5px; /* Adjust right position as needed */
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
}

.comment-button i {
    font-size: 20px;
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

<!-- Bulletin feed -->
<div class="container">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="post">
                <h2><?php echo $post['title']; ?></h2>
                <?php if (strlen($post['description']) > 100): ?>
                    <!-- If description is long, show a shortened version with "See more" link -->
                    <p class="description"><?php echo substr($post['description'], 0, 100); ?> <span class="more">... <a href="#" class="see-more">See more</a></span></p>
                    <p class="full-description" style="display: none;"><?php echo $post['description']; ?> <span class="less" style="display: none;"><a href="#" class="see-less">See less</a></span></p>
                <?php else: ?>
                    <!-- If description is short, display it without "See more" link -->
                    <p class="description"><?php echo $post['description']; ?></p>
                <?php endif; ?>
                <?php if ($post['filetype'] === 'photo'): ?>
                    <!-- Display photo -->
                    <img src="uploads/<?php echo $post['filename']; ?>" alt="<?php echo $post['title']; ?>" style="max-width: 100%;">
                <?php elseif ($post['filetype'] === 'video'): ?>
                    <!-- Display video -->
                    <video controls style="max-width: 100%;">
                        <source src="uploads/<?php echo $post['filename']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php else: ?>
                    <!-- Display other file types (if needed) -->
                    <a href="uploads/<?php echo $post['filename']; ?>">Download File</a>
                <?php endif; ?>
                <!-- Add comment field with button -->
                <form action="add_comment.php" method="post" class="comment-form">
                    <input type="text" id="comment" name="comment" placeholder="Add a comment...">
                    <button type="submit" class="comment-button"><i class="fa-solid fa-paper-plane" style="color: #a30f0f;"></i></i></button>
                </form>
                <!-- Display other post details as needed -->
                <div class="meta">
                    <span>Uploaded by: <?php echo $post['uploader']; ?></span>
                    <span>Uploaded at: <?php echo $post['upload_time']; ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>

<script>
    // Other JavaScript functions for navbar and popup forms

    function openFeedbackPopup() {
        document.getElementById("feedbackPopup").style.display = "block";
    }

    function closeFeedbackPopup() {
        document.getElementById("feedbackPopup").style.display = "none";
    }

    // JavaScript for "See more" and "See less" functionality
    var seeMoreLinks = document.querySelectorAll('.see-more');
    var seeLessLinks = document.querySelectorAll('.see-less');

    seeMoreLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var post = this.closest('.post');
            post.querySelector('.description').style.display = 'none';
            post.querySelector('.full-description').style.display = 'block';
            post.querySelector('.less').style.display = 'inline';
            this.style.display = 'none';
        });
    });

    seeLessLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var post = this.closest('.post');
            post.querySelector('.description').style.display = 'block';
            post.querySelector('.full-description').style.display = 'none';
            post.querySelector('.more').style.display = 'inline';
            this.style.display = 'none';
        });
    });
 // JavaScript to clear the placeholder text on focus
 var commentInput = document.getElementById('comment');

commentInput.addEventListener('focus', function() {
    this.placeholder = '';
});

commentInput.addEventListener('blur', function() {
    if (this.value === '') {
        this.placeholder = 'Add a comment...';
    }
});
</script>
</body>
</html>