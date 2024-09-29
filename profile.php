<?php
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Get user information from session
$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$profile_pic = $_SESSION['user_profile_pic'];

// Define the directory where profile pictures are stored
$upload_dir = './uimages/';

// Check if the profile picture file exists
if (!empty($profile_pic) && file_exists($upload_dir . $profile_pic)) {
    $profile_pic_path = $upload_dir . $profile_pic;
} else {
    // Use a default image if the profile picture doesn't exist
    $profile_pic_path = './image/default_pic.webp';
}

// Fetch booked hotels from the database
$bookedHotels = []; // Example array, replace with DB query for actual data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-color: #f9fbfd;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
            padding: 40px 0;
        }

        .profile-card {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 320px;
        }

        .profile-card img {
            height: 120px;
            width: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .profile-card h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-card p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .profile-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .profile-buttons a {
            padding: 10px 24px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .profile-buttons a.logout {
            background-color: #cf1313;
            border: 2px solid #cf1313;
            color: white;
        }

        .profile-buttons a.edit {
            background-color: transparent;
            border: 2px solid #cf1313;
            color: #cf1313;
        }

        .profile-buttons a:hover.logout {
            background-color: #ffa600;
            border-color: #ffa600;
            color: black;
        }

        .profile-buttons a:hover.edit {
            border-color: #ffa600;
            color: #ffa600;
        }

        .booked-hotels {
            margin: 50px auto;
            width: 80%;
        }

        .booked-hotels h2 {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .hotel-card {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .hotel-card:hover {
            transform: scale(1.02);
        }

        .hotel-image {
            width: 120px;
            height: 120px;
            border-radius: 10px;
            object-fit: cover;
        }

        .hotel-details {
            flex: 1;
        }

        .hotel-details h3 {
            font-size: 22px;
            color: #333;
            margin: 0;
        }

        .hotel-details p {
            margin: 5px 0;
            color: #555;
            font-size: 18px;
        }

        .hotel-details .price {
            color: #d32f2f;
            font-weight: bold;
        }

        .hotel-details .booking-date {
            color: #757575;
            font-size: 16px;
        }

        .hotel-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .hotel-actions a {
            background-color: #cf1313;
            color: white;
            padding: 10px 15px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .hotel-actions a:hover {
            background-color: #ffa600;
            border-color: #ffa600;
            color: black;
        }

        @media (max-width: 768px) {
            .profile-card {
                width: 90%;
                padding: 30px;
            }

            .profile-card h2 {
                font-size: 22px;
            }

            .profile-card p {
                font-size: 14px;
            }

            .profile-buttons a {
                font-size: 14px;
            }

            .hotel-card {
                flex-direction: column;
                text-align: center;
            }

            .hotel-image {
                margin: 0 auto 10px;
            }

            .hotel-actions {
                flex-direction: row;
                justify-content: center;
                gap: 15px;
            }
        }
    </style>
</head>

<body>
    <?php include('header.php'); ?>
    
    <!-- Profile Section -->
    <div class="profile-container">
        <div class="profile-card">
            <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture">
            <h2><?php echo htmlspecialchars($name); ?></h2>
            <p>Email: <?php echo htmlspecialchars($email); ?></p>
            <div class="profile-buttons">
                <a href="logout.php" class="logout">Logout</a>
                <a href="#" class="edit">Edit</a>
            </div>
        </div>
    </div>

    <!-- Booked Hotels Section -->
    <div class="booked-hotels">
        <h2>Your Booked Hotels</h2>
        <?php if (empty($bookedHotels)) : ?>
            <p style="text-align:center;">No booked hotels to display.</p>
        <?php else : ?>
            <?php foreach ($bookedHotels as $hotel) : ?>
                <div class="hotel-card">
                    <img src="<?php echo $hotel['image_url']; ?>" alt="Hotel Image" class="hotel-image">
                    <div class="hotel-details">
                        <h3><?php echo htmlspecialchars($hotel['name']); ?></h3>
                        <p class="price">₹<?php echo htmlspecialchars($hotel['price']); ?> per night</p>
                        <p class="booking-date">Booking Date: <?php echo htmlspecialchars($hotel['booking_date']); ?></p>
                    </div>
                    <div class="hotel-actions">
                        <a href="hotel-details.php?id=<?php echo $hotel['id']; ?>">View Details</a>
                        <a href="cancel-booking.php?id=<?php echo $hotel['id']; ?>">Cancel Booking</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>
