<?php
if (isset($_POST['submit'])) {
    $filename = $_FILES["profilepic"]["name"];
    $tempname = $_FILES["profilepic"]["tmp_name"];
    $folder = "./uimages/" . $filename;
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $conn = mysqli_connect("localhost", "root", "", "tourmentor");
    if (!$conn) {
        die("connection failed");
    }
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password)  || !preg_match("/[\W]/", $password) ) {
        echo "<script>alert('Password must be at least 8 characters long and include at least one number.');</script>";
        exit(0);
    } else {
        $hpass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO userreg (`name`, `email`, `password`,`filename`) VALUES ('$name', '$email', '$hpass','$filename')";
        if ((mysqli_query($conn, $sql)) && (move_uploaded_file($tempname, $folder))) {
            echo "<script>alert('registered successfully')</script>";
            header("Location: login.php");
        } else {
            echo "<script>alert('OOPS! Registration failed');</script>";
        }
        /*if(mysqli_query($conn,$sql)){
        echo "<script>alert('registered successfully')</script>";
    }
    else{
        echo "<script>alert('OOPS! Registration failed');</script>";
    }
    mysqli_close($conn);*/
    }
}
