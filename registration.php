<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
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
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f1f1f1;
        }

        .container {
        width: 400px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        }

        form {
        display: grid;
        gap: 10px;
        text-align: left; /* Align the content of the form to the left */
        }

        form label {
        margin-bottom: 7px; /* Add some space below each label */
        }

        form input {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: calc(100% - 20px); /* Set the width of input fields to fill the grid cell */
        box-sizing: border-box; /* Include padding and border in the width */
        }

        .button-container {
        display: flex; /* Align buttons horizontally */
        }

        form button {
        padding: 10px 2px; /* Adjust padding for both buttons */
        border: none;
        border-radius: 5px;
        background-color: maroon;
        color: #fff;
        cursor: pointer;
        width: calc(45% - 1px); /* Set fixed width for buttons */
        box-sizing: border-box; /* Include padding and border in the width */
        align-self: flex-end; /* Align buttons to the bottom */
        }

/* Adjust button width to avoid exceeding input field width */
@media (max-width: 240px) {
  form button {
    width: calc(50% - 2px); /* Adjust button width for smaller screens */
  }
}

/* Add space between buttons */
form button:first-child {
  margin-right: 18px;
}

form button:last-child {
  margin-left: 5px;
}

form button:hover {
  background-color: #800000;
}

    /* Adjust button width to avoid exceeding input field width */
    @media (max-width: 240px) {
      form button {
        width: calc(50% - 2px); /* Adjust button width for smaller screens */
      }
    }

    form button:hover {
      background-color: #800000;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 style="text-align: center;">Registration</h2>
    <form action="registration_process.php" method="post">
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" required>
      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" required>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      <label for="TUP_id">TUP ID:</label>
      <input type="text" id="TUP_id" name="TUP_id" required>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      <div class="button-container">
        <button type="submit">Register</button>
        <button type="button" onclick="goBack()">Back</button>
      </div>
    </form>
  </div>

  <script>
    function goBack() {
      window.location.href = "index.php"; // Change "previous_page.html" to the desired page
    }
  </script>
</body>
</html>
