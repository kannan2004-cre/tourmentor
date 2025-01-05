<?php
// Include database connection
include('conn.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input data
    $id = mysqli_real_escape_string($conn, $_POST['place_id']);
    $name = mysqli_real_escape_string($conn, $_POST['place_name']);
    $description = mysqli_real_escape_string($conn, $_POST['place_description']);
    $location = mysqli_real_escape_string($conn, $_POST['place_location']);
    $price = mysqli_real_escape_string($conn , $_POST['place_price']);

    // Validate inputs
    if (empty($id) || empty($name) || empty($location) || empty($price)) {
        echo "<p>Error: Please fill in all required fields.</p>";
        exit;
    }

    // Update query
    $query = "UPDATE destinations SET destination = ?, description = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $description, $location, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Place updated successfully.')</script>";
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        echo "<p>Error updating place: " . $stmt->error . "</p>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request method.</p>";
}
?>
