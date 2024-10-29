<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $conn = mysqli_connect("localhost", "root", "", "tourmentor");
    if (!$conn) {
        die("connection failed");
    }
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password)  || !preg_match("/[\W]/", $password) ) {
        echo "<script>alert('Password must be at least 8 characters long, include at least one number and a special character.');</script>";
        echo "<script>window.location.href = 'signup.php';</script>";
        exit(0);
    } else {
        $hpass = password_hash($password, PASSWORD_DEFAULT);
        
        $filename = null;
        // Check if a file was uploaded
        if (!empty($_FILES["profilepic"]["name"])) {
            $filename = $_FILES["profilepic"]["name"];
            $tempname = $_FILES["profilepic"]["tmp_name"];
            $folder = "./uimages/" . $filename;
            
            // Move uploaded file
            if (!move_uploaded_file($tempname, $folder)) {
                echo "<script>alert('Failed to upload profile picture. Registration will continue without picture.');</script>";
                $filename = null;
            }
        }
        
        $sql = "INSERT INTO userreg (`name`, `email`, `password`, `filename`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hpass, $filename);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Registered successfully');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('OOPS! Registration failed. Error: " . mysqli_error($conn) . "');</script>";
            echo "<script>window.location.href = 'signup.php';</script>";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
}
?>