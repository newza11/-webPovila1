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

// SQL to create villa_info table
$createVillaInfoTable = "CREATE TABLE IF NOT EXISTS villa_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
)";
$conn->query($createVillaInfoTable);
    
// SQL to create villa_pricing table
$createVillaPricingTable = "CREATE TABLE IF NOT EXISTS villa_pricing (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    details TEXT NOT NULL
)";
$conn->query($createVillaPricingTable);

// SQL to create villa_rooms table
$createVillaRoomsTable = "CREATE TABLE IF NOT EXISTS villa_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number INT NOT NULL,
    description TEXT NOT NULL
)";
$conn->query($createVillaRoomsTable);

// SQL to create villa_facilities table
$createVillaFacilitiesTable = "CREATE TABLE IF NOT EXISTS villa_facilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL
)";
$conn->query($createVillaFacilitiesTable);

// SQL to create villa_images table
$createVillaImagesTable = "CREATE TABLE IF NOT EXISTS villa_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL
)";
$conn->query($createVillaImagesTable);

// Insert initial data into villa_info
$insertVillaInfoData = "INSERT INTO villa_info (name, description) VALUES 
('นันท์นภัส พลูวิลล่า อัมพวา', 'Luxury Pool Villa บ้านพัก 6 ห้องนอน 6 ห้องน้ำ รองรับลูกค้าถึง 20 ท่าน/คืน ตกแต่งสไตล์ Luxury มีความหรูหรา มาพร้อมห้องคาราโอเกะที่กว้างขวาง มีสระว่ายน้ำ สไลด์เดอร์ อุปกรณ์เครื่องครัวครบครัน ใกล้สถานที่ท่องเที่ยวมากมาย พร้อมให้บริการลูกค้าทุกท่าน')";
$conn->query($insertVillaInfoData);

// Insert initial data into villa_pricing
$insertVillaPricingData = "INSERT INTO villa_pricing (title, details) VALUES
('ราคาเหมาทั้งหลัง (6 ห้องนอน)', 'วันอาทิตย์ - วันพฤหัส ราคาเหมา 9,900.- บาท/คืน วันศุกร์ ราคาเหมา 12,900.- บาท/คืน วันเสาร์/วันหยุดนักขัตฤกษ์ ราคาเหมา 14,900.- บาท/คืน วันขึ้นปีใหม่ วันสงกรานต์ ราคาเหมา 16,900.- บาท/คืน'),
('ราคาวันธรรมดา (วันอาทิตย์ - วันพฤหัส)', '3 ห้อง ราคาเหมา 6,900.- บาท/คืน 4 ห้อง ราคาเหมา 7,900.- บาท/คืน 5 ห้อง ราคาเหมา 8,900.- บาท/คืน')";
$conn->query($insertVillaPricingData);

// Insert initial data into villa_rooms
$insertVillaRoomsData = "INSERT INTO villa_rooms (room_number, description) VALUES
(1, 'ห้องนอนที่ 1 ติดสระว่ายน้ำ ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง ห้องน้ำในตัว TV และโต๊ะเครื่องแป้ง'),
(2, 'ห้องนอนที่ 2 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง ห้องน้ำในตัวพร้อม TV และโต๊ะเครื่องแป้ง'),
(3, 'ห้องนอนที่ 3 ห้องนอนเด็ก ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง'),
(4, 'ห้องนอนที่ 4 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง TV และโต๊ะเครื่องแป้ง'),
(5, 'ห้องนอนที่ 5 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง'),
(6, 'ห้องนอนที่ 6 ประกอบด้วย เตียงนอนขนาด 6 ฟุต 1 เตียง ห้องน้ำในตัวพร้อมอ่างจากุชชี่ TV และโต๊ะเครื่องแป้ง')";
$conn->query($insertVillaRoomsData);

// Insert initial data into villa_facilities
$insertVillaFacilitiesData = "INSERT INTO villa_facilities (title, description) VALUES
('สระว่ายนำ้', 'ให้คุณว่ายน้ำ หรือเล่นสไลด์เดอร์เพื่อความสนุกสนาน เล่นน้ำหย่อนใจอย่างสมบูรณ์แบบและนั่งเล่นริมสระ มอบความเป็นส่วนตัวในการพักผ่อน มีสระสำหรับเด็กๆเล่นอย่างปลอดภัยมีชูชีพ และน้องเป็ดเหลืองเล่นน้ำเป็นเพื่่อนอีกด้วย'),
('ห้องคาราโอเกะ', 'มีห้องคาราโอเกะ พร้อมโต๊ะสนุ๊กให้บริการสำหรับผู้ที่ชื่นชอบเสียงเพลง พร้อมทั้งมีไฟเทค เสริมความสนุกสนานของร้องเพลง ภายในห้องดีไซน์แบบ Luxury มีความหรูหราอย่างลงตัว'),
('ห้องครัว', 'ห้องครัวอุปกรณ์ครัวครบครันใกล้สระว่ายนำ้ มีทั้งครัวไทยและครัวฝรั่ง สามารถทำอาหารได้หลากหลายอย่างละ มีเตาย่างบาร์บีคิวโต๊ะกินข้าวบริเวณริมสระน้ำ')";
$conn->query($insertVillaFacilitiesData);

// Insert initial data into villa_images
$insertVillaImagesData = "INSERT INTO villa_images (image_path) VALUES
('poo/1.jpg'),
('poo/2.jpg'),
('poo/3.jpg'),
('poo/4.jpg'),
('poo/5.jpg'),
('poo/6.jpg'),
('poo/7.jpg'),
('poo/8.jpg'),
('poo/9.jpg'),
('poo/10.jpg'),
('poo/11.jpg'),
('poo/12.jpg'),
('poo/13.jpg'),
('poo/14.jpg'),
('poo/15.jpg'),
('poo/16.jpg'),
('poo/17.jpg'),
('poo/18.jpg'),
('poo/19.jpg'),
('poo/20.jpg'),
('poo/21.jpg'),
('poo/22.jpg'),
('poo/23.jpg')";
$conn->query($insertVillaImagesData);

$conn->close();
?>
