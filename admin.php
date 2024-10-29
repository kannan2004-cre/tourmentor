<?php
session_start();


// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to admin login page
    echo "Not logged in. Redirecting...";
    header("Location: adlogin.php");
    exit();
}

// Rest of your HTML code follows...
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <style>
        h1 {
            text-align: center;
            color: antiquewhite;
            font-size: 50px;
            margin-top: 100px;
        }

        p {
            font-size: 30px;
            text-align: center;
        }

        button {
            color: white;
            margin: 10px;
            border-radius: 10px;
        }

        button:hover {
            background-color: rgb(7, 18, 28);
            color: rgb(247, 243, 243);
        }

        .admin-panel {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 50px;
            gap: 10px;
        }

        .admin-panel a {
            text-decoration: none;
            color: aliceblue;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
        }

        .navbar a {
            text-decoration: none;
            color: aliceblue;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <ul>
            <button><a href="index.php">Back to home</a></button>
        </ul>
    </div>
    <h1>Admin Panel</h1>
    <p>Welcome to the admin panel!</p>
    <div class="admin-panel">
        <button class="upload"><a href="upload.php">Upload</a></button><br>
        <button class="hotel"><a href="hotelinsert.php">Insert Hotels</a></button>
        <button class="update"><a href="update.php">Update</a></button><br>
        <button class="view"><a href="view.php">View</a></button><br>
        <button class="logout"><a href="adlogout.php">Logout</a></button>
    </div>
</body>

</html>