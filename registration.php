<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f1f1f1;
        }
        .container {
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 3px; /* Reduce margin bottom */
        }
        form input {
            padding: 8px; /* Reduce padding */
            margin-bottom: 5px; /* Reduce margin bottom */
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: maroon;
            color: #fff;
            cursor: pointer;
        }
        form button:hover {
            background-color: #800000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration</h2>
        <form action="register.php" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
