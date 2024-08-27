<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>บ้านนันท์นภัส พลูวิลล่า อัมพวา</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500;600;700&display=swap");

        body {
            font-family: "Mitr", sans-serif;
        }

       
    </style>
</head>

<body>
    <div class="mobile-container">
        <p class="title-large">บ้านนันท์นภัส</p>
        <p class="title-medium">พลูวิลล่า อัมพวา</p>

        <div class="image-grid">
            <img src="poo/1.jpg" alt="Image 1" class="grid-img">
            <img src="poo/3.jpg" alt="Image 2" class="grid-img">
            <img src="poo/4.jpg" alt="Image 3" class="grid-img">
            <img src="poo/5.jpg" alt="Image 4" class="grid-img">
            <img src="poo/6.jpg" alt="Image 5" class="grid-img">
            <img src="poo/7.jpg" alt="Image 6" class="grid-img">
        </div>

        <div class="info-container" style="margin: 0 5rem;">
            <div class="check-dates">
                <div class="checkin-container">
                    <p>check_in</p>
                    <p id="checkin-date1" style="width: fit-content; text-wrap: nowrap;">รอ date</p>
                </div>
                <div class="checkout-container">
                    <p>check_out</p>
                    <p id="checkout-date1" style="width: fit-content; text-wrap: nowrap;">รอ date</p>
                </div>
            </div>

            <div class="room-container">
                <div>
                    <p>Room</p>
                    <p id="room-type1">รอ Room</p>
                </div>
                <div style="margin: 5px 0 0;">
                    <p class="price" id="price1" name="price">฿</p>
                    <p id="security-deposit">ค่าประกัน3000</p>
                </div>
                <div class="room-button" id="bookingButtonContainer1">
                    <button id="bookingButton1">จอง</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>