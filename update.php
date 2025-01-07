<?php
include('conn.php'); // Replace with your actual connection file

// Fetch places from the database
$query = "SELECT id, destination FROM destinations"; // Replace 'places' with your actual table name
$result = mysqli_query($conn, $query);
?>
<div class="page-content">
    <h3>Update Place</h3>
    <form id="update-form" method="POST" action="process_update.php">
        <label for="place-id">Select Place to Update:</label>
        <select name="place_id" id="place-id" required>
            <?php
            // Populate the dropdown with places
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['id']}'>{$row['destination']}</option>";
            }
            ?>
        </select>

        <label for="place-name">Place Name:</label>
        <input type="text" id="place-name" name="place_name" required placeholder="Enter updated name">

        <label for="place-description">Description:</label>
        <textarea id="place-description" name="place_description" rows="4" placeholder="Enter updated description"></textarea>

        <label for="place-location">Location:</label>
        <input type="text" id="place-location" name="place_location" required placeholder="Enter updated location">
        
        <label for="place-price">Price:</label>
        <input type="text" id="place-price" name="place_price" required placeholder="Enter updated price">
        <button type="submit">Update Place</button>
    </form>
</div>

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    .page-content {
        max-width: 100%;
        margin: 0 auto;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        border-radius: 8px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    label {
        margin: 10px 0 5px;
    }

    input, textarea, select, button {
        margin-bottom: 15px;
        padding: 12px;
        font-size: 1rem;
        width: 100%;
        box-sizing: border-box;
    }

    button {
        color: white;
        background-color: #007BFF;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    @media (max-width: 600px) {
        .page-content {
            padding: 15px;
        }

        input, textarea, select, button {
            font-size: 0.9rem;
            padding: 10px;
        }
    }
</style>
