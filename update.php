<?php
/* error_reporting(E_ALL);
ini_set('display_errors', 1); */

$msg = "";
$db = mysqli_connect("localhost", "root", "", "tourmentor");

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data for the entered place ID
if (isset($_POST['fetch_details'])) {
    $destination_id = mysqli_real_escape_string($db, $_POST['destination_id']);
    
    $sql = "SELECT * FROM destinations WHERE id = '$destination_id'";
    $result = mysqli_query($db, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $destination_data = mysqli_fetch_assoc($result);
    } else {
        $msg = "No destination found with this ID.";
    }
}

// Update the details after fetching
if (isset($_POST['update'])) {
    $destination_id = mysqli_real_escape_string($db, $_POST['destination_id']);
    $state = mysqli_real_escape_string($db, $_POST['state']);
    $district = mysqli_real_escape_string($db, $_POST['district']);
    $location = mysqli_real_escape_string($db, $_POST['location']);
    $destination = mysqli_real_escape_string($db, $_POST['destination']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $price = mysqli_real_escape_string($db, $_POST['price']);
    
    // Check if a new file was uploaded
    if (isset($_FILES['uploadfile']) && $_FILES['uploadfile']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES["uploadfile"]["name"];
        $tempname = $_FILES["uploadfile"]["tmp_name"];
        $folder = "./image/" . $filename;

        // Update with new filename
        $sql = "UPDATE destinations SET
                `filename` = '$filename',
                `state` = '$state',
                `district` = '$district',
                `location` = '$location',
                `destination` = '$destination',
                `description` = '$description',
                `price` = '$price'
                WHERE `id` = '$destination_id'";
        
        if (mysqli_query($db, $sql)) {
            if (move_uploaded_file($tempname, $folder)) {
                $msg = "Destination updated successfully with new file!";
            } else {
                $msg = "Failed to upload file!";
            }
        } else {
            $msg = "Database error: " . mysqli_error($db);
        }
    } else {
        // If no new file is uploaded, only update other fields
        $sql = "UPDATE destinations SET
                `state` = '$state',
                `district` = '$district',
                `location` = '$location',
                `destination` = '$destination',
                `description` = '$description',
                `price` = '$price'
                WHERE `id` = '$destination_id'";

        if (mysqli_query($db, $sql)) {
            $msg = "Destination updated successfully!";
        } else {
            $msg = "Database error: " . mysqli_error($db);
        }
    }

    echo "<script>
            alert('$msg');
            window.location.href = 'update.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Destination</title>
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
        <h2>Update Destination</h2>
        
        <!-- Form to fetch details using place id -->
        <form method="POST" action="">
            <div class="details">
                <div class="form-row">
                    <div>
                        Enter Destination ID:<input type="text" name="destination_id" placeholder="Enter Destination ID" value="<?php echo isset($destination_data['id']) ? $destination_data['id'] : ''; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn-primary" type="submit" name="fetch_details">Fetch Details</button>
                </div>
            </div>
        </form>
        
        <?php if (isset($destination_data)) { ?>
        <!-- Form to update details -->
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="destination_id" value="<?php echo $destination_data['id']; ?>">
            
            <div class="details">
                <div class="form-row">
                    <div>
                        State Name:<input type="text" name="state" placeholder="Enter State Name" value="<?php echo $destination_data['state']; ?>">
                    </div>
                    <div>
                        District Name:<input type="text" name="district" placeholder="Enter District Name" value="<?php echo $destination_data['district']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        Location:<input type="text" name="location" placeholder="Enter Location" value="<?php echo $destination_data['location']; ?>">
                    </div>
                    <div>
                        Destination Name:<input type="text" name="destination" placeholder="Enter Destination" value="<?php echo $destination_data['destination']; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        Description:<input type="text" name="description" placeholder="Enter Description" value="<?php echo $destination_data['description']; ?>">
                    </div>
                    <div>
                        Price:<input type="text" name="price" placeholder="Enter Price" value="<?php echo $destination_data['price']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile">
                <?php if (isset($destination_data['filename']) && !empty($destination_data['filename'])) { ?>
                    <img src="./image/<?php echo $destination_data['filename']; ?>" alt="Current Image" style="max-width: 100px;">
                <?php } ?>
            </div>
            <div class="form-group">
                <button class="btn-primary" type="submit" name="update">UPDATE</button>
            </div>
        </form>
        <?php } ?>
    </div>
</body>
</html>
