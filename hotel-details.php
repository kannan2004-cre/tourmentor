<?php
// Include database connection
include 'conn.php'; // Adjust the path as necessary

// Get the hotel ID from the URL (e.g., hotel-details.php?id=1)
if (isset($_GET['id'])) {
    $hotel_id = (int)$_GET['id'];
} else {
    echo "<h2>Invalid hotel ID.</h2>";
    exit();
}

// Prepare and execute SQL query to fetch hotel details
$sql = "SELECT h.id, h.name AS hotel_name, h.address, h.price_per_night, h.rating, h.picture_url,
               rt.name AS room_type, rt.price_per_night AS room_price, rt.capacity, rt.description,
               ha.attractions_info
        FROM hotels h
        LEFT JOIN room_types rt ON h.id = rt.hotel_id
        LEFT JOIN hotel_attractions ha ON h.id = ha.hotel_id
        WHERE h.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $hotel_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the hotel exists
if ($result->num_rows === 0) {
    echo "<h2>Hotel not found.</h2>";
    exit();
}

// Fetch hotel details
$hotel = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($hotel['hotel_name']); ?> - Details</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            /* Light background */
            color: #343a40;
            /* Dark text */
            line-height: 1.6;
        }

        /* Hotel Details Container */
        .hotel-details {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            /* White background for content */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Hotel Title */
        .hotel-details h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
            color: #007bff;
            /* Primary color for titles */
        }

        /* Image styling */
        .hotel-image {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Text styling */
        .hotel-details p {
            margin-bottom: 15px;
        }

        /* Room Types Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #dee2e6;
            /* Light gray border */
        }

        th {
            background-color: #007bff;
            /* Blue background for headers */
            color: white;
        }

        /* Form styling */
        form {
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #dee2e6;
            /* Light gray border */
            border-radius: 8px;
            background-color: #f8f9fa;
            /* Light background for form */
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            /* Light gray border */
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            /* Blue background */
            color: white;
            /* White text */
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hotel-details {
                padding: 10px;
            }

            .hotel-details h1 {
                font-size: 2em;
            }

            button {
                width: 100%;
                /* Full width button on small screens */
            }
        }
    </style>
</head>

<body>

    <div class="hotel-details">
        <h1><?php echo htmlspecialchars($hotel['hotel_name']); ?></h1>
        <img src="<?php echo htmlspecialchars($hotel['picture_url']); ?>" alt="<?php echo htmlspecialchars($hotel['hotel_name']); ?>" class="hotel-image">
        <p><strong>Address:</strong> <?php echo htmlspecialchars($hotel['address']); ?></p>
        <p><strong>Price per Night:</strong> $<?php echo number_format($hotel['price_per_night'], 2); ?></p>
        <p><strong>Rating:</strong> <?php echo htmlspecialchars($hotel['rating']); ?> / 5.0</p>

        <h2>Room Types</h2>
        <table>
            <tr>
                <th>Room Type</th>
                <th>Price per Night</th>
                <th>Capacity</th>
                <th>Description</th>
            </tr>
            <?php
            // Reset the result pointer to fetch room types
            $result->data_seek(0); // Reset pointer to fetch room types again
            while ($room = $result->fetch_assoc()) {
                if (!empty($room['room_type'])) { // Check if room type exists
                    echo "<tr>
                        <td>" . htmlspecialchars($room['room_type']) . "</td>
                        <td>$" . number_format($room['room_price'], 2) . "</td>
                        <td>" . htmlspecialchars($room['capacity']) . "</td>
                        <td>" . htmlspecialchars($room['description']) . "</td>
                    </tr>";
                }
            }
            ?>
        </table>

        <h2>Attractions</h2>
        <p><?php echo htmlspecialchars($hotel['attractions_info']); ?></p>

        <h2>Booking</h2>
        <form action="book.php" method="POST">
            <input type="hidden" name="hotel_id" value="<?php echo $hotel['id']; ?>">
            <label for="guest_name">Guest Name:</label>
            <input type="text" id="guest_name" name="guest_name" required>
            <label for="check_in">Check-in Date:</label>
            <input type="date" id="check_in" name="check_in" required>
            <label for="check_out">Check-out Date:</label>
            <input type="date" id="check_out" name="check_out" required>
            <label for="room_type_id">Select Room Type:</label>
            <select id="room_type_id" name="room_type_id" required>
                <?php
                // Reset the result pointer to fetch room types again
                $result->data_seek(0);
                while ($room = $result->fetch_assoc()) {
                    if (!empty($room['room_type'])) {
                        echo "<option value='" . htmlspecialchars($room['room_type_id']) . "'>" . htmlspecialchars($room['room_type']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Book Now</button>
        </form>
    </div>

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>