<?php
session_start();

$servername = "localhost";
$username = "u642212680_poolvilla";
$password = "0613989655Za";
$dbname = "u642212680_poolvilla";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่ารูปโปรไฟล์เริ่มต้น
$profile_picture = 'uploads/profiletest.jpg';

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงรูปโปรไฟล์จากฐานข้อมูล
    $query = "SELECT profile_picture FROM login_user WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // ถ้าผู้ใช้มีรูปโปรไฟล์ ให้ใช้รูปนั้น ถ้าไม่มีก็ใช้ default
    $profile_picture = !empty($user['profile_picture']) ? $user['profile_picture'] : 'uploads/profiletest.jpg';
}

// ดึงข้อมูลเกี่ยวกับวิลล่าจากตาราง villa_descriptions
$villa_descriptions = [];
$sql_descriptions = "SELECT content, image_path FROM villa_descriptions";
$result_descriptions = $conn->query($sql_descriptions);

if ($result_descriptions->num_rows > 0) {
    while ($row = $result_descriptions->fetch_assoc()) {
        $villa_descriptions[] = $row;
    }
}

// ดึงข้อมูลเกี่ยวกับเกี่ยวกับวิลล่าจากตาราง villa_about
$villa_about = [];
$sql_about = "SELECT content FROM villa_about";
$result_about = $conn->query($sql_about);

if ($result_about->num_rows > 0) {
    while ($row = $result_about->fetch_assoc()) {
        $villa_about[] = $row;
    }
}

// ดึงข้อมูลหลักของวิลล่าจากตาราง villa_main
$villa_main = [];
$sql_main = "SELECT content, image_path FROM villa_main";
$result_main = $conn->query($sql_main);

