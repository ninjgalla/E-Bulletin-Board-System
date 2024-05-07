<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
    <style>
        /* Styling for the pop-up */
        .popup {
            display: block; /* Make the pop-up visible by default */
            position: fixed;
            z-index: 1;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 60%; /* Reduced width */
            max-width: 400px;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Close button */
        .popup .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            margin-right: 10px;
        }

        .popup .close:hover,
        .popup .close:focus {
            color: black;
            text-decoration: none;
        }

        /* Upload form content */
        .popup .form-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center align the content */
            border-radius: 10px;
        }

        /* Form input fields */
        .popup input[type="file"],
        .popup input[type="text"],
        .popup textarea {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        /* Form submit button */
        .popup input[type="submit"] {
            background-color: maroon; /* Change the background color to maroon */
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: inline-block; /* Ensure the button takes up only necessary space */
        }

        .popup input[type="submit"]:hover {
            background-color: #800000; /* Darken the maroon color on hover */
        }

        /* CSS for schedule input field */
        .popup input[type="datetime-local"] {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

<!-- The pop-up -->
<div id="editPopup" class="popup">
    <span class="close" onclick="closePopup()">&times;</span>
    <div class="form-content">
        <h2>Edit Item</h2>
        <!-- Form for editing -->
        <form action="admin_edit_function.php" method="post" enctype="multipart/form-data" id="editForm">
            <label for="fileToUpload">Select File:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" required><br>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="4" required></textarea><br>
            <label for="schedule">Schedule:</label>
            <input type="datetime-local" name="schedule" id="schedule" required><br> <!-- Added scheduling input -->
            <input type="submit" value="Upload" name="submit">
        </form>
    </div>
</div>

<!-- Edit button with onclick attribute to call openPopup function -->
<button onclick="openPopup(<?php echo $post_id; ?>)">Edit</button>

<script>
    // Function to close the pop-up
    function closePopup() {
        document.getElementById("editPopup").style.display = "none";
    }

    // Function to open the pop-up with pre-filled details
    function openPopup(postId) {
        fetch(`admin_fetch_post_details.php?id=${postId}`)
            .then(response => response.json())
            .then(data => {
                // Set the values of the input fields
                document.getElementById("fileToUpload").value = data.fileToUpload;
                document.getElementById("title").value = data.title;
                document.getElementById("description").value = data.description;
                document.getElementById("schedule").value = data.schedule;

                // Display the pop-up
                document.getElementById("editPopup").style.display = "block";
            })
            .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>
