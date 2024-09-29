<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tourmentor';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get selected state, district, and attractions
$selectedState = isset($_POST['state']) ? $_POST['state'] : '';
$selectedDistrict = isset($_POST['district']) ? $_POST['district'] : '';
$selectedAttractions = isset($_POST['attractions']) ? $_POST['attractions'] : array();

if (empty($selectedAttractions)) {
    echo "<script>
        alert('No attractions selected, please select at least one.');
        setTimeout(function() {
            window.location.href = 'booking.html?state=" . urlencode($selectedState) . "&district=" . urlencode($selectedDistrict) . "';
        }, 100);
    </script>";
    exit();
}

// Build SQL query
$sql = "SELECT h.*, ha.attractions_info 
        FROM hotels h
        JOIN hotel_attractions ha ON h.id = ha.hotel_id";

// Add WHERE clause if attractions are selected
if (!empty($selectedAttractions)) {
    $sql .= " WHERE ";
    foreach ($selectedAttractions as $index => $attraction) {
        $attraction = mysqli_real_escape_string($conn, $attraction);
        $sql .= "ha.attractions_info LIKE '%$attraction%'";
        if ($index < count($selectedAttractions) - 1) {
            $sql .= " OR ";
        }
    }
}

$sql .= " ORDER BY h.price_per_night ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Results</title>
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

        .hotel-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .hotel-card:hover {
            transform: scale(1.02);
        }

        .hotel-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .hotel-content {
            padding: 20px;
        }

        .hotel-content h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #444;
        }

        .hotel-content p {
            margin: 10px 0;
            color: #666;
            font-size: 1rem;
        }

        .hotel-content h3 {
            margin-top: 15px;
            font-size: 1.2rem;
            color: #333;
        }

        .amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 10px 0;
        }

        .amenity {
            background-color: #e0f7fa;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 0.9rem;
            color: #00796b;
        }

        .attractions-list {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .attractions-list li {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 5px;
        }

        .price {
            font-weight: bold;
            color: #d32f2f;
            font-size: 1.2rem;
        }

        .rating {
            background-color: #4caf50;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            display: inline-block;
            margin-top: 10px;
        }

        .book-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2196f3;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            .hotel-card {
                margin-bottom: 30px;
            }
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>
    <div class="containe">
        <h1>Hotels Near Selected Attractions</h1>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<p>No hotels found near the selected attractions.</p>";
        } else {
            while ($hotel = mysqli_fetch_assoc($result)) {
                echo "<div class='hotel-card'>";
                if (!empty($hotel['picture_url'])) {
                    echo "<img src='" . htmlspecialchars($hotel['picture_url']) . "' alt='" . htmlspecialchars($hotel['name']) . "' class='hotel-image'>";
                } else {
                    echo "<img src='default-hotel.jpg' alt='No image available' class='hotel-image'>";
                }
                echo "<div class='hotel-content'>";
                echo "<h2>" . htmlspecialchars($hotel['name']) . "</h2>";
                echo "<p class='price'>₹" . htmlspecialchars($hotel['price_per_night']) . " per night</p>";
                echo "<div class='rating'>Rating: " . htmlspecialchars($hotel['rating']) . " / 5</div>";

                // Display hotel amenities (example amenities)
                echo "<div class='amenities'>";
                echo "<span class='amenity'>Free WiFi</span>";
                echo "<span class='amenity'>Pool</span>";
                echo "<span class='amenity'>Free Parking</span>";
                echo "<span class='amenity'>Breakfast Included</span>";
                echo "</div>";

                echo "<h3>Nearby Attractions:</h3>";
                echo "<ul class='attractions-list'>";
                $attractions = explode(',', $hotel['attractions_info']);
                for ($i = 0; $i < count($attractions); $i += 2) {
                    if (isset($attractions[$i]) && isset($attractions[$i + 1])) {
                        echo "<li>" . htmlspecialchars($attractions[$i]) . " - " . htmlspecialchars($attractions[$i + 1]) . " km</li>";
                    }
                }
                echo "</ul>";

                // Book Hotel button
                echo "<a href='book.php?hotel_id=" . urlencode($hotel['id']) . "' class='book-button'>Book Hotel</a>";

                echo "</div>";
                echo "</div>";
            }
        }

        mysqli_close($conn);
        ?>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
