<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

    // Check if file was uploaded
    if (isset($_FILES['uploadfile']) && $_FILES['uploadfile']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./image/" . $filename;

        // Connect to the database
        $db = mysqli_connect("localhost", "root", "", "tourmentor");

        // Check connection
        if (!$db) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get all the submitted data from the form
        $state = mysqli_real_escape_string($db, $_POST['state']);
        $district = mysqli_real_escape_string($db, $_POST['district']);
        $location = mysqli_real_escape_string($db, $_POST['location']);
        $destination = mysqli_real_escape_string($db, $_POST['destination']);
        $description = mysqli_real_escape_string($db, $_POST['description']);
        $price = mysqli_real_escape_string($db, $_POST['price']);

        $sql = "INSERT INTO destinations (`filename`, `state`, `district`, `location`, `destination`, `description`, `price`) 
                VALUES ('$filename', '$state', '$district', '$location', '$destination', '$description', '$price')";

        // Execute query
        if (mysqli_query($db, $sql)) {
            // Move the uploaded image into the folder: image
            if (move_uploaded_file($tempname, $folder)) {
                $msg = "Uploaded successfully!";
            } else {
                $msg = "Failed to upload file!";
            }
        } else {
            $msg = "Database error: " . mysqli_error($db);
        }

        // Close the database connection
        mysqli_close($db);
    } else {
        $msg = "No file was uploaded or there was an upload error.";
    }

    // Pass the message to JavaScript
    echo "<script>
            alert('$msg');
            window.location.href = 'upload.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <style>
        /* Scoped styles for upload form only */
        .upload-container {
            background: transparent !important;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .upload-container h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: inherit;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-field {
            margin-bottom: 1rem;
        }

        .form-field label {
            display: block;
            margin-bottom: 0.5rem;
            color: inherit;
        }

        .form-field input[type="text"],
        .form-field input[type="file"] {
            width: 100%;
            background: transparent;
            border: 1px solid var(--pico-form-element-border-color);
        }

        .file-upload {
            margin: 1rem 0;
        }

        .submit-button {
            width: 100%;
            margin-top: 1rem;
        }

        /* Preserve dark mode compatibility */
        @media (prefers-color-scheme: dark) {
            .upload-container {
                color: inherit;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Your Image</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-field">
                    <label for="state">State Name</label>
                    <input type="text" id="state" name="state" placeholder="Enter State Name" required>
                </div>
                <div class="form-field">
                    <label for="district">District Name</label>
                    <input type="text" id="district" name="district" placeholder="Enter District Name" required>
                </div>
                <div class="form-field">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter Location" required>
                </div>
                <div class="form-field">
                    <label for="destination">Destination Name</label>
                    <input type="text" id="destination" name="destination" placeholder="Enter Destination" required>
                </div>
                <div class="form-field">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Enter Description" required>
                </div>
                <div class="form-field">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" placeholder="Enter Price" required>
                </div>
            </div>
            <div class="file-upload">
                <label for="uploadfile">Upload Image</label>
                <input type="file" id="uploadfile" name="uploadfile" required>
            </div>
            <button type="submit" name="upload" class="submit-button">UPLOAD</button>
        </form>
    </div>
</body>

</html>
