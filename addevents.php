<?php
include('conn.php');

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $event_start_date = mysqli_real_escape_string($conn, $_POST['event_start_date']);
    $event_end_date = mysqli_real_escape_string($conn, $_POST['event_end_date']);
    $event_description = mysqli_real_escape_string($conn, $_POST['event_description']);
    $event_location = mysqli_real_escape_string($conn, $_POST['event_location']);
    $event_url = mysqli_real_escape_string($conn, $_POST['event_url']);
    

    // Insert event query
    $sql = "INSERT INTO events (event_name, event_description,event_start_date, event_end_date,location,event_url) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $event_name, $event_description, $event_start_date, $event_end_date, $event_location, $event_url);

    if ($stmt->execute()) {
        echo "<script>alert('Event added successfully.');</script>";
    } else {
        echo "<script>alert('Error adding event: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link rel="stylesheet" href="https://unpkg.com/pico@latest/css/pico.min.css">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        main {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input, textarea {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #cf1313;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #ffa600;
            color: black;
        }
    </style>
</head>
<body>
    <main>
        <h1>Add New Event</h1>
        <form method="POST" action="">
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="event_location">Event location:</label>
            <input type="text" id="event_location" name="event_location" required>

            <label for="event_start_date">Event Start Date:</label>
            <input type="date" id="event_start_date" name="event_start_date" required>

            <label for="event_end_date">Event End Date:</label>
            <input type="date" id="event_end_date" name="event_end_date" required>

            <label for="event_description">Event Description:</label>
            <textarea id="event_description" name="event_description" rows="4" required></textarea>

            <label for="event_url">Event Url:</label>
            <input type="text" id="event_url" name="event_url" required>

            <button type="submit" name="add_event">Add Event</button>
        </form>
    </main>
</body>
</html>

