<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourmentor - Find Your Perfect Destination</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: #FF8C00;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-bottom: 20px;
        }

        header h1 {
            margin-top: 150px;
            margin-bottom: 10px;
        }

        .search-form {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        select,
        button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background-color: #FF8C00;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e67e00;
        }

        .search-results,
        .hotel-results {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .search-item,
        .hotel-item {
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
            display: flex;
        }

        .search-item:last-child,
        .hotel-item:last-child {
            border-bottom: none;
        }

        .search-item-image,
        .hotel-item-image {
            flex: 0 0 200px;
            margin-right: 20px;
        }

        .search-item-image img,
        .hotel-item-image img {
            width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .search-item-content,
        .hotel-item-content {
            flex: 1;
        }

        .search-item h2,
        .hotel-item h2 {
            margin-bottom: 10px;
            color: #FF8C00;
        }

        .search-item p,
        .hotel-item p {
            margin-bottom: 5px;
        }

        .search-item .price,
        .hotel-item .price {
            font-weight: bold;
            font-size: 18px;
            color: #FF8C00;
            margin-top: 10px;
        }

        .search-item .hotel-link,
        .hotel-item .book-link {
            display: inline-block;
            background-color: #FF8C00;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        .search-item .hotel-link:hover,
        .hotel-item .book-link:hover {
            background-color: #e67e00;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .search-form {
                padding: 15px;
            }

            .search-item,
            .hotel-item {
                flex-direction: column;
            }

            .search-item-image,
            .hotel-item-image {
                flex: 0 0 auto;
                margin-right: 0;
                margin-bottom: 15px;
            }
        }

        .events-popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            max-width: 80%;
            max-height: 80%;
            overflow-y: auto;
        }

        .events-popup h3 {
            margin-bottom: 10px;
            color: #FF8C00;
        }

        .event-item {
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .event-item:last-child {
            border-bottom: none;
        }

        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    <header>
        <h1>Tourmentor</h1>
        <p>Find Your Perfect Destination</p>
    </header>

    <div class="container">
        <form class="search-form" method="POST" action="">
            <div class="form-group">
                <label for="destination">Where do you want to go?</label>
                <input type="text" id="destination" name="query" placeholder="Enter your destination">
            </div>
            <div class="form-group">
                <button type="submit" name="search">Search</button>
            </div>
        </form>


        <div class="search-results">
            <?php
            if (isset($_POST['search'])) {
                $query = $_POST['query'];

                $db = mysqli_connect("localhost", "root", "", "tourmentor");

                // Modified SQL query to avoid duplicates
                $sql = "SELECT DISTINCT * FROM destinations WHERE location LIKE '%$query%' OR destination LIKE '%$query%' OR description LIKE '%$query%' OR price LIKE '%$query%' OR district LIKE '%$query%' OR state LIKE '%$query%'";
                $result = mysqli_query($db, $sql);

                $events = array();
                $displayed_destinations = array();

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Check if this destination has already been displayed
                        if (!in_array($row['destination'], $displayed_destinations)) {
                            echo "<div class='search-item'>";
                            echo "<div class='search-item-image'><img src='./image/" . $row['filename'] . "' alt='" . $row['destination'] . "'></div>";
                            echo "<div class='search-item-content'>";
                            echo "<h2>" . $row['destination'] . "</h2>";
                            echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                            echo "<p>" . $row['description'] . "</p>";
                            echo "<p class='price'>Price: " . $row['price'] . "</p>";
                            echo "<a href='?view_hotels=1&district=" . urlencode($row['district']) . "&state=" . urlencode($row['state']) . "' class='hotel-link'>View Hotels</a>";
                            echo "</div>";
                            echo "</div>";

                            // Add this destination to the displayed list
                            $displayed_destinations[] = $row['destination'];

                            // Fetch events for this location
                            $events_sql = "SELECT DISTINCT * FROM events WHERE location LIKE '%" . $row['district'] . "%' OR location LIKE '%" . $row['state'] . "%'";
                            $events_result = mysqli_query($db, $events_sql);

                            while ($event = mysqli_fetch_assoc($events_result)) {
                                // Use event ID as key to avoid duplicates
                                $events[$event['id']] = $event;
                            }
                        }
                    }
                } else {
                    echo "<p>No results found.</p>";
                }

                mysqli_close($db);

                // Create events pop-up
                if (!empty($events)) {
                    echo "<div id='events-popup' class='events-popup'>";
                    echo "<span class='close-popup' onclick='closeEvents()'>&times;</span>";
                    echo "<h3>Local Events in " . htmlspecialchars($query) . "</h3>";

                    foreach ($events as $event) {
                        echo "<div class='event-item'>";
                        echo "<h4>" . htmlspecialchars($event['event_name']) . "</h4>";
                        echo "<p>" . htmlspecialchars($event['event_description']) . "</p>";
                        echo "<p>From: " . $event['event_start_date'] . " To: " . $event['event_end_date'] . "</p>";
                        echo "<p>Location: " . htmlspecialchars($event['location']) . "</p>";
                        if (!empty($event['event_url'])) {
                            echo "<a href='" . htmlspecialchars($event['event_url']) . "' target='_blank'>More Info</a>";
                        }
                        echo "</div>";
                    }

                    echo "</div>";

                    // JavaScript to show the pop-up
                    echo "<script>document.addEventListener('DOMContentLoaded', function() { document.getElementById('events-popup').style.display = 'block'; });</script>";
                }
            }
            ?>
        </div>

        <div class="hotel-results">
            <?php
            if (isset($_GET['view_hotels'])) {
                $district = $_GET['district'];
                $state = $_GET['state'];
                $db = mysqli_connect("localhost", "root", "", "tourmentor");

                $sql = "SELECT * FROM hotels WHERE address LIKE '%$district%' OR address LIKE '%$state%' OR address LIKE '%location%' OR address LIKE '%destination%'";
                $result = mysqli_query($db, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='hotel-item'>";
                        echo "<div class='hotel-item-image'><img src='" . $row['picture_url'] . "' alt='" . $row['name'] . "'></div>";
                        echo "<div class='hotel-item-content'>";
                        echo "<h2>" . $row['name'] . "</h2>";
                        echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
                        echo "<p class='price'>Price per night: ₹" . $row['price_per_night'] . "</p>";
                        echo "<p><strong>Rating:</strong> " . $row['rating'] . "/5</p>";
                        echo "<a href='booking.php?hotel_id=" . $row['id'] . "' class='book-link'>Book Now</a>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hotels found in this area.</p>";
                }

                mysqli_close($db);
            }
            ?>
        </div>
    </div>
    <script>
        function closeEvents() {
            document.getElementById('events-popup').style.display = 'none';
        }
    </script>
    <?php include('footer.php'); ?>
</body>

</html>