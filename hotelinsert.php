<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tourmentor';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $price = floatval($_POST['price']);
    $rating = floatval($_POST['rating']);

    // Handle file upload
    $target_dir = "himages/";
    $target_file = $target_dir . basename($_FILES["hotel_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["hotel_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["hotel_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["hotel_image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["hotel_image"]["name"])). " has been uploaded.";
            
            // Insert into hotels table
            $sql = "INSERT INTO hotels (name, address, price_per_night, rating, picture_url) 
                    VALUES ('$name', '$address', $price, $rating, '$target_file')";
            
            if (mysqli_query($conn, $sql)) {
                $hotel_id = mysqli_insert_id($conn);
                
                // Process attractions
                $attractions = [];
                for ($i = 0; $i < count($_POST['attraction']); $i++) {
                    if (!empty($_POST['attraction'][$i]) && !empty($_POST['distance'][$i])) {
                        $attraction = mysqli_real_escape_string($conn, $_POST['attraction'][$i]);
                        $distance = floatval($_POST['distance'][$i]);
                        $attractions[] = "$attraction,$distance";
                    }
                }
                $attractions_info = implode(',', $attractions);

                // Insert into hotel_attractions table
                $sql = "INSERT INTO hotel_attractions (hotel_id, attractions_info) 
                        VALUES ($hotel_id, '$attractions_info')";
                mysqli_query($conn, $sql);

                echo "<p>Hotel added successfully!</p>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Hotel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Add New Hotel</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Hotel Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="price">Price per Night:</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating" step="0.1" min="0" max="5" required>

            <label for="hotel_image">Hotel Image:</label>
            <input type="file" id="hotel_image" name="hotel_image" accept="image/*" required>

            <h2>Attractions</h2>
            <div id="attractions">
                <div class="attraction-entry">
                    <input type="text" name="attraction[]" placeholder="Attraction Name">
                    <input type="number" name="distance[]" step="0.1" placeholder="Distance (km)">
                </div>
            </div>
            <button type="button" onclick="addAttraction()">Add Another Attraction</button>

            <button type="submit">Add Hotel</button>
        </form>
    </main>

    <script>
        function addAttraction() {
            const attractionsDiv = document.getElementById('attractions');
            const newAttraction = document.createElement('div');
            newAttraction.className = 'attraction-entry';
            newAttraction.innerHTML = `
                <input type="text" name="attraction[]" placeholder="Attraction Name">
                <input type="number" name="distance[]" step="0.1" placeholder="Distance (km)">
            `;
            attractionsDiv.appendChild(newAttraction);
        }
    </script>
</body>
</html>
