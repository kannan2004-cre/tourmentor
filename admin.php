<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // If not logged in, redirect to admin login page
    echo "Not logged in. Redirecting...";
    header("Location: adlogin.php");
    exit();
}

// Strengthen the login process by using hashed passwords and secure session management
function verifyAdminCredentials($email, $password) {
    // Admin credentials are hardcoded for simplicity
    $stored_hashed_password = password_hash('Admin2024#', PASSWORD_DEFAULT);
    $stored_email = 'admin2024@gmail.com';

    // Verify email and password
    if ($email === $stored_email && password_verify($password, $stored_hashed_password)) {
        return true;
    }
    return false;
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (verifyAdminCredentials($email, $password)) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        echo "Invalid credentials. Please try again.";
    }
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
        body {
            background-color: #2c3e50;
            color: #ecf0f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: #ecf0f1;
            font-size: 3.5rem;
            margin-top: 2.5rem;
        }

        p {
            font-size: 1.25rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        button {
            background-color: #3498db;
            color: white;
            margin: 0.5rem;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .admin-panel {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin: 2rem;
            gap: 1rem;
        }

        .admin-panel a {
            text-decoration: none;
            color: white;
        }

        .navbar {
            display: flex;
            justify-content: flex-end;
            padding: 1rem;
            background-color: #34495e;
        }

        .navbar a {
            text-decoration: none;
            color: #ecf0f1;
        }

        footer {
            background-color: #34495e;
            color: #ecf0f1;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2.5rem;
                margin-top: 1.5rem;
            }

            p {
                font-size: 1rem;
            }

            button {
                font-size: 0.875rem;
                padding: 0.5rem 1rem;
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
        <button class="delete_event"><a href="even_delete.php">Delete Events</a></button>
        <button class="add_event"><a href="addevents.php">Add Events</a></button>
        <button class="logout"><a href="adlogout.php">Logout</a></button>
    </div>
    <footer>
        <p>&copy; 2023 TourMentor Admin Panel. All rights reserved.</p>
    </footer>
</body>

</html>