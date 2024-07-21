<?php
error_reporting(0);

$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

	$filename = $_FILES["uploadfile"]["name"];
	$tempname = $_FILES["uploadfile"]["tmp_name"];
	$folder = "./image/" . $filename;

	$db = mysqli_connect("localhost", "root", "", "tourmentor");

	// Get all the submitted data from the form
	$location = $_POST['location'];
	$destination = $_POST['destination'];
	$description = $_POST['description'];
	$price = $_POST['price'];
	$food = $_POST['food'];
	$transport = $_POST['transport'];

	$sql = "INSERT INTO image (`filename`, `location`,`destination`, `description`, `price`, `food`, `transport`) VALUES ('$filename', '$location','$destination', '$description', '$price', '$food', '$transport')";

	// Execute query
	mysqli_query($db, $sql);

	// Check for file upload errors
	if ($_FILES["uploadfile"]["error"] > 0) {
		$msg = "upload failed with error code: " . $_FILES["uploadfile"]["error"];
	} else {
		// Move the uploaded image into the folder: image
		if (move_uploaded_file($tempname, $folder)) {
			$msg = "uploaded successfully!";
		} else {
			$msg = "Failed to upload!";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Image Upload</title>
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

		.details input[type="text"],
		.details select {
			width: 100%;
			padding: 8px;
			margin: 8px 0;
			border: 2px solid #ffa500; /* Orange border */
			border-radius: 5px;
			font-size: 14px;
			box-sizing: border-box;
		}

		.form-group input[type="file"] {
			width: 100%;
			padding: 8px;
			margin: 8px 0;
			border: 2px solid #ffa500; /* Orange border */
			border-radius: 5px;
			font-size: 14px;
			box-sizing: border-box;
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
		.details select:focus,
		.form-group input:focus,
		.btn-primary:focus {
			outline: none;
			box-shadow: 0 0 10px #ffa500; /* Orange glow effect */
		}
	</style>
</head>

<body>
	<div id="content">
		<h2>Upload Your Image</h2>
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="details">
				Location:<input type="text" name="location" placeholder="Enter Location" required>
				<br>
				Destination:<input type="text" name="destination" placeholder="Enter Destination" required>
				<br>
				Description:<input type="text" name="description" placeholder="Enter Description" required>
				<br>
				Price:<input type="text" name="price" placeholder="Enter Price" required>
				<br>
				Food:<select name="food" required>
					<option value="" disabled selected>Select food</option>
					<option value="vegetarian">Vegetarian</option>
					<option value="non-vegetarian">Non-vegetarian</option>
					<option value="local">Local cuisine</option>
					<option value="traditional">Traditional cuisine</option>
					<option value="all">All foods</option>
				</select>
				<br>
				Transport:<select name="transport" required>
					<option value="" disabled selected>Select Transportation</option>
					<option value="bus">Bus</option>
					<option value="train">Train</option>
					<option value="car">Car</option>
					<option value="flight">Flight</option>
					<option value="all">All transport</option>
				</select>
				<br>
			</div>
			<div class="form-group">
				<input class="form-control" type="file" name="uploadfile" value="" required />
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
			</div>
		</form>
		<?php echo "<h3>$msg</h3>"; ?> <!-- Display upload status message -->
	</div>
</body>

</html>
