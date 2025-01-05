<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "tourmentor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from tables
$events_sql = "SELECT * FROM events";
$events_result = $conn->query($events_sql);

$destinations_sql = "SELECT * FROM destinations";
$destinations_result = $conn->query($destinations_sql);

$reviews_sql = "SELECT * FROM reviews";
$reviews_result = $conn->query($reviews_sql);

// Fetch hotel data
$hotels_sql = "SELECT * FROM hotels";
$hotels_result = $conn->query($hotels_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Data</title>
    <style>
        /* Reset background to be transparent to maintain Pico's theme */
        body {
            font-family: Arial, sans-serif;
            background: transparent !important;
            color: inherit !important;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: inherit;
            margin-top: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background: transparent !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            border: 1px solid var(--pico-form-element-border-color);
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            border-left: 5px solid var(--pico-primary);
            padding-left: 10px;
            color: inherit;
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: transparent !important;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid var(--pico-form-element-border-color);
            color: inherit;
        }

        th {
            background-color: var(--pico-primary);
            color: var(--pico-primary-inverse);
        }

        td img {
            max-width: 100px;
            height: auto;
        }

        .no-data {
            text-align: center;
            color: var(--pico-muted-color);
            padding: 20px;
        }

        /* Links should use theme colors */
        a {
            color: var(--pico-primary);
        }

        a:hover {
            color: var(--pico-primary-hover);
        }

        /* Preserve transparency for nested elements */
        .section, .container * {
            background: transparent !important;
        }

        /* Actions column styling */
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .actions button {
            padding: 5px 10px;
            cursor: pointer;
            background-color: var(--pico-primary);
            color: var(--pico-primary-inverse);
            border: none;
            border-radius: 4px;
        }

        .actions button.delete {
            background-color: var(--pico-destructive);
        }

        @media (max-width: 768px) {
            table, th, td {
                font-size: 0.9em;
            }
            
            /* Make tables scrollable on mobile */
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>

<h1>Data Overview</h1>
<div class="container">
    <!-- Events Section -->
    <div class="section">
        <h2>Events</h2>
        <?php if ($events_result && $events_result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Location</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($event = $events_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['event_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_description']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_start_date']); ?></td>
                                <td><?php echo htmlspecialchars($event['event_end_date']); ?></td>
                                <td><?php echo htmlspecialchars($event['location']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($event['event_url']); ?>" target="_blank">Link</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No events found.</p>
        <?php endif; ?>
    </div>

    <!-- Destinations Section -->
    <div class="section">
        <h2>Destinations</h2>
        <?php if ($destinations_result && $destinations_result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>District</th>
                            <th>Location</th>
                            <th>Destination</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($destination = $destinations_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($destination['state']); ?></td>
                                <td><?php echo htmlspecialchars($destination['district']); ?></td>
                                <td><?php echo htmlspecialchars($destination['location']); ?></td>
                                <td><?php echo htmlspecialchars($destination['destination']); ?></td>
                                <td><?php echo htmlspecialchars($destination['description']); ?></td>
                                <td><?php echo htmlspecialchars($destination['price']); ?></td>
                                <td><img src="uploads/<?php echo htmlspecialchars($destination['filename']); ?>" alt="Destination Image"></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No destinations found.</p>
        <?php endif; ?>
    </div>

    <!-- Hotels Section -->
    <div class="section">
        <h2>Hotels</h2>
        <?php if ($hotels_result && $hotels_result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Hotel Name</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Rating(/5)</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($hotel = $hotels_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($hotel['name']); ?></td>
                                <td><?php echo htmlspecialchars($hotel['address']); ?></td>
                                <td><?php echo htmlspecialchars($hotel['price_per_night']); ?></td>
                                <td><?php echo htmlspecialchars($hotel['rating']); ?></td>
                                <td><img src="uploads/<?php echo htmlspecialchars($hotel['picture_url']); ?>" alt="Hotel Image"></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No hotels found.</p>
        <?php endif; ?>
    </div>

    <!-- Reviews Section -->
    <div class="section">
        <h2>Reviews</h2>
        <?php if ($reviews_result && $reviews_result->num_rows > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Title</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($review = $reviews_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($review['name']); ?></td>
                                <td><?php echo htmlspecialchars($review['email']); ?></td>
                                <td><?php echo htmlspecialchars($review['title']); ?></td>
                                <td><?php echo htmlspecialchars($review['review']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No reviews found.</p>
        <?php endif; ?>
    </div>

</div>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>