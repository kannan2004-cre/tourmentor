<?php
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['pass'];

  // Password validation
  if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) /* || !preg_match("/[\W]/", $password) */) {
    echo "<script>alert('Password must be at least 8 characters long and include at least one number.');</script>";
  } else {
    $conn = mysqli_connect("localhost", "root", "", "tourmentor");
    if (!$conn) {
      die("connection failed");
    }

    $sql = "SELECT * FROM userreg WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
      if (password_verify($password, $row['password'])) {
        echo "<script>alert('Welcome to Tourmentor!');</script>";
        header("Location: index.php");
        exit();
      } else {
        echo "<script>alert('Invalid password');</script>";
      }
    } else {
      echo "<script>alert('Invalid email');</script>";
    }

    mysqli_close($conn);
  }
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
      /* Light orange background */
    }

    .login-container {
      background-color: #fff;
      margin-top: 50px;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgb(126, 126, 143);
      /* Light shadow effect */
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
      /* Orange border */
      border-radius: 5px;
      font-size: 16px;
    }

    .login-container button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #ffa500;
      /* Orange background */
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-top: 20px;
    }

    .login-container button[type="submit"]:hover {
      background-color: #e69500;
      /* Darker orange on hover */
    }

    .login-container a {
      display: block;
      margin-top: 10px;
      color: black;
      /* Orange text */
      text-decoration: none;
      font-size: 14px;
    }

    .login-container a:hover {
      color: grey;
      /* Darker orange on hover */
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
      /* Orange glow effect */
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
      <input type="password" name="pass" placeholder="Password" required>
      <button type="submit" name="submit">Login</button>
    </form>
    <a href="#">Forgot Password?</a>
    <a href="signup.php">Don't have an account?Sign Up</a>
  </div>
</body>

</html>