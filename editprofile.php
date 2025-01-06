<?php
// Start the session at the top of the file
session_start();
include('header.php');

// Function to safely output debug information
function debug_to_console($data)
{
    $output = $data;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('" . addslashes($output) . "');</script>";
}

$email_error = $name_error = $profile_pic_error = ""; // Initialize error messages

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "<script>alert('You must log in to access this page.');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

// Fetch user details
$conn = mysqli_connect("localhost", "root", "", "tourmentor");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['user_email'];
$sql = "SELECT * FROM userreg WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    echo "<script>alert('User not found.');</script>";
    exit();
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $new_email = $_POST['email'];
    $profile_pic = $_FILES['profilepic']['name'];

    // Validate inputs
    if (empty($name)) {
        $name_error = "Name cannot be empty.";
    }

    if (empty($new_email)) {
        $email_error = "Email cannot be empty.";
    }
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format.";
    }

    // Handle profile picture upload
    if (!empty($profile_pic)) {
        $tempname = $_FILES['profilepic']['tmp_name'];
        $folder = "./uimages/" . $profile_pic;

        if (!move_uploaded_file($tempname, $folder)) {
            $profile_pic_error = "Failed to upload profile picture.";
        }
    } else {
        $profile_pic = $user_data['filename']; // Keep existing picture if no new one is uploaded
    }

    // Update user details if no errors
    if (empty($name_error) && empty($email_error) && empty($profile_pic_error)) {
        $sql = "UPDATE userreg SET name = ?, email = ?, filename = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $new_email, $profile_pic, $email);
        if (mysqli_stmt_execute($stmt)) {
            // Update session variables
            $_SESSION['user_email'] = $new_email;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_profile_pic'] = $profile_pic;

            echo "<script>alert('Profile updated successfully!');</script>";
            echo "<script>window.location.href = 'profile.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating profile.');</script>";
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
    <title>Edit Profile - TourMentor</title>
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

        .profile-edit-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgb(126, 126, 143);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }

        .profile-edit-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .profile-edit-container input[type="text"],
        .profile-edit-container input[type="email"],
        .profile-edit-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ffa500;
            border-radius: 5px;
            font-size: 16px;
        }

        .profile-edit-container .error-message {
            color: red;
            font-size: 12px;
            text-align: left;
            margin: 5px 0;
        }

        .profile-edit-container button[type="submit"] {
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

        .profile-edit-container button[type="submit"]:hover {
            background-color: #e69500;
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

        .profile-edit-container input:focus,
        .profile-edit-container button:focus {
            outline: none;
            box-shadow: 0 0 10px #ffa500;
        }
    </style>
</head>

<body>
    <div class="profile-edit-container">
        <h2>Edit Profile</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Name" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
            <?php if (!empty($name_error)) echo "<div class='error-message'>$name_error</div>"; ?>
            <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
            <?php if (!empty($email_error)) echo "<div class='error-message'>$email_error</div>"; ?>
            <input type="file" name="profilepic">
            <?php if (!empty($profile_pic_error)) echo "<div class='error-message'>$profile_pic_error</div>"; ?>
            <button type="submit" name="update">Update Profile</button>
        </form>
    </div>
</body>
</html>
