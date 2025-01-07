<?php
$name_error = $email_error = $password_error = "";
if (isset($_POST['submit'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['pass'];
	$conn = mysqli_connect("localhost", "root", "", "tourmentor");
	if (!$conn) {
		die("connection failed");
	}
	if(empty($name)){
		$name_error = "Please fill in your name.";
	}
	if(empty($email)){
		$email_error = "Please fill in your email.";
	} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$email_error = "Please enter a valid email.";
	}
	if(empty($password)){
		$password_error = "Please fill in your password.";
	} elseif (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[\W]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password)) {
		$password_error = "Password must be at least 8 characters long, include at least one number, one special character, one uppercase letter, and one lowercase letter.";
	}

	if(empty($name_error) && empty($email_error) && empty($password_error)){
		$hpass = password_hash($password, PASSWORD_DEFAULT);

		$filename = null;
		// Check if a file was uploaded
		if (!empty($_FILES["profilepic"]["name"])) {
			$filename = $_FILES["profilepic"]["name"];
			$tempname = $_FILES["profilepic"]["tmp_name"];
			$folder = "./uimages/" . $filename;

			// Move uploaded file
			if (!move_uploaded_file($tempname, $folder)) {
				echo "<script>alert('Failed to upload profile picture. Registration will continue without picture.');</script>";
				$filename = null;
			}
		}
		$sql = "SELECT * FROM userreg WHERE email = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$r = mysqli_fetch_assoc($result);
		if (!$r) {
			$sql = "INSERT INTO userreg (`name`, `email`, `password`, `filename`) VALUES (?, ?, ?, ?)";
			$stmt = mysqli_prepare($conn, $sql);
			mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hpass, $filename);

			if (mysqli_stmt_execute($stmt)) {
				echo "<script>alert('Registered successfully');</script>";
				echo "<script>window.location.href = 'login.php';</script>";
			} else {
				echo "<script>alert('OOPS! Registration failed. Error: " . mysqli_error($conn) . "');</script>";
				echo "<script>window.location.href = 'signup.php';</script>";
			}
			mysqli_stmt_close($stmt);
		}else{
			$email_error = "Email already exists. Please login or use a different email.";
		}
	}
	mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TourMentor - Signup</title>
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

		#content {
			background-color: #fff;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			/* Light shadow effect */
			width: 100%;
			max-width: 500px;
			text-align: center;
			animation: fadeIn 1s ease-in-out;
			box-sizing: border-box;
		}

		#content h2 {
			margin-bottom: 20px;
			color: #333;
			/* Dark text color */
		}

		.details {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			width: 100%;
		}

		.details .form-group {
			display: flex;
			flex-direction: column;
			width: 100%;
			margin-bottom: 10px;
		}

		.details label {
			margin-bottom: 5px;
			font-size: 14px;
			color: #333;
		}

		.details input[type="text"],
		.details input[type="email"],
		.details input[type="password"],
		.form-group input[type="file"] {
			padding: 8px;
			border: 2px solid #ffa500;
			/* Orange border */
			border-radius: 5px;
			font-size: 14px;
		}

		.error {
			color: red;
			font-size: 12px;
			margin-top: 5px;
		}

		.btn-primary {
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

		.btn-primary:hover {
			background-color: #e69500;
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

		.details input:focus,
		.form-group input:focus,
		.btn-primary:focus {
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
	<div id="content">
		<h2>Create an Account</h2>
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="details">
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" placeholder="Enter Name" required>
					<?php if (!empty($name_error)) echo '<div class="error">' . $name_error . '</div>'; ?>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" placeholder="Enter Email" required>
					<?php if (!empty($email_error)) echo '<div class="error">' . $email_error . '</div>'; ?>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" id="password" name="pass" placeholder="Enter Password" required>
					<?php if (!empty($password_error)) echo '<div class="error">' . $password_error . '</div>'; ?>
				</div>
				<div class="form-group">
					<label for="profilepic">Profile Picture:</label>
					<input type="file" id="profilepic" name="profilepic" value="">
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="submit">SIGNUP</button>
			</div>
			<a href="login.php">Already have an account? Login</a>
		</form>
	</div>
		</div>
</body>

</html>