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
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f1f1f1;
    }

    * {
      font-family: inherit;
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
      grid-template-columns: 1fr 3fr;
      grid-gap: 20px;
      justify-items: left;
    }

    form label {
      margin-bottom: 7px;
    }

    form input, form #id_field {
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: calc(100% - 20px);
      box-sizing: border-box;
    }

    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .button-container button {
      padding: 10px 16px;
      width: 45%;
      border: none;
      border-radius: 5px;
      background-color: maroon;
      color: #fff;
      cursor: pointer;
      box-sizing: border-box;
      transition: background-color 0.3s ease;
      margin: 0 5px;
    }

    .button-container button:hover {
      background-color: #800000;
    }

    .button-container button[type="submit"],
    .button-container button[type="button"] {
      background-color: maroon;
    }

    h2 {
      text-align: center;
      color: maroon;
    }

    .error-message {
      color: red;
      margin-top: 5px;
    }
  </style>
</head>
<body>
<div class="container">
    <h2>Registration</h2>
    <?php if(isset($email_error)) { echo "<p class='error-message'>$email_error</p>"; } ?>
    <form action="registration_process.php" method="post">
      <label for="first_name">First Name:</label>
      <input type="text" id="first_name" name="first_name" required>
      <label for="last_name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" required>
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
      <label for="TUP_id">TUP ID:</label>
      <input type="text" id="TUP_id" name="TUP_id" required>
      <div id="id_field" style="display: none;">
        <label id="id_label" for="id"></label>
        <input type="text" id="id" name="id">
      </div>
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      
      <!-- Add the submit button inside the form -->
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
