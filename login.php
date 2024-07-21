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
      background-color: #fff7e6; /* Light orange background */
    }

    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow effect */
      width: 300px;
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    .login-container h2 {
      margin-bottom: 20px;
      color: #333; /* Dark text color */
      overflow: hidden; /* Ensure the overflow is hidden */
      white-space: nowrap; /* Prevent the text from wrapping */
      animation: typing 3s steps(30, end), blink-caret 0.5s step-end infinite;
    }

    @keyframes typing {
      from { width: 0; }
      to { width: 100%; }
    }

    @keyframes blink-caret {
      from, to { border-color: transparent; }
      50% { border-color: #333; }
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 2px solid #ffa500; /* Orange border */
      border-radius: 5px;
      font-size: 16px;
    }

    .login-container button[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #ffa500; /* Orange background */
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      margin-top: 20px;
    }

    .login-container button[type="submit"]:hover {
      background-color: #e69500; /* Darker orange on hover */
    }

    .login-container a {
      display: block;
      margin-top: 10px;
      color: #ffa500; /* Orange text */
      text-decoration: none;
      font-size: 14px;
    }

    .login-container a:hover {
      color: #e69500; /* Darker orange on hover */
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
      box-shadow: 0 0 10px #ffa500; /* Orange glow effect */
    }
  </style>
</head>
<body>
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

  <?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  if(isset($_POST['submit'])){
      $email = $_POST['email'];
      $password = $_POST['pass'];
      $conn=mysqli_connect("localhost","root","","tourmentor");
      if(!$conn){
          die("connection failed");
      }
      $sql = "SELECT * FROM userreg WHERE email = '$email'";
      $result = mysqli_query($conn,$sql);
      if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);
          if(password_verify($password, $row['password'])){ 
              header("Location: index.php");
          }
          else{
              echo "<script>alert('Invalid password');</script>";
          }
      }
      else{
          echo "<script>alert('Invalid email');</script>";
      }
      mysqli_close($conn);
  }
  ?>
</body>
</html>
