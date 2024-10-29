<?php
// Manual connection to the database
$servername = "localhost";
$username = "root";
$password = ""; // No password
$dbname = "tourmentor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from events table
$events_sql = "SELECT * FROM events";
$events_result = $conn->query($events_sql);

// Fetch data from destinations table
$destinations_sql = "SELECT * FROM destinations";
$destinations_result = $conn->query($destinations_sql);

// Fetch data from reviews table
$reviews_sql = "SELECT * FROM reviews";
$reviews_result = $conn->query($reviews_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #007bff;
            margin-top: 20px;
        }

        .container {
            max-width: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section h2 {
            border-left: 5px solid #007bff;
            padding-left: 10px;
            color: #333;
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        td img {
            max-width: 100px;
            height: auto;
        }

        .no-data {
            text-align: center;
            color: #999;
            padding: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 0.9em;
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
        <?php else: ?>
            <p class="no-data">No events found.</p>
        <?php endif; ?>
    </div>

    <!-- Destinations Section -->
    <div class="section">
        <h2>Destinations</h2>
        <?php if ($destinations_result && $destinations_result->num_rows > 0): ?>
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
        <?php else: ?>
            <p class="no-data">No destinations found.</p>
        <?php endif; ?>
    </div>

    <!-- Reviews Section -->
    <div class="section">
        <h2>Reviews</h2>
        <?php if ($reviews_result && $reviews_result->num_rows > 0): ?>
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
