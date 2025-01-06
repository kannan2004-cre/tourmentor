<?php
include('header.php');

function debug_to_console($data) {
    echo "<script>console.log('" . addslashes(is_array($data) ? implode(',', $data) : $data) . "');</script>";
}

$email_error = $password_error = "";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    debug_to_console("Login attempt for email: " . $email);

    $conn = mysqli_connect("localhost", "root", "", "tourmentor");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM userreg WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_profile_pic'] = $row['filename'];

            debug_to_console("Login successful for: " . $email);
            echo "<script>alert('Welcome to Tourmentor!'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            $password_error = "Invalid password. Please try again.";
            debug_to_console("Invalid password for: " . $email);
        }
    } else {
        $email_error = "Invalid email. Please try again.";
        debug_to_console("Invalid email: " . $email);
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourMentor - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff7e6;
        }

        .login-container {
            background-color: #fff;
            margin-top: 50px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgb(126, 126, 143);
            width: 300px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            margin: 130px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
            overflow: hidden;
            white-space: nowrap;
            animation: typing 3s steps(30, end), blink-caret 0.5s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes blink-caret {
            from,
            to {
                border-color: transparent;
            }

            50% {
                border-color: #333;
            }
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ffa500;
            border-radius: 5px;
            font-size: 16px;
        }

        .login-container .error-message {
            color: red;
            font-size: 12px;
            text-align: left;
            margin: 5px 0;
        }

        .login-container button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #ffa500;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .login-container button[type="submit"]:hover {
            background-color: #e69500;
        }

        .login-container a {
            display: block;
            margin-top: 10px;
            color: black;
            text-decoration: none;
            font-size: 14px;
        }

        .login-container a:hover {
            color: grey;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container input:focus,
        .login-container button:focus {
            outline: none;
            box-shadow: 0 0 10px #ffa500;
        }

        .circle {
            position: fixed;
            border-radius: 50%;
            background: #ffa600;
            animation: ripple 20s infinite;
            box-shadow: 0px 0px 1px 0px #508fb9;
            pointer-events: none;
        }

        .small {
            width: 200px;
            height: 200px;
            left: -100px;
            bottom: -100px;
        }

        .medium {
            width: 400px;
            height: 400px;
            left: -200px;
            bottom: -200px;
        }

        .large {
            width: 600px;
            height: 600px;
            left: -300px;
            bottom: -300px;
        }

        .xlarge {
            width: 800px;
            height: 800px;
            left: -400px;
            bottom: -400px;
        }

        .xxlarge {
            width: 1000px;
            height: 1000px;
            left: -500px;
            bottom: -500px;
        }

        .shade1 {
            opacity: 0.2;
        }

        .shade2 {
            opacity: 0.5;
        }

        .shade3 {
            opacity: 0.7;
        }

        .shade4 {
            opacity: 0.8;
        }

        .shade5 {
            opacity: 0.9;
        }

        @keyframes ripple {
            0% {
                transform: scale(0.8);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(0.8);
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="ripple-background">
        <div class="circle xxlarge shade1"></div>
        <div class="circle xlarge shade2"></div>
        <div class="circle large shade3"></div>
        <div class="circle medium shade4"></div>
        <div class="circle small shade5"></div>
    </div>

    <div class="login-container">
        <h2 id="typing-header">Hey There!<br>Welcome Back.</h2>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Email" required>
            <?php if (!empty($email_error)) echo "<div class='error-message'>$email_error</div>"; ?>
            <input type="password" name="pass" placeholder="Password" required>
            <?php if (!empty($password_error)) echo "<div class='error-message'>$password_error</div>"; ?>
            <button type="submit" name="submit">Login</button>
        </form>
        <a href="#">Forgot Password?</a>
        <a href="signup.php">Don't have an account? Sign Up</a>
    </div>
</body>

</html>
