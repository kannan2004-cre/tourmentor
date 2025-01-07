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

// Generate random text for confirmation and store it in session
if (!isset($_SESSION['random_text'])) {
    $_SESSION['random_text'] = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 6);
}
$random_text = $_SESSION['random_text'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_input = $_POST['confirmation_text'] ?? '';

    // Cancel the booking if the confirmation text matches
    if ($booking_id && $user_input === $random_text) {
        $sql = "DELETE FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $booking_id);
        if ($stmt->execute()) {
            $message = "Booking cancelled successfully.";
            unset($_SESSION['random_text']); // Clear the random text after successful cancellation
        } else {
            $message = "Error cancelling booking: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Invalid confirmation text.";
    }
} else {
    $message = "Please confirm the cancellation.";
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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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

        .cancel-container a{
            width: 300px;
            height: 40px;
        }

        .cancel-container a , button {
            background-color: #cf1313;
            border: 1px solid #cf1313;
            color: white;
            margin-top: 10px;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .cancel-container a:hover , button:hover{
            transition: 0.3s ease-in-out;
            background-color: #ffa600;
            color: black;
        }
    </style>
    <script>
        function confirmCancellation() {
            var userInput = prompt("Please enter the following text to confirm cancellation: <?php echo $random_text; ?>");
            if (userInput !== null) {
                document.getElementById('confirmation_text').value = userInput;
                document.getElementById('cancelForm').submit();
            }
        }
    </script>
</head>

<body>
    <div class="cancel-container">
        <h1>Cancellation Status</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <form id="cancelForm" method="post">
            <input type="hidden" id="confirmation_text" name="confirmation_text">
            <button type="button" onclick="confirmCancellation()">Confirm Cancellation</button>
        </form>
        <a href="profile.php">Back to Profile</a>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>
