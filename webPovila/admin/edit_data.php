<?php
include 'db_connection.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$section = isset($_GET['section']) ? $_GET['section'] : '';

if ($id && $section) {
    switch ($section) {
        case 'concept':
            $table = 'villa_home_content';
            break;
        case 'project':
            $table = 'villa_details';
            break;
        case 'facilities':
            $table = 'accordion_items';
            break;
        case 'gallery':
            $table = 'villa_images';
            break;
        case 'main':
            $table = 'villa_main';
            break;
        case 'descriptions':
            $table = 'villa_descriptions';
            break;
        default:
            echo "Invalid section";
            exit;
    }

    // ดึงข้อมูลที่ต้องการแก้ไข
    $sql = "SELECT * FROM $table WHERE id = $id";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบว่ามีการอัปโหลดรูปภาพใหม่หรือไม่
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDirectory = '../uploads/'; // โฟลเดอร์จริงที่ไฟล์จะถูกอัปโหลดไป
            $databaseDirectory = 'uploads/'; // เส้นทางที่จะบันทึกในฐานข้อมูล
            $image = $_FILES['image'];
            $imageName = basename($image['name']);
            $imagePath = $uploadDirectory . $imageName; // เส้นทางจริงของไฟล์ที่อัปโหลด
            $databasePath = $databaseDirectory . $imageName; // เส้นทางที่บันทึกในฐานข้อมูล

            // ตรวจสอบและอัปโหลดรูปภาพ
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($image['type'], $allowedTypes)) {
                if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                    // อัปเดตข้อมูลรูปภาพในฐานข้อมูล
                    $sql_update_image = "UPDATE $table SET image_path = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql_update_image);
                    $stmt->bind_param('si', $databasePath, $id); // บันทึกเส้นทางจาก $databasePath ที่เป็นเส้นทางในฐานข้อมูล
                    $stmt->execute();
                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger'>Failed to upload the image.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Invalid image type.</div>";
            }
        }

        // อัปเดตข้อมูลทั่วไป
        $fields = [];
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $key !== 'image_path') { // ไม่อัปเดต id และ image_path ที่จัดการแยก
                $fields[] = "$key = '" . $conn->real_escape_string($_POST[$key]) . "'";
            }
        }
        $sql_update = "UPDATE $table SET " . implode(', ', $fields) . " WHERE id = $id";
        if ($conn->query($sql_update)) {
            echo "<script>alert('Data updated successfully!'); window.location.href = 'villa_setting.php';</script>";
        } else {
            echo "<div class='alert alert-danger'>Error updating data: " . $conn->error . "</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f9;
        }

        .container {
            margin-top: 50px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 20px;
        }

        .btn-primary {
            display: block;
            width: 100%;
        }

        .image-preview {
            max-width: 300px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Data</h2>
        <form method="POST" enctype="multipart/form-data">
            <?php
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    echo "<div class='mb-3'>";
                    echo "<label for='$key'>" . ucfirst($key) . ":</label>";
                    if ($key === 'image_path') {
                        // แสดงรูปภาพโดยใช้เส้นทางนอกโฟลเดอร์ admin
                        $imagePath = '../' . htmlspecialchars($value); // ดึงรูปจาก ../uploads/
                        echo "<br><img src='" . $imagePath . "' alt='Current Image' class='image-preview'><br>";
                        echo "<input type='file' class='form-control' name='image' accept='image/*'><br>";
                    } else {
                        echo "<input type='text' class='form-control' id='$key' name='$key' value='" . htmlspecialchars($value) . "'>";
                    }
                    echo "</div>";
                }
            }
            ?>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

</body>

</html>