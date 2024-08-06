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
        $hotel_name = mysqli_real_escape_string($db, $_POST['hotel_name']);
        $hotel_url = mysqli_real_escape_string($db, $_POST['hotel_url']);

        $sql = "INSERT INTO destinations (`filename`, `state`, `district`, `location`, `destination`, `description`, `price`, `hotel_name`, `hotel_url`) 
                VALUES ('$filename', '$state', '$district', '$location', '$destination', '$description', '$price', '$hotel_name', '$hotel_url')";

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff7e6;
        }

        #content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
            animation: fadeIn 1s ease-in-out;
            box-sizing: border-box;
        }

        #content h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-row div {
            flex: 1;
            margin-right: 10px;
        }

        .form-row div:last-child {
            margin-right: 0;
        }

        .details input[type="text"],
        .details select,
        .form-group input[type="file"],
        .details input[type="url"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border: 2px solid #ffa500;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #ffa500;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #e69500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .details input:focus,
        .details select:focus,
        .form-group input:focus,
        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 10px #ffa500;
        }
    </style>
</head>

<body>
    <div id="content">
        <h2>Upload Your Image</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="details">
                <div class="form-row">
                    <div>
                        State Name:<input type="text" name="state" placeholder="Enter State Name" required>
                    </div>
                    <div>
                        District Name:<input type="text" name="district" placeholder="Enter District Name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        Location:<input type="text" name="location" placeholder="Enter Location" required>
                    </div>
                    <div>
                        Destination Name:<input type="text" name="destination" placeholder="Enter Destination" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        Description:<input type="text" name="description" placeholder="Enter Description" required>
                    </div>
                    <div>
                        Price:<input type="text" name="price" placeholder="Enter Price" required>
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        Nearest Hotel Name:<input type="text" name="hotel_name" placeholder="Enter Nearest Hotel Name" required>
                    </div>
                    <div>
                        Hotel URL:<input type="url" name="hotel_url" placeholder="Enter Hotel URL" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" required />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
    </div>
</body>

</html>
