<?php
$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ข้อมูลที่ต้องการเพิ่ม
$title = "บ้านนันท์นภัส พลูวิลล่า อัมพวา";
$description = "Luxury Pool Villa บ้านพัก 6 ห้องนอน 6 ห้องน้ำ รองรับลูกค้าถึง 20 ท่าน/คืน ตกแต่งสไตล์ Luxury มีความหรูหรา มาพร้อมห้องคาราโอเกะที่กว้างขวาง มีสระว่ายน้ำ สไลด์เดอร์ อุปกรณ์เครื่องครัวครบครัน ใกล้สถานที่ท่องเที่ยวมากมาย พร้อมให้บริการลูกค้าทุกท่าน";


// คำสั่ง SQL สำหรับเพิ่มข้อมูล
$sql = "INSERT INTO villa_home_content (title, description) VALUES ('$title', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "เพิ่มข้อมูลใหม่เรียบร้อยแล้ว";
} else {
    echo "เกิดข้อผิดพลาด: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
