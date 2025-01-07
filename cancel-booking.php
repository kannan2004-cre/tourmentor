<?php
include('header.php');

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
            width: 90%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 40px auto;
            padding: 60px;
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
            width: 100%;
            max-width: 300px;
            height: 40px;
        }

        .cancel-container a, .cancel-container button {
            background-color: #cf1313;
            border: 1px solid #cf1313;
            color: white;
            margin-top: 10px;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
        }

        .cancel-container a:hover, .cancel-container button:hover {
            transition: 0.3s ease-in-out;
            background-color: #ffa600;
            color: black;
        }

        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        .popup-content input {
            margin-top: 10px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .popup-content button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #cf1313;
            border: none;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        .popup-content button:hover {
            background-color: #ffa600;
            color: black;
        }

        @media (max-width: 768px) {
            .cancel-container {
                width: 85%;
                padding: 35px;
            }

            .cancel-container h1 {
                font-size: 24px;
            }

            .cancel-container p {
                font-size: 16px;
            }

            .cancel-container a, .cancel-container button {
                font-size: 14px;
                padding: 8px 12px;
            }

            .popup-content {
                padding: 15px;
            }

            .popup-content button {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
    <script>
        function confirmCancellation() {
            document.getElementById('popup').style.display = 'flex';
        }

        function submitCancellation() {
            var userInput = document.getElementById('popupInput').value;
            if (userInput !== '') {
                document.getElementById('confirmation_text').value = userInput;
                document.getElementById('cancelForm').submit();
            }
        }

        // Close popup when clicking outside of the popup content
        window.onclick = function(event) {
            var popup = document.getElementById('popup');
            if (event.target == popup) {
                popup.style.display = 'none';
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

    <div id="popup" class="popup">
        <div class="popup-content">
            <p>Please enter the following text to confirm cancellation: <?php echo $random_text; ?></p>
            <input type="text" id="popupInput">
            <button type="button" onclick="submitCancellation()">Submit</button>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>
