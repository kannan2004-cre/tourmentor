<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tourmentor';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$id=isset($_GET['hotel_id'])?$_GET['hotel_id']:0;
$sql="select * from hotels where id= ".intval($id);
$result=mysqli_query($conn,$sql);
if($result && mysqli_num_rows($result) > 0){
    $hotel=mysqli_fetch_assoc($result);
    echo"<h1>Booking for:".htmlspecialchars($hotel['name'])."</h1>";
}
else{
    echo"<script>alert('Hotel not found!');</script>";
}
mysqli_close($conn);
?>