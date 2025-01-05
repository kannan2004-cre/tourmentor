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
    .page-content {
        max-width: 600px;
        margin: 20px auto;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin: 10px 0 5px;
    }

    input, textarea, select, button {
        margin-bottom: 15px;
        padding: 8px;
        font-size: 1rem;
    }

    button {
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
    }

</style>
