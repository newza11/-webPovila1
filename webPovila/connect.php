<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'my_website';
$dbname = "login_user";

// PDO
$pdo = new PDO( "mysql:host={$host}; dbname={$database}", $username, $password, [ PDO::ATTR_EMULATE_PREPARES => false ] );
// OOP mysqli
$mysqli = new mysqli( $host, $username, $password, $database );
// Procedural mysqli
$mysqli_p = mysqli_connect( $host, $username, $password, $database );
?>
if($pdo){
    echo "pdo เชื่อมต่อสำเร็จ"."</br>";
}