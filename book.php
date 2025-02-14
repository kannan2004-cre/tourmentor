<?php
session_start();
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tourmentor';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get hotel ID from URL
$hotel_id = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;

// Fetch hotel details
$hotel_query = "SELECT * FROM hotels WHERE id = $hotel_id";
$hotel_result = mysqli_query($conn, $hotel_query);
$hotel = mysqli_fetch_assoc($hotel_result);

// Fetch room types for this hotel
$room_query = "SELECT * FROM room_types WHERE hotel_id = $hotel_id";
$room_result = mysqli_query($conn, $room_query);

$card_number_error = $card_expiry_error = $card_cvv_error = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process booking (in a real application, you'd want to validate inputs and handle payments securely)
    $room_type_id = $_POST['room_type'];
    $check_in = $_POST['check_in'];
    $email = $_SESSION['user_email'];
    $check_out = $_POST['check_out'];
    $guest_name = $_POST['guest_name'];
    $card_number = $_POST['card_number'];
    $card_expiry = $_POST['card_expiry'];
    $card_cvv = $_POST['card_cvv'];

    // Validate card number
    if (!preg_match('/^\d{4} \d{4} \d{4} \d{4}$/', $card_number)) {
        $card_number_error = "Invalid card number. Please enter a valid 16 digit card number with spaces after every 4 digits.";
    }

    // Validate card expiry
    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $card_expiry)) {
        $card_expiry_error = "Invalid card expiry date. Please enter a valid expiry date in MM/YY format.";
    } else {
        $currentYear = date('y');
        $currentMonth = date('m');
        list($expMonth, $expYear) = explode('/', $card_expiry);
        if ($expYear < $currentYear || ($expYear == $currentYear && $expMonth < $currentMonth)) {
            $card_expiry_error = "Card expiry date cannot be in the past.";
        }
    }

    // Validate CVV
    if (!preg_match('/^\d{3,4}$/', $card_cvv)) {
        $card_cvv_error = "Invalid CVV. Please enter a valid 3 or 4 digit CVV.";
    }

    if (empty($card_number_error) && empty($card_expiry_error) && empty($card_cvv_error)) {
        // Fetch the price for the selected room type
        $price_query = "SELECT price_per_night FROM room_types WHERE id = $room_type_id";
        $price_result = mysqli_query($conn, $price_query);
        $price_row = mysqli_fetch_assoc($price_result);
        $price_per_night = $price_row['price_per_night'];

        // Calculate total price 
        $check_in_date = new DateTime($check_in);
        $check_out_date = new DateTime($check_out);
        $nights = $check_out_date->diff($check_in_date)->days;
        $total_price = $price_per_night * $nights;

        // Insert booking into database 
        $booking_query = "INSERT INTO bookings (hotel_id, room_type_id, guest_name, check_in, check_out, total_price, email) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $booking_query);
        mysqli_stmt_bind_param($stmt, 'iisssds', $hotel_id, $room_type_id, $guest_name, $check_in, $check_out, $total_price, $email);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Booking successful!'); window.location.href = 'booking_confirmation.php?booking_id=" . mysqli_insert_id($conn) . "';</script>";
            exit;
        } else {
            echo "<script>alert('Booking failed. Please try again.');</script>";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel Room</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .containe {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            margin-top: 80px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .booking-form {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .submit-btn {
            background-color: #2196f3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: #1976d2;
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="containe">
        <h1>Book a Room at <?php echo htmlspecialchars($hotel['name']); ?></h1>
        <div class="booking-form">
            <form method="post">
                <div class="form-group">
                    <label for="room_type">Room Type:</label>
                    <select name="room_type" id="room_type" required>
                        <?php while ($room = mysqli_fetch_assoc($room_result)) : ?>
                            <option value="<?php echo $room['id']; ?>">
                                <?php echo htmlspecialchars($room['name']) . ' - ₹' . htmlspecialchars($room['price_per_night']); ?> per night
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="check_in">Check-in Date:</label>
                    <input type="date" id="check_in" name="check_in" required>
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date:</label>
                    <input type="date" id="check_out" name="check_out" required>
                </div>
                <div class="form-group">
                    <label for="guest_name">Guest Name:<br></label>
                    <input type="text" id="guest_name" name="guest_name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                </div>

                <div class="form-group">
                    <label for="guest_email">Guest Email:</label>
                    <input type="hidden" id="guestemail" name="guestemail" value="<?php echo htmlspecialchars($_SESSION['user_email']); ?>">
                    <p><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                </div>
                <div class="form-group">
                    <label for="card_number">Card Number:</label>
                    <input type="text" id="card_number" name="card_number" required pattern="\d{4} \d{4} \d{4} \d{4}" title="Please enter a valid 16 digit card number with spaces after every 4 digits" oninput="this.value=this.value.replace(/\s+/g, ' ').replace(/(\d{4})/g, '$1 ').trim().replace(/\s{2,}/g, ' ');">
                    <?php if (!empty($card_number_error)) echo "<div class='error-message'>$card_number_error</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="card_expiry">Card Expiry (MM/YY):</label>
                    <input type="text" id="card_expiry" name="card_expiry" placeholder="MM/YY" required pattern="(0[1-9]|1[0-2])\/\d{2}" title="Please enter a valid expiry date in MM/YY format">
                    <?php if (!empty($card_expiry_error)) echo "<div class='error-message'>$card_expiry_error</div>"; ?>
                </div>
                <div class="form-group">
                    <label for="card_cvv">CVV:</label>
                    <input type="text" id="card_cvv" name="card_cvv" required pattern="\d{3,4}" title="Please enter a valid 3 or 4 digit CVV">
                    <?php if (!empty($card_cvv_error)) echo "<div class='error-message'>$card_cvv_error</div>"; ?>
                </div>
                <input type="submit" value="Pay and Book" class="submit-btn">
            </form>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>