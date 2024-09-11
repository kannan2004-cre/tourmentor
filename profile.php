<?php
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Get user information from session
$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$profile_pic = $_SESSION['user_profile_pic'];

// Define the directory where profile pictures are stored
$upload_dir = './uimages/';

// Check if the profile picture file exists
if (!empty($profile_pic) && file_exists($upload_dir . $profile_pic)) {
    $profile_pic_path = $upload_dir . $profile_pic;
} else {
    // Use a default image if the profile picture doesn't exist
    $profile_pic_path = './image/default_profile.png';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-color: white;
            font-family: Arial, sans-serif;
        }

        .containerr {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .containerr .img {
            height: 160px;
            width: 160px;
            border-radius: 50%;
            border: 2px solid #cf1313;
            margin-top: 250px;
            margin-left: 350px;
        }

        .nme {
            display: flex;
            align-items: center;
            margin-top: -160px;
        }

        .nme h2 {
            font-size: 25px;
            font-weight: bold;
            margin-left: 550px;
        }

        .nme p {
            font-size: 25px;
        }

        .Email {
            display: flex;
            align-items: center;
            margin-left: 550px;
        }

        .Email h2 {
            font-size: 25px;
            font-weight: bold;
        }

        .Email p {
            font-size: 25px;
        }

        .buttons {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-left: 550px;
            margin-bottom: 150px;
        }

        .buttons a {
            display: flex;
            text-decoration: none;
            height: 40px;
            width: 100px;
            background-color: #cf1313;
            border: 2px solid #cf1313;
            border-radius: 5px;
            justify-content: center;
            align-items: center;
            color: #ededed;
            font-size: 20px;
        }

        .buttons a:hover{
            background-color: #ffa600;
            border-color: #ffa600;
            color: black;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <div class="containerr">
        <div class="container-item">
            <img src="./image/<?php echo $profile_pic; ?>" alt="user-image" class="img">
            <div class="nme">
                <h2>Name:</h2>
                <p><?php echo $name; ?></p>
            </div>
            <div class="Email">
                <h2>Email:</h2>
                <p><?php echo $email; ?></p>
            </div>
            <div class="buttons">
                <a href="logout.php">Logout</a>
                <a href="#">Edit</a>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>