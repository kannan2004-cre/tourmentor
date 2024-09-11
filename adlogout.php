<?php
session_start();
session_destroy();
header("Location: adlogin.php");
exit();
?>