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
        <link rel="stylesheet" href="css/tabel.css">
        <style>
            .nav__links {
                display: flex;
                align-items: center;
            }

            .nav__links .link {
                display: flex;
                align-items: center;
            }

            .nav__links .link img {
                margin-left: 10px;
                border-radius: 50%;
                cursor: pointer;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {
                background-color: #f1f1f1;
            }

            .show {
                display: block;
            }
        </style>
    </head>

    <body>
        <nav>
            <div class="nav__logo">
                <img src="https://scontent.fkdt1-1.fna.fbcdn.net/v/t1.15752-9/451463161_439508502254984_1564988875763696941_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=9f807c&_nc_eui2=AeFLxpw7P5hzAbD0zGFx4wcQ_iqw6XCTKgf-KrDpcJMqB2ssTrxaM93qmoZDROCA15lSca9F0AG3_Aum4HlxxYYy&_nc_ohc=BErgEdBJnUwQ7kNvgGYDR0P&_nc_ht=scontent.fkdt1-1.fna&oh=03_Q7cD1QG_QMJ_iS3LVLg9FVnCJhM17wgMqHFgMIkqJvWW2npLGA&oe=66BF59DB" alt="Logo" width="22" height="80" style="display: flex; width: 100%;">
            </div>
            <ul class="nav__links">
                <li class="link">
                    <a href="#">Home</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user">
                            <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" width="50" height="50" onclick="toggleDropdown()">
                            <div id="dropdownContent" class="dropdown-content">
                                <a href="settings.php">Settings</a>
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

        <header class="section__container header__container">
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
                                <input type="text" id="people" name="people" placeholder="Guests" oninput="validateGuests(this)" required>
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
                        <p class="top-left-text" style="font-size: 25px;">นันท์นภัส พลูวิลล่า อัมพวา</p>
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
                        <p style="font-size: 25px; margin: 0rem 1rem;">Povila</p>
                        <p style="font-size: 20px; margin: 0rem 1rem;"><a></a>guests<a></a> room</p>
                        <p style="font-size: 12px; margin: 0rem 1rem;">
                            <br>บ้านนันท์นภัส พลูวิลล่า อัมพวา<br> Luxury Pool Villa บ้านพัก 6 ห้องนอน 6 ห้องน้ำที่ตกแต่งไปด้วยสไตล์ Luxury มีความหรูหรา<br>มาพร้อมห้องคาราโอเกะที่กว้างขวาง พร้อมรองรับลูกค้าถึง 20 ท่าน มาพร้อมกับสระว่ายน้ำ สไลด์เดอร์<br> อุปกรณ์ครัวครบครันใกล้สถานที่ท่องเที่ยวมากมาย ณ อัมพวา พร้อมให้บริการลูกค้าทุกท่าน
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
        
        <script>
            $(function() {
                var dateFormat = "yy-mm-dd",
                    from = $("#checkin").datepicker({
                        dateFormat: dateFormat,
                        minDate: 0
                    }).on("change", function() {
                        var checkinDate = getDate(this);
                        to.datepicker("option", "minDate", checkinDate);
                        to.datepicker("option", "minDate", new Date(checkinDate.getTime() + 24 * 60 * 60 * 1000));
                    }),
                    to = $("#checkout").datepicker({
                        dateFormat: dateFormat,
                        minDate: 1
                    }).on("change", function() {
                        var checkoutDate = getDate(this);
                        from.datepicker("option", "maxDate", checkoutDate);
                        from.datepicker("option", "maxDate", new Date(checkoutDate.getTime() - 24 * 60 * 60 * 1000));
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }
                    return date;
                }
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
                        $("#checkout-date").text(data.checkout);
                        $("#room-type").text(data.room);
                        $("#price").text(data.price);  // Display the price here
                        $("#security-deposit").text(data.security_deposit);

                        if (data.is_full) {
                            $("#bookingButtonContainer").hide(); // Hide the booking button if the room is full
                        } else {
                            $("#bookingButtonContainer").show(); // Show the booking button if there's availability
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
        </script>

        <map class="map">
            <div class="search_container map_container">
                <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
                    <p style="font-size: 30px;">นันท์นภัส พลูวิลล่า</p>
                    <p>เลขที่ 88/1 ถนน รพช. สส. 3046 อ.เมืองสมุทรสงคราม จ.สมุทรสงคราม</p>
                    <p style="border:1px solid black; border-radius: 20px; padding: 5px 15px; font-weight: 450;">GOOGLE MAP</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15524.73099838592!2d99.9906226632576!3d13.401008204121686!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2d3856ac61931%3A0xb0bc2911e11f479e!2z4LiV4Liz4Lia4LilIOC5geC4oeC5iOC4geC4peC4reC4hyDguK3guLPguYDguKDguK3guYDguKHguLfguK3guIfguKrguKHguLjguJfguKPguKrguIfguITguKPguLLguKEg4Liq4Lih4Li44LiX4Lij4Liq4LiH4LiE4Lij4Liy4LihIDc1MDAw!5e0!3m2!1sth!2sth!4v1721819468748!5m2!1sth!2sth" width="700" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </map>

        <footer class="footer">
            <div class="footer__container">
                <div class="footer__col">
                    <h3>นันท์นภัส</h3>
                </div>
                <div class="footer__col">
                    <h4>Contact Us</h4>
                    <p>098 646 1451</p>
                    <p>nannaphas12345678@gmail.com</p>
                </div>
            </div>
        </footer>
    </body>

    </html>
