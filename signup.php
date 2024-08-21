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
			background-color: #fff7e6; /* Light orange background */
		}

		#content {
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Light shadow effect */
			width: 100%;
			max-width: 500px;
			text-align: center;
			animation: fadeIn 1s ease-in-out;
			box-sizing: border-box;
		}

		#content h2 {
			margin-bottom: 20px;
			color: #333; /* Dark text color */
		}

		.details {
			display: flex;
			flex-direction: column;
			align-items: flex-start;
			width: 100%;
		}

		.details .form-group {
			display: flex;
			align-items: center;
			width: 100%;
			margin-bottom: 10px;
		}

		.details label {
			width: 100px;
			margin-right: 10px;
			font-size: 14px;
			color: #333;
		}

		.details input[type="text"],
		.details input[type="email"],
		.details input[type="password"],
		.form-group input[type="file"] {
			flex-grow: 1;
			padding: 8px;
			border: 2px solid #ffa500; /* Orange border */
			border-radius: 5px;
			font-size: 14px;
		}

		.btn-primary {
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

		.btn-primary:hover {
			background-color: #e69500; /* Darker orange on hover */
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
			box-shadow: 0 0 10px #ffa500; /* Orange glow effect */
		}
	</style>
</head>

<body>
	<?php include('header.php');?>
	<div id="content">
		<h2>Create an Account</h2>
		<form method="POST" action="register.php" enctype="multipart/form-data">
			<div class="details">
				<div class="form-group">
					<label for="name">Name:</label>
					<input type="text" id="name" name="name" placeholder="Enter Name" required>
				</div>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" placeholder="Enter Email" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" id="password" name="pass" placeholder="Enter Password" required>
				</div>
				<div class="form-group">
					<label for="profilepic">Profile Picture:</label>
					<input type="file" id="profilepic" name="profilepic" value="" required />
				</div>
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="submit">SIGNUP</button>
			</div>
      <a href="login.php">Already have an account? Login</a>
		</form>
	</div
	</div>
</body>

</html>