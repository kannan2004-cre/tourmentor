<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        .admin-login {
            display: flex;
            flex-direction: column;
            justify-content: center;
            border: 2px solid antiquewhite;
            border-radius: 10px;
            width: 500px;
            padding: 20px;
            margin-left: 400px;
            margin-top: 100px;
            font-weight: bold;
        }

        .admin-login h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="admin-login">
            <h2>Welcome Admin!</h2>
            Email: <input type="email" name="email" placeholder="Enter email" required>
            Password: <input type="password" name="pass" placeholder="Enter password" required>
            <button type="submit" name="login">Login</button>
        </div>
    </form>
</body>

</html>

<?php
session_start(); 

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    
    $con = mysqli_connect("localhost", "root", "", "tourmentor");

    if (!$con) {
        echo "Database connection failed!";
    } else {
        $valid_email = 'admin2024@gmail.com';
        $valid_password = 'admin#123';

        if ($email === $valid_email && $pass === $valid_password) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.html");
            exit();
        } else {
            echo "<p style='color:red; text-align:center;'>Invalid email or password. +Please try again.</p>";
        }
    }
}
?>
