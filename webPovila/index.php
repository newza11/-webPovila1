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

    $sql_descriptions = "SELECT content ,image_path FROM villa_descriptions ";
    $result_descriptions = $conn->query($sql_descriptions);

    if ($result_descriptions->num_rows > 0) {
        $villa_descriptions = [];
        while ($row = $result_descriptions->fetch_assoc()) {
            $villa_descriptions[] = $row;
        }
    }

    $sql_about = "SELECT content  FROM villa_about ";
    $result_about = $conn->query($sql_about);

    if ($result_about->num_rows > 0) {
        $villa_about = [];
        while ($row = $result_about->fetch_assoc()) {
            $villa_about[] = $row;
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
        <?php include 'nav.php'; ?>


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
                <div id="book"></div>
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
                                    <option value="3ห้อง">3ห้อง</option>
                                    <option value="4ห้อง">4ห้อง</option>
                                    <option value="5ห้อง">5ห้อง</option>
                                    <option value="6ห้อง">6ห้อง</option>
                                </datalist>

                                <!-- <select id="room" name="room" required>
                                    <datalist id="rooms">
                                        <option value="" disabled selected>Select Room</option>
                                        <option value="3ห้อง">3ห้อง</option>
                                        <option value="4ห้อง">4ห้อง</option>
                                        <option value="5ห้อง">5ห้อง</option>
                                        <option value="6ห้อง">6ห้อง</option>
                                    </datalist>
                                </select> -->
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
            <div id="main"></div>

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

                        // นำผู้ใช้ไปที่ index.php#main หลังจากการตรวจสอบเสร็จสิ้น
                        window.location.href = 'index.php#main';
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




            document.getElementById('room').addEventListener('input', function() {
                var input = this.value;
                var list = document.getElementById('rooms').options;
                var isValid = false;

                for (var i = 0; i < list.length; i++) {
                    if (input === list[i].value) {
                        isValid = true;
                        break;
                    }
                }

                if (!isValid) {
                    this.value = '';
                }
            });



            function validateGuests(input) {
                // ลบตัวเลขทศนิยมออกหากมีการพิมพ์ทศนิยม
                input.value = input.value.replace(/[^0-9]/g, ''); // อนุญาตเฉพาะเลขจำนวนเต็ม

                // ตรวจสอบว่าค่าตัวเลขไม่ต่ำกว่าค่าต่ำสุดและไม่เกินค่ามากสุด
                const min = parseInt(input.min);
                const max = parseInt(input.max);
                const value = parseInt(input.value);

                if (value < min) {
                    input.value = min;
                }
                if (value > max) {
                    input.value = max;
                }
            }

            document.getElementById('bookingButton').addEventListener('click', function() {

                <?php if (!isset($_SESSION['user_id'])): ?>
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเข้าสู่ระบบก่อนทำการจอง',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'เข้าสู่ระบบ'
                    }).then(() => {
                        window.location = 'login.php';
                    });
                    return;
                <?php endif; ?>

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

                window.location = 'booking.php';
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

        <?php include 'adout.php'; ?>


        <map class="map">
            <div class="search_container map_container">
                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <p class="p1">นันท์นภัส พลูวิลล่า </p>
                    <p class="p2">โครงการพูลวิลล่า ต.คลองเขิน อ.อัมพวา จ.สมุทรสงคราม 75110</p>
                    <p class="gmap"><a href="https://www.google.com/maps/place/%E0%B8%99%E0%B8%B1%E0%B8%99%E0%B8%97%E0%B9%8C%E0%B8%99%E0%B8%A0%E0%B8%B1%E0%B8%AA+%E0%B8%9E%E0%B8%B9%E0%B8%A5%E0%B8%A7%E0%B8%B4%E0%B8%A5%E0%B8%A5%E0%B9%88%E0%B8%B2+%E0%B8%AD%E0%B8%B1%E0%B8%A1%E0%B8%9E%E0%B8%A7%E0%B8%B2/@13.454659,99.992528,16z/data=!4m6!3m5!1s0x30e2d1c1a39528f5:0x7f60cbad8c2e4880!8m2!3d13.4546592!4d99.9925277!16s%2Fg%2F11vwv0lq6l?hl=th&entry=ttu&g_ep=EgoyMDI0MDgyOC4wIKXMDSoASAFQAw%3D%3D">GOOGLE MAP</a></p>
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





        <footer class="footer">
            <div class="footer__gold-bar"></div>
            <div class="footer__container">
                <div class="footer__section contact-info">
                    <h3>นันท์นภัส</h3>
                    <h4>CONTACT INFO</h4>
                    <p><i class="fa fa-phone"></i> <?= $villa_descriptions[0]['content']; ?></p>
                    <p><i class="fa fa-envelope"></i> <?= $villa_descriptions[1]['content']; ?></p>
                    <p><i class="fa fa-map-marker"></i> <?= $villa_descriptions[2]['content']; ?></p>
                    <div class="footer__social">
                        <a href="https://www.facebook.com/profile.php?id=61553502207847"><ion-icon name="logo-facebook"></ion-icon></a>
                        <a href="https://www.instagram.com/nnongaenoey/?hl=th"><ion-icon name="logo-instagram"></ion-icon></a>
                        <a href="https://lin.ee/yvY9Aal"><i class="bi bi-line bicustom-bi-line"></i></a>

                    </div>
                </div>
                <div class="footer__section useful-links">
                    <h4>USEFUL LINKS</h4>
                    <ul>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="index.php#book">Booking Online</a></li>
                            <li><a href="index.php#detail">Detail Povila</a></li>
                            <li><a href="index.php#about">About Povila</a></li>
                            <li><a href="contact.php">Contact Us</a></li>
                        </ul>

                    </ul>
                </div>
                <div class="footer__section gallery">
                    <h4>GALLERY</h4>
                    <div class="footer__gallery">
                        <img src="<?= $villa_descriptions[0]['image_path']; ?>" alt="Gallery Image 1">
                        <img src="<?= $villa_descriptions[1]['image_path']; ?>" alt="Gallery Image 2">
                        <img src="<?= $villa_descriptions[2]['image_path']; ?>" alt="Gallery Image 2">
                        <img src="<?= $villa_descriptions[3]['image_path']; ?>" alt="Gallery Image 2">
                        <img src="<?= $villa_descriptions[4]['image_path']; ?>" alt="Gallery Image 2">
                        <img src="<?= $villa_descriptions[5]['image_path']; ?>" alt="Gallery Image 2">


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