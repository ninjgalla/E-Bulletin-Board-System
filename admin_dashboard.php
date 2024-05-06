<?php
// Connect to your database (replace these with your actual database credentials)
$host = 'localhost';
$dbname = 'ebulletin_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch post titles and their respective comments counts
    $sql = "SELECT bulletin_files.title, COUNT(comments.comment_id) AS comments_count
            FROM bulletin_files
            LEFT JOIN comments ON bulletin_files.id = comments.post_id
            WHERE bulletin_files.is_archived = 0
            GROUP BY bulletin_files.id";

    $stmt = $pdo->query($sql);
    $postsWithComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            font-family: Arial, sans-serif;
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

        .main-content {
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        #postChart {
            margin-top: 20px;
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

    <div class="main-content">
        <h2>Post Interaction Statistics</h2>
        <div>
            <canvas id="postChart" width="600" height="400"></canvas>
        </div>
    </div>

    <script>

        function redirectToUploadPage() {
            window.location.href = "upload.html";
        }

        function redirectToAdminBulletin() {
    window.location.href = "admin_bulletin.php";
        }

            // Convert PHP array to JavaScript array
        const postsWithComments = <?php echo json_encode($postsWithComments); ?>;

// Extract post titles and comments counts
const postTitles = postsWithComments.map(post => post.title);
const commentsCounts = postsWithComments.map(post => post.comments_count);

// Render chart using Chart.js
const ctx = document.getElementById("postChart").getContext("2d");
const myChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: postTitles,
        datasets: [{
            label: "Number of Comments",
            data: commentsCounts,
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
    </script>
</body>
</html>
