<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['username'])) {
    // Redirect the user to the login page
    header("Location: index.php");
    exit; // Stop further execution
}

// Include database connection
require_once 'config.php';

// Fetch username from the session
$username = $_SESSION['username'];

// Placeholder for the profile picture
$profilePicture = '';

// Fetch user details from the database
$query = "SELECT UserID, username, first_name, last_name, email, TUP_id, profile_picture, RoleID FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

// Check if the user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($userId, $username, $firstName, $lastName, $email, $tupId, $profilePicture, $roleID);
    $stmt->fetch();
} else {
    // Handle the case where the user is not found
    $error_message = "User not found.";
}

// Close the statement
$stmt->close();

// Initialize variables to prevent undefined variable warnings
$success_message = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userId = $_POST['userId'];
    $newRole = $_POST['role'];

    // Update user's role in the database
    $update_query = "UPDATE users SET RoleID = ? WHERE UserID = ?";
    $stmt = $conn->prepare($update_query);

    // Map the new role name to RoleID
    $roleId = null;
    switch ($newRole) {
        case '3':
            $roleId = 3;
            break;
        case '2':
            $roleId = 2;
            break;
        case '1':
            $roleId = 1;
            break;
        // Add more cases for additional roles if needed
    }

    // Bind parameters and execute query
    $stmt->bind_param("ii", $roleId, $userId);
    $stmt->execute();

    // Check for errors
    if ($stmt->errno) {
        // Error occurred
        $error_message = "Error: " . $stmt->error;
    } else {
        // Check if the update was successful
        if ($stmt->affected_rows > 0) {
            $success_message = "Role updated successfully.";
        } else {
            $error_message = "Failed to update role. No rows affected.";
        }
    }

    // Close the statement
    $stmt->close();
}

// Fetch all users with their roles from the database
$queryAllUsers = "SELECT u.UserID, u.username, u.first_name, u.last_name, u.email, u.TUP_id, u.RoleID, r.RoleName 
                  FROM users u
                  JOIN roles r ON u.RoleID = r.RoleID";

$resultAllUsers = $conn->query($queryAllUsers);

// Initialize an array to store all user records
$users = [];

