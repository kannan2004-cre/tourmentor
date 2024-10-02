<?php
include('header.php');
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "tourmentor");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get booking ID from URL
$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Cancel the booking
if ($booking_id) {
    $sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $booking_id);
    if ($stmt->execute()) {
        $message = "Booking cancelled successfully.";
    } else {
        $message = "Error cancelling booking: " . $stmt->error;
    }
    $stmt->close();
} else {
    $message = "Invalid booking ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <style>
        body {
            background-color: #f9fbfd;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .cancel-container {
            width: 80%;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .cancel-container h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .cancel-container p {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }

        .cancel-container a {
            background-color: #cf1313;
            color: white;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .cancel-container a:hover {
            background-color: #ffa600;
            color: black;
        }
    </style>
</head>

<body>
    <div class="cancel-container">
        <h1>Cancellation Status</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="profile.php">Back to Profile</a>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>
