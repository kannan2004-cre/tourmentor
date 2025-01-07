<?php

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "tourmentor"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$sql = "INSERT INTO reviews (name, email, title, review) VALUES ('$name', '$email', '$subject', '$message')";

if ($conn->query($sql) === TRUE) {
    $message = "New review submitted successfully";
    $isError = false;
} else {
    $message = "Error: " . $conn->error;
    $isError = true;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Submission</title>
    <style>
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            color: #333;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }
        .popup.error {
            background-color: #f44336;
            color: white;
        }
        .popup.success {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    <script>
        function showPopup(message, isError = false) {
            const popup = document.createElement('div');
            popup.className = 'popup' + (isError ? ' error' : ' success');
            popup.textContent = message;
            document.body.appendChild(popup);
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.display = 'none';
                document.body.removeChild(popup);
                window.location.href = '../index.php';
            }, 2000);
        }

        window.onload = function() {
            <?php if (isset($message)): ?>
                showPopup("<?php echo $message; ?>", <?php echo $isError ? 'true' : 'false'; ?>);
            <?php endif; ?>
        };
    </script>
</head>
<body>
</body>
</html>
