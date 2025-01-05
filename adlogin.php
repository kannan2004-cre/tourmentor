<?php
session_start();

// If admin is already logged in, redirect to admin panel
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit();
}

$error_message = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $con = mysqli_connect("localhost", "root", "", "tourmentor");

    if (!$con) {
        $error_message = "Database connection failed!";
    } else {
        $valid_email = 'admin2024@gmail.com';
        $valid_password = 'Admin2024#';

        // In a real-world scenario, you should use password_hash() and password_verify()
        if ($email === $valid_email && $pass === $valid_password) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.php");
            exit();
        } else {
            $error_message = "Invalid email or password. Please try again.";
        }
    }
    mysqli_close($con);
}
?>

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
            margin: 100px auto;
            font-weight: bold;
        }

        .admin-login h2 {
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="admin-login">
            <h2>Welcome Admin!</h2>
            <?php
            if (!empty($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email" required>
            <label for="pass">Password:</label>
            <input type="password" id="pass" name="pass" placeholder="Enter password" required>
            <button type="submit" name="login">Login</button>
        </div>
    </form>
</body>

</html>