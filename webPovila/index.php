    <?php
    session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "my_website";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $profile_picture = 'default_profile.png'; // Default profile picture

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $query = "SELECT profile_picture FROM login_user WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $profile_picture = $user['profile_picture'] ?: 'default_profile.png';
    }

    $sql_descriptions = "SELECT content FROM villa_descriptions ";
    $result_descriptions = $conn->query($sql_descriptions);

    if ($result_descriptions->num_rows > 0) {
        $villa_descriptions = [];
        while ($row = $result_descriptions->fetch_assoc()) {
            $villa_descriptions[] = $row;
        }
    }
    $sql_main = "SELECT content,image_path FROM villa_main ";
    $result_main = $conn->query($sql_main);

    if ($result_main->num_rows > 0) {
        $villa_main = [];
        while ($row = $result_main->fetch_assoc()) {
            $villa_main[] = $row;
        }
    }
    ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Povila Booking</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="css/styles.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <FontAwesomeIcon icon="fa-brands fa-line" />
        <link rel="stylesheet" href="css/tabel.css">
        <link rel="stylesheet" href="css/searchs.css">
        

        <link rel="icon" type="image/png" href="poo/logo2.png">


    </head>

    <body>
        <nav>
            <div class="nav__logo">
                <img src="poo/image2.png" alt="Logo" width="22" height="80" style="display: flex; width: 100%;">
            </div>
            <ul class="nav__links">
                <li class="link">
                    <a href="#">Home</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user">
                            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="50" height="50" onclick="toggleDropdown()">
                            <div id="dropdownContent" class="dropdown-content">
                                <a href="settings.php">Settings</a>
                                <a href="booking_history.php">booking</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="link"><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <script>
            function toggleDropdown() {
                var dropdown = document.getElementById("dropdownContent");
                dropdown.classList.toggle("show");
            }

            window.onclick = function(event) {
                if (!event.target.matches('.user img')) {
                    var dropdowns = document.getElementsByClassName("dropdown-content");
                    for (var i = 0; i < dropdowns.length; i++) {
                        var openDropdown = dropdowns[i];
                        if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                        }
                    }
                }
            }
        </script>
        <?php include 'main_index.php'; ?>


        <header class="section__container header__container" style="margin-bottom: 10rem;">
            <div class="header__image__container">
                <div class="header__content"></div>
                <div class="booking__container">
                    <form id="availabilityForm" method="POST">
                        <div class="form__group">
                            <div class="input__group">
                                <input id="checkin" name="check_in" placeholder="Check In" required>
                            </div>
                        </div>
                        <div class="form__group">
                            <div class="input__group">
                                <input id="checkout" name="check_out" placeholder="Check Out" required>
                            </div>
                        </div>
                        <div class="form__group">
                            <div class="input__group">
                                <input type="number" id="people" name="people" placeholder="Guests" oninput="validateGuests(this)" min="1" max="20" step="1" required>
                            </div>
                        </div>

                        <div class="form__group">
                            <div class="input__group">
                                <input list="rooms" id="room" name="room" placeholder="Room" required>
                                <datalist id="rooms">
                                    <option value="3ห้อง">
                                    <option value="4ห้อง">
                                    <option value="5ห้อง">
                                    <option value="6ห้อง">
                                </datalist>
                            </div>
                        </div>
                        <button type="submit" class="btn">ค้นหา</button>
                    </form>
                </div>
            </div>
        </header>


        <div class="availability-status">
            <p id="availability"></p>
        </div>

        <search class="search">
            <div class="section__container search_container ">

                <div class="search__image__container">
                    <div class="frame-content">
                        <p class="top-left-text"><?= $villa_main[3]['content']; ?></p>
                        <p id="status" class="top-left-text1" style="font-size: 20px;"></p>
                        <div class="images_container1">
                            <img class="mainimg" src="<?= $villa_main[0]['image_path']; ?>" ,alt="">
                        </div>
                        <div class="images_container2">
                            <img class="mainimg1" src="<?= $villa_main[1]['image_path']; ?>" , alt="">
                            <img class="mainimg1" src="<?= $villa_main[2]['image_path']; ?>" ,alt="">
                            <img class="mainimg1" src="<?= $villa_main[3]['image_path']; ?>" , alt="">
                            <img class="mainimg1" src="<?= $villa_main[4]['image_path']; ?>" ,alt="">
                            <img class="mainimg1" src="<?= $villa_main[5]['image_path']; ?>" , alt="">
                            <img class="mainimg1" src="<?= $villa_main[6]['image_path']; ?>" , alt="">
                        </div>
                    </div>

                    <div class="font" style="display: flex; justify-content: center; flex-direction: column;">
                        <p class="title-large" style="font-size: 25px; margin: 0rem 1rem;"><?= $villa_main[0]['content']; ?></p>
                        <p class="title-medium" style="font-size: 20px; margin: 0rem 1rem;"><a></a><?= $villa_main[1]['content']; ?></p>

                        <p class="description" style="font-size: 12px; margin: 0rem 1rem;">
                            <br><?= $villa_main[2]['content']; ?>
                        </p>
                    </div>
                    <div class="toteo__container">
                        <div class="fontp" style="margin: -8rem;">
                            <div class="fontf" style="display: flex;">
                                <div style="margin: 0 0 1rem 0;">
                                    <p>check_in</p>
                                    <p id="checkin-date" style="width: fit-content; text-wrap: nowrap;"></p>
                                </div>
                                <div>
                                    <p>check_out</p>
                                    <p id="checkout-date" style="width: fit-content; text-wrap: nowrap;"></p>
                                </div>
                            </div>
                            <div>
                                <p>Room</p>
                                <p id="room-type"></p>
                            </div>
                            <div style="margin: 5px 0 0;">
                                <p class="price" id="price" name="price">฿</p>
                                <p id="security-deposit">ค่าประกัน3000</p>
                            </div>
                            <div class="button" id="bookingButtonContainer">
                                <button id="bookingButton">จอง</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </search>
        <?php include 'searchs.php'; ?>








        <script>
            $(function() {
                var fullDates = []; // เก็บวันที่เต็ม
                var checkinDate = null; // ตัวแปรสำหรับเก็บวันที่ checkin

                // ดึงวันที่เต็มจากเซิร์ฟเวอร์
                $.ajax({
                    url: 'check_full_dates.php', // ไฟล์ PHP ที่ดึงข้อมูลวันที่เต็ม
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        fullDates = response; // เก็บวันที่เต็มในตัวแปร fullDates

                        console.log("วันที่ถูกจองเต็ม:", fullDates); // ตรวจสอบวันที่เต็มใน console

                        // ตั้งค่า datepicker สำหรับ Check In
                        $("#checkin").datepicker({
                            dateFormat: "yy-mm-dd",
                            minDate: 0,
                            beforeShowDay: function(date) {
                                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                                if (fullDates.indexOf(formattedDate) !== -1) {
                                    return [false, "full-booked", "เต็ม"]; // ปิดวันที่เต็มและใส่คลาส CSS full-booked
                                } else {
                                    return [true, "available", "ว่าง"]; // เปิดวันที่ว่างและใส่คลาส CSS available
                                }
                            },
                            onSelect: function(dateText) {
                                checkinDate = new Date(dateText); // เก็บวันที่ checkin
                                var dayOfWeek = checkinDate.getDay(); // 0 = Sunday, 5 = Friday, 6 = Saturday

                                // หากเป็นวันศุกร์หรือเสาร์ เลือก "6ห้อง" อัตโนมัติ
                                if (dayOfWeek === 5 || dayOfWeek === 6) {
                                    $("#room").val("6ห้อง");
                                    $("#room").prop("disabled", true);
                                    alert("ห้อง 6ห้อง ถูกเลือกอัตโนมัติเนื่องจากเป็นวันศุกร์หรือเสาร์");
                                } else {
                                    $("#room").prop("disabled", false);
                                }

                                // กำหนด Check Out ให้เป็นวันถัดไปอัตโนมัติ
                                var checkoutDate = new Date(checkinDate.getTime() + 1 * 24 * 60 * 60 * 1000);
                                var formattedCheckoutDate = $.datepicker.formatDate('yy-mm-dd', checkoutDate);
                                $("#checkout").val(formattedCheckoutDate);

                                // กำหนดช่วงวันที่เลือกได้ใน Check Out (1 ถึง 7 วันถัดไป แต่ไม่นับวัน Check Out)
                                var checkoutMinDate = new Date(checkinDate.getTime() + 1 * 24 * 60 * 60 * 1000); // 1 วันถัดไป
                                var checkoutMaxDate = new Date(checkinDate.getTime() + 6 * 24 * 60 * 60 * 1000); // สูงสุด 6 วันถัดไป (ไม่นับวัน Check Out)
                                $("#checkout").datepicker("option", "minDate", checkoutMinDate);
                                $("#checkout").datepicker("option", "maxDate", checkoutMaxDate);

                                // ตั้งค่า beforeShowDay สำหรับ Check Out
                                $("#checkout").datepicker("option", "beforeShowDay", function(date) {
                                    var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                                    var checkinTime = checkinDate.getTime(); // เวลาของ checkin
                                    var dateCheck = date.getTime(); // เวลาของวันที่จะเช็ค (check_out)

                                    // ตรวจสอบวันที่เต็มเฉพาะช่วงก่อน check_out
                                    if (fullDates.indexOf(formattedDate) !== -1 && dateCheck > checkinTime) {
                                        return [false, "full-booked", "วันที่เต็มก่อน Check Out"];
                                    } else {
                                        return [true, "available", "ว่าง"];
                                    }
                                });

                                $("#checkout").prop('readonly', false); // ทำให้เลือก Check Out ได้อีกครั้ง
                            }
                        });

                        // ตั้งค่า datepicker สำหรับ Check Out
                        $("#checkout").datepicker({
                            dateFormat: "yy-mm-dd",
                            beforeShowDay: function(date) {
                                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                                if (fullDates.indexOf(formattedDate) !== -1) {
                                    return [false, "full-booked", "เต็ม"]; // ปิดวันที่เต็ม
                                } else {
                                    return [true, "available", "ว่าง"]; // เปิดวันที่ว่าง
                                }
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log("เกิดข้อผิดพลาดในการดึงวันที่เต็ม: " + error);
                    }
                });
            });





            // เมื่อกดปุ่มตรวจสอบความว่าง
            $(function() {
                $("#availabilityForm").on("submit", function(event) {
                    event.preventDefault(); // ป้องกันไม่ให้ฟอร์มรีเฟรชหน้า

                    // ส่งข้อมูลฟอร์มไปตรวจสอบความว่างของห้อง
                    $.ajax({
                        url: 'check_availability.php',
                        type: 'POST',
                        data: $(this).serialize(), // ส่งข้อมูลฟอร์ม
                        success: function(response) {
                            console.log(response);

                            try {
                                var data = JSON.parse(response); // แปลง response เป็น JSON
                                if (data.availability) {
                                    $("#status").text(data.availability).css("color", data.availability === "เต็ม" ? "red" : "green");
                                    $("#checkin-date").text(data.checkin);
                                    $("#checkin-date1").text(data.checkin);
                                    $("#checkout-date").text(data.checkout);
                                    $("#checkout-date1").text(data.checkout);
                                    $("#room-type").text(data.room);
                                    $("#room-type1").text(data.room);
                                    $("#price").text(data.price);
                                    $("#price1").text(data.price); // แสดงราคาที่นี่
                                    $("#security-deposit").text(data.security_deposit);

                                    // แสดงหรือซ่อนปุ่มการจองตามความว่าง
                                    if (data.is_full) {
                                        $("#bookingButtonContainer").hide(); // ซ่อนปุ่มการจองหากห้องเต็ม
                                        $("#bookingButtonContainer1").hide(); // ซ่อนปุ่มการจองอีกปุ่ม
                                    } else {
                                        $("#bookingButtonContainer").show(); // แสดงปุ่มการจองหากห้องว่าง
                                        $("#bookingButtonContainer1").show(); // แสดงปุ่มการจองอีกปุ่ม
                                    }
                                } else {
                                    $("#availability").text("No availability data.");
                                }
                            } catch (e) {
                                console.log(e);
                                $("#availability").text("Invalid response from server.");
                            }
                        },
                        error: function() {
                            $("#availability").text("Error checking availability.");
                        }
                    });
                });
            });


            function validateGuests(input) {
                if (parseInt(input.value) > 20) {
                    input.value = 20;
                }
            }

            document.getElementById('bookingButton').addEventListener('click', function() {
                const checkin = document.getElementById('checkin').value;
                const checkout = document.getElementById('checkout').value;
                const people = document.getElementById('people').value;
                const room = document.getElementById('room').value;

                if (!checkin || !checkout || !people || !room) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกข้อมูลให้ครบถ้วนก่อนทำการจอง',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                const checkinDate = new Date(checkin);
                const checkoutDate = new Date(checkout);

                if (checkoutDate <= checkinDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Check-out date must be after the check-in date.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                <?php if (isset($_SESSION['user_id'])): ?>
                    window.location = 'booking.php';
                <?php else: ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเข้าสู่ระบบก่อนทำการจอง',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'เข้าสู่ระบบ'
                    }).then(() => {
                        window.location = 'login.php';
                    });
                <?php endif; ?>
            });
            document.getElementById('bookingButton1').addEventListener('click', function() {
                const checkin = document.getElementById('checkin').value;
                const checkout = document.getElementById('checkout').value;
                const people = document.getElementById('people').value;
                const room = document.getElementById('room').value;

                if (!checkin || !checkout || !people || !room) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกข้อมูลให้ครบถ้วนก่อนทำการจอง',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                const checkinDate = new Date(checkin);
                const checkoutDate = new Date(checkout);

                if (checkoutDate <= checkinDate) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Check-out date must be after the check-in date.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'ตกลง'
                    });
                    return;
                }

                <?php if (isset($_SESSION['user_id'])): ?>
                    window.location = 'booking.php';
                <?php else: ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเข้าสู่ระบบก่อนทำการจอง',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'เข้าสู่ระบบ'
                    }).then(() => {
                        window.location = 'login.php';
                    });
                <?php endif; ?>
            });
        </script>

        <About class="About__container">
            <div class="content__container">
                <div class="image__container">
                    <img src="poo/1.jpg" alt="Pool Villa Pattaya">
                </div>
                <div class="text__container">
                    <h1 class="about-us-title">ABOUT US</h1>
                    <h1 class="villa-title">พูลวิลล่าอัมพวา</h1>
                    <p>
                        จองพูลวิลล่าอัมพวากับเรา (Pool Villa Amphawa) ที่พักหรูหรา และบ้านพักส่วนตัวที่ตอบโจทย์ความต้องการของคุณ
                        ไม่ว่าจะเป็นการพักผ่อนอย่างสงบในบรรยากาศที่เป็นธรรมชาติ และเต็มไปด้วยความเป็นส่วนตัว สัมผัสประสบการณ์การพักผ่อนที่แตกต่างกับบริการที่เหนือชั้น

                    </p>
                    <div class="highlight__box">
                        <h2>เหตุผลที่ควรเลือกใช้บริการกับเรา</h2>
                        <ul>
                            <li>คุ้มค่า ราคายุติธรรม</li>
                            <li>สะดวกสบาย ติดต่อได้ตลอด 24 ชั่วโมง</li>
                            <li>ดูแลด้วยใจ </li>
                        </ul>

                    </div>
                </div>
            </div>

            <style>
                .About__container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    padding: 5rem 2rem;
                    position: relative;
                    background-color: hsl(0, 0%, 99%);
                }

                .content__container {
                    display: flex;
                    max-width: 1200px;
                    width: 100%;
                    margin: 0 auto;
                    gap: 2rem;
                    position: relative;
                }

                .image__container {
                    flex: 1;
                    min-width: 300px;
                    position: relative;
                }

                .image__container img {
                    width: 100%;
                    height: 850px;
                    /* ปรับความสูงของรูปภาพ */
                    object-fit: cover;
                    /* ปรับให้รูปภาพครอบคลุมพื้นที่และไม่เสียสัดส่วน */
                    border-radius: 10px;
                }

                .text__container {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                    /* ทำให้ข้อความเลื่อนขึ้นด้านบน */
                    margin-top: -2rem;
                    /* เลื่อนขึ้นเล็กน้อย */
                }

                .about-us-title {
                    font-size: 5rem;
                    /* ขนาดใหญ่กว่า */
                    color: rgba(128, 128, 128, 0.5);
                    /* สีเทาจางๆ */
                    margin-bottom: 2rem;
                    text-align: center;
                }

                .villa-title {
                    font-size: 2.5rem;
                    color: #000;
                    margin-bottom: 1.5rem;
                    margin-top: 2rem;
                    /* เลื่อนลงมาหน่อย */
                }

                .text__container p {
                    font-size: 1.2rem;
                    color: #333;
                    margin-bottom: 1.5rem;
                }

                .highlight__box {
                    background-color: #f7c95c;
                    padding: 1.5rem;
                    position: absolute;
                    top: 45%;
                    /* ปรับตำแหน่งให้กล่องทับรูปภาพเล็กน้อย */
                    left: 550px;
                    /* ขยับกรอบไปทางขวาเล็กน้อยให้ชิดกับรูป */
                    width: 50%;
                    /* ลดความกว้างของกล่องเพื่อให้มีพื้นที่ทางด้านขวามากขึ้น */
                    z-index: 2;
                    /* ทำให้กล่องอยู่ด้านหน้ารูป */
                }

                .highlight__box h2 {
                    font-size: 1.8rem;
                    margin-bottom: 1rem;
                    color: #000;
                }

                .highlight__box ul {
                    list-style-type: none;
                    padding: 0;
                    margin: 0;
                }

                .highlight__box ul li {
                    font-size: 1.2rem;
                    margin-bottom: 0.5rem;
                    color: #000;
                }

                .highlight__box ul li::before {
                    content: '✔';
                    color: #000;
                    margin-right: 0.5rem;
                }

                .highlight__box button {
                    background-color: #5dbcd2;
                    border: none;
                    padding: 0.8rem 1.5rem;
                    color: #fff;
                    font-size: 1rem;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .highlight__box button:hover {
                    background-color: #499aa8;
                }

                /* ขนาดหน้าจอปกติ (เดสก์ท็อปใหญ่) */
                .about-us-title {
                    font-size: 5rem;
                }

                .villa-title {
                    font-size: 2.5rem;
                }

                .text__container p {
                    font-size: 1.2rem;
                }

                .highlight__box h2 {
                    font-size: 1.8rem;
                }

                .highlight__box ul li {
                    font-size: 1.2rem;
                }


                /* หน้าจอแท็บเล็ต (ขนาดหน้าจอระหว่าง 768px - 1024px) */
                @media (max-width: 1024px) {
                    .about-us-title {
                        font-size: 4.0rem;
                        /* ลดลง 3px */
                    }

                    .about-us-title {
                        font-size: 4rem;
                        /* ขนาดใหญ่กว่า */
                        color: rgba(128, 128, 128, 0.5);
                        /* สีเทาจางๆ */
                        margin-bottom: 2rem;
                        text-align: center;
                    }

                    .image__container img {
                        width: 100%;
                        height: 650px;
                        /* ปรับความสูงของรูปภาพ */
                        object-fit: cover;
                        /* ปรับให้รูปภาพครอบคลุมพื้นที่และไม่เสียสัดส่วน */
                        border-radius: 10px;
                    }

                    .highlight__box {
                        background-color: #f7c95c;
                        padding: 1.5rem;
                        position: absolute;
                        top: 55%;
                        /* ปรับตำแหน่งให้กล่องทับรูปภาพเล็กน้อย */
                        left: 400px;
                        /* ขยับกรอบไปทางขวาเล็กน้อยให้ชิดกับรูป */
                        width: 50%;
                        /* ลดความกว้างของกล่องเพื่อให้มีพื้นที่ทางด้านขวามากขึ้น */
                        z-index: 2;
                        /* ทำให้กล่องอยู่ด้านหน้ารูป */
                    }

                    .villa-title {
                        font-size: 2.0rem;
                        /* ลดลง 3px */
                    }

                    .text__container p {
                        font-size: 1.1rem;
                        /* ลดลง 3px */
                    }

                    .highlight__box h2 {
                        font-size: 1.3rem;
                        /* ลดลง 3px */
                    }

                    .highlight__box ul li {
                        font-size: 1.0rem;
                        /* ลดลง 3px */
                    }
                }

                /* หน้าจอมือถือใหญ่ (ขนาดหน้าจอระหว่าง 480px - 767px) */
                @media (max-width: 769px) {
                    .about-us-title {
                        font-size: 4rem;
                        /* ลดลงอีก 3px */
                    }

                    .about-us-title {
                        font-size: 3rem;
                        /* ขนาดใหญ่กว่า */
                        color: rgba(128, 128, 128, 0.5);
                        /* สีเทาจางๆ */
                        margin-bottom: 2rem;
                        text-align: center;
                    }

                    .villa-title {
                        font-size: 2rem;
                        color: #000;
                        margin-bottom: 1.5rem;
                        margin-top: 2rem;
                        /* เลื่อนลงมาหน่อย */
                    }

                    .highlight__box {
                        background-color: #f7c95c;
                        padding: 1.5rem;
                        position: absolute;
                        top: 55%;
                        /* ปรับตำแหน่งให้กล่องทับรูปภาพเล็กน้อย */
                        left: 250px;
                        /* ขยับกรอบไปทางขวาเล็กน้อยให้ชิดกับรูป */
                        width: 50%;
                        /* ลดความกว้างของกล่องเพื่อให้มีพื้นที่ทางด้านขวามากขึ้น */
                        z-index: 2;
                        /* ทำให้กล่องอยู่ด้านหน้ารูป */
                    }

                    .image__container img {
                        width: 100%;
                        height: 650px;
                        /* ปรับความสูงของรูปภาพ */
                        object-fit: cover;
                        /* ปรับให้รูปภาพครอบคลุมพื้นที่และไม่เสียสัดส่วน */
                        border-radius: 10px;
                    }

                    .villa-title {
                        font-size: 2rem;
                        /* ลดลงอีก 3px */
                    }

                    .text__container p {
                        font-size: 1rem;
                        /* ลดลงอีก 3px */
                    }

                    .highlight__box h2 {
                        font-size: 1.2rem;
                        /* ลดลงอีก 3px */
                    }

                    .highlight__box ul li {
                        font-size: 1rem;
                        /* ลดลงอีก 3px */
                    }
                }

                /* หน้าจอมือถือเล็ก (ขนาดหน้าจอเล็กกว่า 480px) */
                @media (max-width: 480px) {
                    .About__container {
                        display: none;
                    }

                    .about-us-title {
                        font-size: 4.1rem;
                        /* ลดลงอีก 3px */
                    }

                    .villa-title {
                        font-size: 1.7rem;
                        /* ลดลงอีก 3px */
                    }

                    .text__container p {
                        font-size: 0.9rem;
                        /* ลดลงอีก 3px */
                    }

                    .highlight__box h2 {
                        font-size: 1rem;
                        /* ลดลงอีก 3px */
                    }

                    .highlight__box ul li {
                        font-size: 0.9rem;
                        /* ลดลงอีก 3px */
                    }
                }
            </style>
        </About>

        <map class="map">
            <div class="search_container map_container">
                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <p class="p1">นันท์นภัส พลูวิลล่า </p>
                    <p class="p2">โครงการพูลวิลล่า ต.คลองเขิน อ.อัมพวา จ.สมุทรสงคราม 75110</p>
                    <p class="gmap">GOOGLE MAP</p>
                    <div class="map_container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4629.3529431693105!2d99.99007584881043!3d13.453483995064683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2d1c1a39528f5%3A0x7f60cbad8c2e4880!2z4LiZ4Lix4LiZ4LiX4LmM4LiZ4Lig4Lix4LiqIOC4nuC4ueC4peC4p-C4tOC4peC4peC5iOC4siDguK3guLHguKHguJ7guKfguLI!5e0!3m2!1sth!2sth!4v1724046879458!5m2!1sth!2sth"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">

                        </iframe>
                    </div>
                </div>
            </div>
        </map>




        <!-- <map class="main">
            <div class="search_container main_container" style="background-image: url('poo/1.jpg'); background-size: cover; background-position: center; position: relative;">
                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;  padding: 20px;">
                    <p class="p1" style="color: white;"><?= $villa_descriptions[0]['content']; ?></p>
                    <p class="p3" style="color: white;"><?= $villa_descriptions[1]['content']; ?></p>
                    <p class="p2" style="color: white;"><?= $villa_descriptions[2]['content']; ?></p>
                    <p class="p2" style="color: white;"><?= $villa_descriptions[3]['content']; ?></p>
                </div>
            </div>
        </map> -->
        <footer class="footer">
            <div class="footer__gold-bar"> 
                
            </div> <!-- เพิ่มแถบสีทองด้านบนของ footer -->
            
            <div class="footer__container">
                <div class="footer__section contact-info">
                    <h3>นันท์นภัส</h3>
                    <h4>CONTACT INFO</h4>
                    <p><i class="fa fa-phone"></i> T. 098 646 1451</p>
                    <p><i class="fa fa-envelope"></i> nannaphas12345678@gmail.com</p>
                    <p><i class="fa fa-map-marker"></i> โครงการพูลวิลล่า ต.คลองเขิน อ.อัมพวา จ.สมุทรสงคราม 75110</p>
                    <div class="footer__social">
                        <a href="https://www.facebook.com/profile.php?id=61553502207847"><ion-icon name="logo-facebook"></ion-icon></a>
                        <a href="https://lin.ee/yvY9Aal"><i class="bi bi-line bicustom-bi-line"></i></a>

                    </div>
                </div>
                <div class="footer__section useful-links">
                    <h4>USEFUL LINKS</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Detail Povila </a></li>
                        <li><a href="#">About Povila</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer__section gallery">
                    <h4>GALLERY</h4>
                    <div class="footer__gallery">
                        <img src="poo/1.jpg" alt="Gallery Image 1">
                        <img src="poo/2.jpg" alt="Gallery Image 2">
                        <img src="poo/3.jpg" alt="Gallery Image 2">
                        <img src="poo/4.jpg" alt="Gallery Image 2">
                        <img src="poo/5.jpg" alt="Gallery Image 2">
                        <img src="poo/6.jpg" alt="Gallery Image 2">

                    </div>
                </div>

            </div>
            <div class="footer__gold"></div>
        </footer>



        <style>
           
        </style>
        <!-- <footer class="footer">
            <div class="footer__container">
                <div class="footer__col">
                    <h3>นันท์นภัส</h3>
                    <p>
                        <a href="https://www.facebook.com/profile.php?id=61553502207847">
                            <ion-icon name="logo-facebook"></ion-icon>
                        </a>
                    </p>
                    <i class="fa-brands fa-line"></i>
                    <p>
                        <a href="https://lin.ee/yvY9Aal">
                            <img src="poo/LINE_Brand_icon.png" width="30" height="30" alt="Facebook Profile">
                        </a>
                    </p>
                </div>
                <div class="footer__col">
                    <h4>Contact Us</h4>
                    <p>T. 098 646 1451</p>
                    <p>nannaphas12345678@gmail.com</p>
                </div>
            </div>
        </footer> -->











    </body>

    </html>