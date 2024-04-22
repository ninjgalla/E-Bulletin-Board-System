<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            width: 300px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label {
            margin-bottom: 5px;
        }
        form input {
            padding: 10px;
            margin-bottom: 8px;
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
            margin-top: 8px; /* Added margin-top to create space */
        }
        form button:hover {
            background-color: #800000;
        }
        p {
            text-align: center;
            margin-top: 10px;
        }
        p a {
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login_process.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="registration.php">Register</a> | <a href="forgot_password.html">Forgot Password</a></p>
    </div>
</body>
</html>
