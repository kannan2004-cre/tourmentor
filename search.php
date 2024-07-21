<!DOCTYPE html>
<html>
<?php include('header.php')?>
    <title>Search - Tourmentor</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #EEEEEE; /* Light orange background */
            color: #333; /* Dark text color for better readability */
        }

        /* Centering and Styling the Search Form */
        form {
            display: flex;
            justify-content: left;
            align-items: center;
            margin: 20px 0;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 2px solid #CE1212; /* Orange border */
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #CE1212; /* Orange background */
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #e69500; /* Darker orange on hover */
        }

        /* Styling the Search Results */
        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: center; /* Center-align search results */
            margin: 20px;
        }

        .search-item {
            flex-basis: calc(25% - 40px);
            margin: 10px;
            border: 2px solid #CE1212; /* Orange border */
            padding: 15px;
            box-sizing: border-box;
            background-color: #fff; /* White background for each item */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow effect */
            border-radius: 10px; /* Rounded corners */
            text-align: center; /* Center-align text */
        }

        .search-item img {
            width: 100%;
            height: auto;
            border-radius: 10px; /* Rounded corners for images */
            margin-bottom: 10px;
        }

        .search-item h2 {
            font-size: 18px;
            margin: 10px 0;
            color: #333; /* Dark text color */
        }

        .search-item p {
            font-size: 14px;
            color: #666; /* Gray text color */
        }

        @media (max-width: 600px) {
            .search-item {
                flex-basis: 100%;
            }

            input[type="text"] {
                width: 70%;
            }
        }
    </style>
<body>
    <form method="POST" action="">
        <input type="text" name="query" placeholder="Enter your destination">
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    if (isset($_POST['search'])) {
        $query = $_POST['query'];

        $db = mysqli_connect("localhost", "root", "", "tourmentor");

        $sql = "SELECT * FROM image WHERE location LIKE '%$query%' OR destination LIKE '%$query%' OR description LIKE '%$query%' OR price LIKE '%$query%'";

        $result = mysqli_query($db, $sql);

        echo "<div class='search-results'>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='search-item'>";
            echo "<img src='./image/" . $row['filename'] . "'>";
            echo "<h2>" . $row['location'] . "</h2>";
            echo "<h2>" . $row['destination'] . "</h2>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Price: " . $row['price'] . "</p>";
            echo "<p>Food: " . $row['food'] . "</p>";
            echo "<p>Transport: " . $row['transport'] . "</p>";
            echo "</div>";
        }

        echo "</div>";
    }
    ?>
</body>
</html>
