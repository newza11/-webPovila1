<?php
session_start();

session_unset();
session_destroy();

// นำทางไปที่หน้า login.php
header("Location: login.php");
exit();
?>