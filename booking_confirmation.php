<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tourmentor';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch the latest booking details (assuming booking ID or other identifiers are passed)
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking details from the database
$booking_query = "SELECT b.*, h.name as hotel_name, r.name as room_name
                  FROM bookings b
                  JOIN hotels h ON b.hotel_id = h.id
                  JOIN room_types r ON b.room_type_id = r.id
                  WHERE b.id = $booking_id";
$booking_result = mysqli_query($conn, $booking_query);
$booking = mysqli_fetch_assoc($booking_result);

if (!$booking) {
    echo "Booking not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            margin-top: 80px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .confirmation-box {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            font-size: 18px;
            color: #666;
        }
        .details span {
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Booking Confirmation</h1>
        <div class="confirmation-box">
            <h2>Thank you for your booking, <?php echo htmlspecialchars($booking['guest_name']); ?>!</h2>
            <div class="details">
                <p>Hotel: <span><?php echo htmlspecialchars($booking['hotel_name']); ?></span></p>
                <p>Room Type: <span><?php echo htmlspecialchars($booking['room_name']); ?></span></p>
                <p>Check-in Date: <span><?php echo htmlspecialchars($booking['check_in']); ?></span></p>
                <p>Check-out Date: <span><?php echo htmlspecialchars($booking['check_out']); ?></span></p>
            </div>
            <p>Your booking has been confirmed. We look forward to hosting you!</p>
            <button><a href="profile.php">Check on profile</a></button>
        </div>
    </div>
</body>
</html>
