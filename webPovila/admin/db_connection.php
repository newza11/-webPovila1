
<?php
$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