if ($result_main->num_rows > 0) {
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
                        <form id="availabilityForm" method="POST" onsubmit="redirectToMain(event)">
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
                                        <option value="3ห้อง"></option>
                                        <option value="4ห้อง"></option>
                                        <option value="5ห้อง"></option>
                                        <option value="6ห้อง"></option>
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
            <?php include 'searchs.php'; ?>

            <search class="search">
                <div id="book1"></div>


                <div class="section__container search_container ">

                    <div class="search__image__container">
                        <div class="frame-content">
                            <p class="top-left-text"><?= $villa_main[3]['content']; ?></p>
                            <p id="status" class="top-left-text1" style="font-size: 20px;"></p>
                            <div class="images_container1">
                                <img class="mainimg" src="<?= $villa_main[0]['image_path']; ?>" alt="">
                            </div>
                            <div class="images_container2">
                                <img class="mainimg1" src="<?= $villa_main[1]['image_path']; ?>" alt="">
                                <img class="mainimg1" src="<?= $villa_main[2]['image_path']; ?>" alt="">
                                <img class="mainimg1" src="<?= $villa_main[3]['image_path']; ?>" alt="">
                                <img class="mainimg1" src="<?= $villa_main[4]['image_path']; ?>" alt="">
                                <img class="mainimg1" src="<?= $villa_main[5]['image_path']; ?>" alt="">
                                <img class="mainimg1" src="<?= $villa_main[6]['image_path']; ?>" alt="">
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

            </search>




            <script>
                $(function() {
                    var fullDates = [];
                    var holidayDates = [];
                    var checkinDate = null;

                    $.ajax({
                        url: 'check_full_dates.php',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            fullDates = response.fullDates;
                            holidayDates = response.holidayDates;

                            console.log("วันที่ถูกจองเต็ม:", fullDates)

                            $("#checkin").datepicker({
                                dateFormat: "yy-mm-dd",
                                minDate: 0,
                                beforeShowDay: function(date) {
                                    var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                                    if (fullDates.indexOf(formattedDate) !== -1) {
                                        return [false, "full-booked", "เต็ม"];
                                    } else {
                                        return [true, "available", "ว่าง"];
                                    }
                                },
                                onSelect: function(dateText) {
                                    checkinDate = new Date(dateText);
                                    var dayOfWeek = checkinDate.getDay();
                                    var formattedCheckinDate = $.datepicker.formatDate('yy-mm-dd', checkinDate);

                                    // ตรวจสอบว่าเป็นวันหยุดหรือไม่
                                    if (holidayDates.includes(formattedCheckinDate)) {
                                        $("#room").val("6ห้อง");
                                        $("#room").prop("disabled", true);
                                        Swal.fire({
                                            title: '6ห้อง ถูกเลือกอัตโนมัติ',
                                            text: 'เนื่องจากเป็นวันหยุดหยุดนขัตฤกษ์,วันปีใหม่,สงกรานต์',
                                            icon: 'info',
                                            confirmButtonText: 'ตกลง'
                                        });
                                    }
                                    // ตรวจสอบว่าเป็นวันศุกร์หรือเสาร์หรือไม่ (ไม่รวมวันหยุด)
                                    else if (dayOfWeek === 5 || dayOfWeek === 6) {
                                        $("#room").val("6ห้อง");
                                        $("#room").prop("disabled", true);
                                        Swal.fire({
                                            title: '6ห้อง ถูกเลือกอัตโนมัติ',
                                            text: 'เนื่องจากเป็นวันศุกร์หรือเสาร์',
                                            icon: 'info',
                                            confirmButtonText: 'ตกลง'
                                        });
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

                                    $("#checkout").prop('readonly', true); // ตั้งค่า readonly
                                }
                            }).attr("readonly", true); // ตั้งค่า readonly ที่นี่

                            // ตั้งค่า datepicker สำหรับ Check Out
                            $("#checkout").datepicker({
                                dateFormat: "yy-mm-dd",
                                beforeShowDay: function(date) {
                                    var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                                    if (fullDates.indexOf(formattedDate) !== -1) {
                                        return [false, "full-booked", "เต็ม"];
                                    } else {
                                        return [true, "available", "ว่าง"];
                                    }
                                }
                            }).attr("readonly", true); // ตั้งค่า readonly ที่นี่

                            // ปิดแป้นพิมพ์เมื่อคลิกที่ input
                            $("#checkin").on('focus', function(e) {
                                e.preventDefault();
                                $(this).datepicker("show");
                            });

                            $("#checkout").on('focus', function(e) {
                                e.preventDefault();
                                $(this).datepicker("show");
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("เกิดข้อผิดพลาดในการดึงวันที่เต็ม: " + error);
                        }
                    });
                });
            






            $(function() {
            $("#availabilityForm").on("submit", function(event) {
            event.preventDefault();

            $.ajax({
            url: 'check_availability.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
            console.log(response);

            try {
            var data = JSON.parse(response);
            if (data.availability) {
            $("#status").text(data.availability).css("color", data.availability === "เต็ม" ? "red" : "green");
            $("#checkin-date").text(data.checkin);
            $("#checkin-date1").text(data.checkin);
            $("#checkout-date").text(data.checkout);
            $("#checkout-date1").text(data.checkout);
            $("#room-type").text(data.room);
            $("#room-type1").text(data.room);
            $("#price").text(data.price);
            $("#price1").text(data.price);
            $("#security-deposit").text(data.security_deposit);

            if (data.is_full) {
            $("#bookingButtonContainer").hide();
            $("#bookingButtonContainer1").hide();
            } else {
            $("#bookingButtonContainer").show();
            $("#bookingButtonContainer1").show();
            }

            // เช็คว่ามี #book1 หรือไม่
            const book1Section = document.getElementById('book1');
            const book2Section = document.getElementById('book2');

            if (book1Section) {
            window.location.href = 'index.php#book2';
            } else if (book2Section) {
            window.location.href = 'index.php#book1';
            } else {
            // ถ้าไม่มีทั้งสอง #book1 และ #book2
            console.log("Both book1 and book2 are not found.");
            }

            setTimeout(() => {
            // เลื่อนลงไปยังส่วนที่พบ
            if (book1Section) {
            book1Section.scrollIntoView({
            behavior: 'smooth'
            });
            } else if (book2Section) {
            book2Section.scrollIntoView({
            behavior: 'smooth'
            });
            }
            }, 500);
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
                if (input===list[i].value) {
                isValid=true;
                break;
                }
                }

                if (!isValid) {
                this.value='' ;
                }
                });

                
                function validateGuests(input) {

                input.value=input.value.replace(/[^0-9]/g, '' );


                const min=parseInt(input.min);
                const max=parseInt(input.max);
                const value=parseInt(input.value);

                if (value < min) {
                input.value=min;
                }
                if (value> max) {
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
                    icon: 'warning' ,
                    title: 'Check-out date must be after the check-in date.' ,
                    confirmButtonColor: '#3085d6' ,
                    confirmButtonText: 'ตกลง'
                    });
                    return;
                    }

                    window.location='booking.php' ;
                    });

                    document.getElementById('bookingButton1').addEventListener('click', function() {

                    <?php if (!isset($_SESSION['user_id'])): ?>
                    Swal.fire({
                    icon: 'warning' ,
                    title: 'กรุณาเข้าสู่ระบบก่อนทำการจอง' ,
                    confirmButtonColor: '#3085d6' ,
                    confirmButtonText: 'เข้าสู่ระบบ'
                    }).then(()=> {
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
                    icon: 'warning' ,
                    title: 'Check-out date must be after the check-in date.' ,
                    confirmButtonColor: '#3085d6' ,
                    confirmButtonText: 'ตกลง'
                    });
                    return;
                    }

                    window.location='booking.php' ;
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
                                    <img src="<?= $villa_descriptions[0]['image_path']; ?>" alt="Gallery Image 1" onclick="openModal();currentSlide(1)">
                                    <img src="<?= $villa_descriptions[1]['image_path']; ?>" alt="Gallery Image 2" onclick="openModal();currentSlide(2)">
                                    <img src="<?= $villa_descriptions[2]['image_path']; ?>" alt="Gallery Image 3" onclick="openModal();currentSlide(3)">
                                    <img src="<?= $villa_descriptions[3]['image_path']; ?>" alt="Gallery Image 4" onclick="openModal();currentSlide(4)">
                                    <img src="<?= $villa_descriptions[4]['image_path']; ?>" alt="Gallery Image 5" onclick="openModal();currentSlide(5)">
                                    <img src="<?= $villa_descriptions[5]['image_path']; ?>" alt="Gallery Image 6" onclick="openModal();currentSlide(6)">
                                </div>
                                <div id="lightboxModal" class="modal">
                                    <span class="close cursor" onclick="closeModal()">&times;</span>
                                    <div class="modal-content">
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[0]['image_path']; ?>" alt="Gallery Image 1">
                                        </div>
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[1]['image_path']; ?>" alt="Gallery Image 2">
                                        </div>
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[2]['image_path']; ?>" alt="Gallery Image 3">
                                        </div>
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[3]['image_path']; ?>" alt="Gallery Image 4">
                                        </div>
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[4]['image_path']; ?>" alt="Gallery Image 5">
                                        </div>
                                        <div class="mySlides">
                                            <img src="<?= $villa_descriptions[5]['image_path']; ?>" alt="Gallery Image 6">
                                        </div>
                                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="footer__gold"></div>
                    </footer>
                    <!-- <script>
                function openModal() {
                    document.getElementById("lightboxModal").style.display = "block";
                }

                function closeModal() {
                    document.getElementById("lightboxModal").style.display = "none";
                }

                var slideIndex = 1;
                showSlides(slideIndex);

                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }

                function currentSlide(n) {
                    showSlides(slideIndex = n);
                }

                function showSlides(n) {
                    var slides = document.getElementsByClassName("mySlides");
                    if (n > slides.length) {
                        slideIndex = 1;
                    }
                    if (n < 1) {
                        slideIndex = slides.length;
                    }
                    for (var i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slides[slideIndex - 1].style.display = "block";
                }
            </script> -->




                    <!-- <style>
                Modal styling
                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    padding-top: 100px;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.9);
                }

                .modal-content {
                    position: relative;
                    margin: auto;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    width: 300px;
                    height: 300px;
                }

                .mySlides {
                    display: none;
                    max-width: 100%;
                    max-height: 100%;
                    width: 300px;
                    /* Fixed width */
                    height: 300px;
                    /* Fixed height */
                }

                .prev,
                .next {
                    cursor: pointer;
                    position: absolute;
                    top: 50%;
                    padding: 16px;
                    color: white;
                    font-weight: bold;
                    font-size: 24px;
                    user-select: none;
                    background-color: rgba(0, 0, 0, 0.5);
                    transform: translateY(-50%);
                }

                .prev {
                    left: 0;
                }

                .next {
                    right: 0;
                }

                .close {
                    position: absolute;
                    top: 15px;
                    right: 35px;
                    color: white;
                    font-size: 40px;
                    font-weight: bold;
                    cursor: pointer;
                }
            </style> -->
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