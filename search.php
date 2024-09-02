<!DOCTYPE html>
<html>
<title>Search - Tourmentor</title>
<style>
    /* General Styles */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #F9F9F9;
        color: #333;
    }
    

    form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 140px;
        padding: 0 10px;
    }

    input[type="text"] {
        padding: 12px;
        width: 400px;
        border: 2px solid #CE1212;
        border-radius: 5px;
        margin-right: 10px;
        font-size: 16px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    button[type="submit"] {
        padding: 12px 25px;
        background-color: #CE1212;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #e69500;
    }

    .search-results {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 20px;
        padding: 10px;
    }

    .search-item {
        flex-basis: calc(30% - 20px);
        margin: 15px;
        border: 2px solid #CE1212;
        padding: 20px;
        box-sizing: border-box;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .search-item:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .search-item img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    .search-item h2 {
        font-size: 20px;
        margin: 10px 0;
        color: #CE1212;
    }

    .search-item p {
        font-size: 14px;
        color: #666;
        margin: 5px 0;
    }

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        max-width: 80%;
        position: relative;
    }

    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        font-size: 20px;
        color: #CE1212;
    }

    @media (max-width: 768px) {
        .search-item {
            flex-basis: calc(45% - 20px);
        }
    }

    @media (max-width: 600px) {
        .search-item {
            flex-basis: 100%;
        }

        input[type="text"] {
            width: 80%;
        }

        button[type="submit"] {
            width: 100%;
        }
    }
</style>
<body>
    <?php include('header.php');?>
    <form method="POST" action="">
        <input type="text" name="query" placeholder="Enter your destination">
        <button type="submit" name="search">Search</button>
    </form>

    <!-- Popup Box -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span id="popup-close" class="popup-close">&times;</span>
            <div id="popup-body"></div>
        </div>
    </div>

    <?php
    if (isset($_POST['search'])) {
        $query = $_POST['query'];

        $db = mysqli_connect("localhost", "root", "", "tourmentor");

        // Fetch and display local events
        $event_sql = "SELECT * FROM events WHERE location LIKE '%$query%'";
        $event_result = mysqli_query($db, $event_sql);

        if (mysqli_num_rows($event_result) > 0) {
            echo "<script>
                document.getElementById('popup-body').innerHTML = '';";
            while ($event = mysqli_fetch_assoc($event_result)) {
                echo "document.getElementById('popup-body').innerHTML += '<h3>" . $event['event_name'] . "</h3>';
                document.getElementById('popup-body').innerHTML += '<p>" . $event['event_description'] . "</p>';
                document.getElementById('popup-body').innerHTML += '<p><a href=\"" . $event['event_url'] . "\">More Info</a></p>';
                document.getElementById('popup-body').innerHTML += '<p>From: " . $event['event_start_date'] . " To: " . $event['event_end_date'] . "</p>';";
            }
            echo "document.getElementById('popup').style.display = 'flex';
            </script>";
        }

        // Search for locations
        $sql = "SELECT * FROM destinations WHERE location LIKE '%$query%' OR destination LIKE '%$query%' OR description LIKE '%$query%' OR price LIKE '%$query%' OR district LIKE '%$query%' OR state LIKE '%$query%'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<div class='search-results'>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='search-item'>";
                echo "<img src='./image/" . $row['filename'] . "'>";
                echo "<h2>" . $row['destination'] . "</h2>";
                echo "<h2>" . $row['location'] . "</h2>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p>Price: " . $row['price'] . "</p>";
                echo "<p>Nearest Hotel: " . $row['hotel_name'] . "</p>";
                echo "<p><a href='" . $row['hotel_url'] . "'>Hotel URL</a></p>";
                echo "</div>";
            }

            echo "</div>";
        } else {
            echo "<p>No results found.</p>";
        }

        // Close the database connection
        mysqli_close($db);
    }
    ?>

    <script>
        // Close popup when clicking 'X' or outside the popup
        document.getElementById('popup-close').onclick = function() {
            document.getElementById('popup').style.display = 'none';
        }
        window.onclick = function(event) {
            if (event.target === document.getElementById('popup')) {
                document.getElementById('popup').style.display = 'none';
            }
        }
    </script>
    <?php include('footer.php'); ?>
</body>
</html>
