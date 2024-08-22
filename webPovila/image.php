<?php
require 'db_connect.php'; // เชื่อมต่อฐานข้อมูล

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // ดึงข้อมูลรูปภาพจากฐานข้อมูล
    $stmt = $pdo->prepare("SELECT slip FROM orders_db WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // ใช้ finfo เพื่อดึง MIME type ของไฟล์
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_buffer($finfo, $row['slip']);
        finfo_close($finfo);

        // ตั้งค่า header เพื่อแสดงผลรูปภาพ
        header("Content-Type: " . $mime_type);
        echo $row['slip']; // แสดงผลรูปภาพ
    } else {
        echo 'ไม่พบรูปภาพ';
    }
} else {
    echo 'ไม่มีการส่ง ID มา';
}
?>