// Check if the query was successful
if ($resultAllUsers) {
    // Fetch all user records and store them in the $users array
    while ($row = $resultAllUsers->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    // Handle the case where the query fails
    $error_message = "Error fetching users from the database.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
            /* Your existing CSS styles */
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
            }

            .container {
                max-width: 1000px;
                margin: 60px auto 30px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-left: 280px; /* Adjusted margin-left to start from the sidebar */
                }

            .navbar {
                background-color: #800000;
                color: maroon;
                padding: 15px 40px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 5px 4px rgba(0, 0, 0, 0.1);
            }

            .navbar a {
                color: white;
                text-decoration: none;
                margin-right: 15px;
                position: relative;
                transition: font-weight 0s;
                font-weight: normal;
            }

            .navbar .logo {
                font-weight: bold;
                margin-left: 10px;
            }

            .navbar a:hover {
                font-weight: bold;
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
                font-weight: bold;
                margin-left: -10px;
                font-size: 20px;
            }

            .sidebar {
                height: calc(100vh - 60px);
                width: 250px;
                position: fixed;
                top: 60px;
                left: 0;
                background-color: white;
                padding-top: 0;
                box-shadow: 2px 0 rgba(0, 0, 0, 0.1);
                z-index: 999;
                margin-top: -7px;
            }

            .sidebar a {
                padding: 20px;
                text-decoration: none;
                display: block;
                color: maroon;
                transition: 0.3s;
                margin-bottom: 20px; /* Adjusted margin-bottom value */
                margin-left: 30px;
                font-size: larger;
                margin-top: 40px;
            }

            .sidebar a:hover {
                font-weight: bold;
            }

           
            .profile-picture {
                position: relative; /* Make the container relative for absolute positioning */
                text-align: center;
                margin-bottom: 20px;
                padding-top: 20px;
            }

            .profile-img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                object-fit: cover;
                margin-bottom: 10px;
                border: 2px solid maroon;
            }

            input[type="file"] {
                display: none;
            }

            .profile-picture label {
                cursor: pointer;
                background-color: maroon;
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                transition: background-color 0.3s;
                font-size: smaller;
                position: absolute;
                left: 50%;
                bottom: -30px; /* Adjust the vertical position */
                transform: translateX(-50%);
                margin-bottom: 0px; /* Add space between the button and sidebar links */
                margin-top: 100px;
            }

            .profile-picture img {
                display: block; /* Ensure the image is displayed as a block element */
                margin: 0 auto; /* Center the image */
            }

            .profile-picture label:hover {
                background-color: #800000;
            }

            .empty-profile {
                background-color: red;
            }


            .hamburger {
                display: none; /* Hidden by default */
                font-size: 24px; /* Adjust font size for hamburger icon */
                color: white; /* Set font color to white */
                cursor: pointer;
            }

            .side-navbar {
                position: fixed;
                top: 0;
                right: -250px; /* Initially hide the side navbar on the right */
                width: 250px;
                height: 100%;
                background-color: #800000;
                box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
                padding-top: 60px;
                z-index: 1000;
                transition: right 0.3s ease;
                font-size: 16px;
                color: white;
            }

            .close-btn {
                position: absolute;
                top: 15px;
                left: 15px;
                font-size: 24px;
                color: white;
                cursor: pointer;
                color: white;
            }

            .side-navbar a {
                color: white;
                display: block;
                padding: 10px 20px;
                text-decoration: none;
            }

            .side-navbar a:hover {
                background-color: #575757; /* Change background on hover */
            }

            /* Ensure responsiveness */
            @media (max-width: 768px) {
                .navbar a {
                    display: none; /* Hide navbar links */
                }
                .navbar .logo {
                    display: block; /* Ensure the logo is always displayed */
                }
                .hamburger {
                    display: block; /* Show hamburger menu */
                }
            }

            @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
        }
             /* Dropdown button */
        .dropbtn {
            background-color: #800000;
            color: white;
            padding: 5px 15px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .dropbtn-a {
            background-color: #800000;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
}

        /* Dropdown content (hidden by default) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Show the dropdown menu on hover */
        .dropdown-menu:hover .dropdown-content {
            display: block;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
    background-color: #800000;
    color: white;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #800000;
        }
        
           /* Hide the dropdown content when screen size is small */
        @media only screen and (max-width: 768px) {
            .dropdown-content {
                display: none;
            }
        }
         /* Hide the dropdown content when screen size is small */
         @media only screen and (max-width: 768px) {
            .dropbtn-a {
                display: none;
            }
        }
            
    </style>
</head>
<body>
</head>
    <body>

    <div class="navbar">
    <div>
        <a href="superadmin_dashboard.php" class="logo">TUPM-COS EBBS</a>
    </div>
    <div>
        <!-- Dropdown menu for Bulletin Feed -->
        <div class="dropdown" onmouseover="showDropdown()" onmouseout="hideDropdown()">
            <button class="dropbtn-a">Bulletin</button>
            <div class="dropdown-content" id="bulletinDropdown">
                <a href="superadmin_bulletin.php">Bulletin Board</a>
                <a href="superadmin_bulletin_feed.php">Bulletin Feed</a>
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <!-- Dropdown menu for Posts -->
        <div class="dropdown" onmouseover="showPostsDropdown()" onmouseout="hidePostsDropdown()">
            <button class="dropbtn-a">Posts</button>
            <div class="dropdown-content" id="postsDropdown">
                <a href="superadmin_upload.php">Uploads</a>
                <a href="superadmin_for_approval.php">For Approval</a>
                <a href="superadmin_rejected.php">Rejected</a>
            </div>
        </div>
        <!-- End of Dropdown menu -->
        <a href="superadmin_archive.php">Archive</a>
        <a href="superadmin_profile_settings.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="hamburger" onclick="toggleSideNavbar()">
        <i class="fas fa-bars"></i>
    </div>
</div>

<!-- Side navbar -->
<div class="side-navbar" id="sideNavbar">
    <div class="close-btn" onclick="toggleSideNavbar()">
        <i class="fas fa-times"></i>
    </div>
        <a href="superadmin_bulletin_feed.php">Bulletin Feed</a>
        <a href="superadmin_bulletin.php">Bulletin Board</a>
        <a href="superadmin_upload.php">Uploads</a>
        <a href="superadmin_for_approval.php">For Approval</a>
        <a href="superadmin_rejected.php">Rejected</a>
        <a href="superadmin_archive.php">Archive</a>
        <a href="superadmin_profile_settings.php">Profile</a>
        <a href="logout.php">Logout</a>
</div>


<div class="sidebar">
        <div class="profile-picture">
            <!-- Display the user's profile picture from the database if available -->
            <?php if (!empty($profilePicture)) : ?>
                <img src="<?php echo htmlspecialchars($profilePicture); ?>" alt="User Profile Picture" class="profile-img" id="profile-picture">
            <?php else : ?>
                <img src="user.png" alt="Default Profile Picture" class="profile-img" id="profile-picture">
            <?php endif; ?>
            <form id="profile-picture-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
               
                <input type="file" id="profile-image-upload" name="profilePicture" onchange="document.getElementById('profile-picture-form').submit();">
                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($userId); ?>">
                <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>">
                <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <input type="hidden" name="tupId" value="<?php echo htmlspecialchars($tupId); ?>">
                <input type="hidden" name="existingProfilePicture" value="<?php echo htmlspecialchars($profilePicture); ?>">
            </form>
        </div>
        <a href="superadmin_profile_settings.php">User Info</a>
        <a href="superadmin_change_username.php">Change Username</a>
        <a href="superadmin_change_password.php">Change Password</a>
        <a href="superadmin_user_management.php">User Management</a>
    </div>

    <div class="container">

    <h2>User Management</h2>
    <?php if (!empty($users)) : ?>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>TUP ID</th>
                    <th>Current Role</th>
                    <th>New Role</th> <!-- Updated column heading -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['UserID']); ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['TUP_id']); ?></td>
                        <td><?php echo htmlspecialchars($user['RoleName']); ?></td>
                        <td>
                            <!-- Display current role or provide a dropdown to change the role -->
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="userId" value="<?php echo htmlspecialchars($user['UserID']); ?>">
                                <select name="role"> <!-- Add the name attribute here -->
                                    <option value="3" <?php if ($user['RoleID'] === 3) echo 'selected'; ?>>User</option>
                                    <option value="2" <?php if ($user['RoleID'] === 2) echo 'selected'; ?>>Admin</option>
                                    <option value="1" <?php if ($user['RoleID'] === 1) echo 'selected'; ?>>Super Admin</option>
                                    <!-- Add more options for additional roles if needed -->
                                </select>
                                <button type="submit">Update Role</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No users found.</p>
    <?php endif; ?>
    </div>

<script>
document.getElementById('profile-picture').addEventListener('click', function() {
    document.getElementById('profile-image-upload').click();
});

// Update profile picture preview
document.getElementById('profile-image-upload').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('profile-picture').src = reader.result;
    };
    reader.readAsDataURL(file);
});

function toggleSideNavbar() {
    var sideNavbar = document.getElementById('sideNavbar');
    if (sideNavbar.style.right === '0px') {
        sideNavbar.style.right = '-250px';
    } else {
        sideNavbar.style.right = '0px';
    }
}

function closeSideNavbarOnLargeScreen() {
    var sideNavbar = document.getElementById('sideNavbar');
    var screenWidth = window.innerWidth;
    if (screenWidth > 768) {
        sideNavbar.style.right = '-250px';
    }
}

window.onload = closeSideNavbarOnLargeScreen;
window.onresize = closeSideNavbarOnLargeScreen;
</script>
</body>
</html>