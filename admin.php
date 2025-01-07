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
            font-size: 3rem;
            margin-top: 2rem;
        }

        p {
            font-size: 1.5rem;
            text-align: center;
        }

        button {
            color: white;
            margin: 0.5rem;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }

        button:hover {
            background-color: rgb(7, 18, 28);
            color: rgb(247, 243, 243);
        }

        .admin-panel {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin: 2rem;
            gap: 0.5rem;
        }

        .admin-panel a {
            text-decoration: none;
            color: aliceblue;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
            padding: 1rem;
        }

        .navbar a {
            text-decoration: none;
            color: aliceblue;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
                margin-top: 1rem;
            }

            p {
                font-size: 1rem;
            }

            button {
                font-size: 0.875rem;
                padding: 0.5rem;
            }

            .admin-panel {
                flex-direction: column;
            }
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
        <button class="upload"><a href="upload.php">Upload</a></button>
        <button class="hotel"><a href="hotelinsert.php">Insert Hotels</a></button>
        <button class="update"><a href="update.php">Update</a></button>
        <button class="view"><a href="view.php">View</a></button>
        <button class="logout"><a href="adlogout.php">Logout</a></button>
    </div>
</body>

</html>