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
    ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Povila Booking</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/styles.css">
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
                <img src="poo/logo1.jpg" alt="Logo" width="22" height="80" style="display: flex; width: 100%;">
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
                                <input type="number" id="people" name="people" placeholder="Guests" oninput="validateGuests(this)" required>
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
            <div class="section__container search_container">
                <div class="search__image__container">
                    <div class="frame-content">
                        <p class="top-left-text">นันท์นภัส พลูวิลล่า อัมพวา</p>
                        <p id="status" class="top-left-text1" style="font-size: 20px;"></p>
                        <div class="images_container1">
                            <img class="mainimg" src="poo/1.jpg" alt="">
                        </div>
                        <div class="images_container2">
                            <img class="mainimg1" src="poo/10.jpg" alt="">
                            <img class="mainimg1" src="poo/3.jpg" alt="">
                            <img class="mainimg1" src="poo/4.jpg" alt="">
                            <img class="mainimg1" src="poo/5.jpg" alt="">
                            <img class="mainimg1" src="poo/2.jpg" alt="">
                            <img class="mainimg1" src="poo/8.jpg" alt="">
                        </div>
                    </div>

                    <div class="font" style="display: flex; justify-content: center; flex-direction: column;">
                        <p class="title-large" style="font-size: 25px; margin: 0rem 1rem;">บ้านนันท์นภัส</p>
                        <p class="title-medium" style="font-size: 20px; margin: 0rem 1rem;"><a></a>พลูวิลล่า อัมพวา</p>

                        <p class="description" style="font-size: 12px; margin: 0rem 1rem;">
                            <br><br> Luxury Pool Villa บ้านพัก 6 ห้องนอน 6 ห้องน้ำที่ตกแต่งไปด้วยสไตล์ Luxury มีความหรูหรา<br>มาพร้อมห้องคาราโอเกะที่กว้างขวาง พร้อมรองรับลูกค้าถึง 20 ท่าน มาพร้อมกับสระว่ายน้ำ สไลด์เดอร์<br> อุปกรณ์ครัวครบครันใกล้สถานที่ท่องเที่ยวมากมาย ณ อัมพวา พร้อมให้บริการลูกค้าทุกท่าน
                        </p>
                    </div>
                    <div class="toteo__container">
                        <div class="fontp" style="margin: -8rem;">
                            <div class="fontf" style="display: flex;">
                                <div style="margin: 0 0 1rem 0;">
                                    <p>check_in</p>
                                    <p id="checkin-date" style="width: fit-content; text-wrap: nowrap;">รอ date</p>
                                </div>
                                <div>
                                    <p>check_out</p>
                                    <p id="checkout-date" style="width: fit-content; text-wrap: nowrap;">รอ date</p>
                                </div>
                            </div>
                            <div>
                                <p>Room</p>
                                <p id="room-type">รอ Room</p>
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
        </search>

        <?php include 'searchs.php'; ?>

        <script>$(function() {
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




        <map class="map">
            <div class="search_container map_container">
                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <p class="p1">นันท์นภัส พลูวิลล่า </p>
                    <p class="p2">เลขที่ 88/1 ถนน รพช. สส. 3046 อ.เมืองสมุทรสงคราม จ.สมุทรสงคราม</p>
                    <p class="gmap">GOOGLE MAP</p>
                    <div class="map_container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15524.73099838592!2d99.9906226632576!3d13.401008204121686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2d3856ac61931%3A0xb0bc2911e11f479e!2z4LiV4Liz4Lia4LilIOC5geC4oeC5iOC4geC4peC4reC4hyDguK3guLPguYDguKDguK3guYDguKHguLfguK3guIfguKrguKHguLjguJfguKPguKrguIfguITguKPguLLguKEg4Liq4Lih4Li44LiX4Lij4Liq4LiH4LiE4Lij4Liy4LihIDc1MDAw!5e0!3m2!1sth!2sth!4v1721819468748!5m2!1sth!2sth"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </map>

        <map class="main">
    <div class="search_container main_container" style="background-image: url('poo/home4.jpg'); background-size: cover; background-position: center; position: relative;">
        <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;  padding: 20px;">
            <p class="p1" style="color: white;">ที่พักพูลวิลล่าของทางเราคือตัวเลือกที่ดีที่สุดสำหรับท่าน เพราะทางเราคัดสรร </p>
            <p class="p3" style="color: white;">บ้านที่ลูกค้าอยู่แล้วประทับใจ และกลับมาใช้บริการอีกครั้ง</p>
            <p class="p2" style="color: white;">เข้าพักได้อย่างปลอดภัย ได้บ้านที่ตรงปก</p>
            <p class="p2" style="color: white;">พร้อมมีแอดมินตอบคำถามที่ลูกค้าสงสัยได้รวดเร็ว ทันใจ</p>
        </div>
    </div>
</map>


        



        <footer class="footer">
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
        </footer>




    </body>

    </html>