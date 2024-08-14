-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2024 at 11:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_website`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_user`
--

CREATE TABLE `login_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `profile_picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `login_user`
--

INSERT INTO `login_user` (`id`, `email`, `name`, `password`, `role`, `profile_picture`) VALUES
(15, 'kulwadee45@gmail.com', '1', '$2y$10$aKv7pjPse65kRciIoKTm0u7GJxp30qbqgR03NQ2D3fDRe/huphp1u', 'User', 'uploads/356182793_783017686943161_5396556727909400559_n.jpg'),
(16, '1@gmail.com', '11', '$2y$10$rcoiE4Ok/I6n/Pm1JzG/ou90SQOdaDa8PR7QyOllql866OAgieO1S', 'User', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg'),
(67, 'kulwadee453@gmail.com', 'user1', '$2y$10$uvEYephLHKC3FsoM9Merjes7sCfG7k7fQ.Kn3Sskn9wUT2RdAL/Hq', 'User', ''),
(68, '3@gmail.com', 'new', '1', 'user', ''),
(69, 'admin.@gmail.com', 'admin', '$2y$10$lMeKPKxmwww6ZZ.CuqcxVOgY9jhiZtbFneAwO/liq3XpZVH07ADp2', 'admin', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg'),
(74, '12@gmail.com', 'user1', '$2y$10$o41wN7t72SLH7iHrKJ.osu3qotfi3ia9MptFgXKEE/vblTPVyxnku', 'User', ''),
(75, '122@gmail.com', 'user1', '$2y$10$3tHhqblbAKSiz55cI4tjzOBWM3lVxz7WGkiHZtZoa/Qmfx1BMUkFS', 'User', ''),
(76, '11111@gmail.com', '1', '$2y$10$TlBl35I5fNupG9KZxsbKL.5CnSAFx7KjuT2UTn0jkZTdfoZd2Iziy', 'User', ''),
(78, 'admin@gmail.com', 'admin', '$2y$10$D9UEN.OEwcj2CbtfhhflleFiSORrnSvsnSBATL8ir.01fYO1p1Uxa', 'Admin', ''),
(82, '111115@gmail.com', 'user1', '$2y$10$h5kw2U6eBxJt7B/.VfgXR.y//0AExHMkuzDXD8bspVFvNwF0lOzi6', 'User', ''),
(83, '11@gmail.com', 'new', '$2y$10$4vARCiiyDZUlabP2XwfVAeHRRYaVeEJJ94PCJuswTTDKfIendFXly', 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders_db`
--

CREATE TABLE `orders_db` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `people` int(11) NOT NULL,
  `checkin` date NOT NULL,
  `checkout` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `slip` text NOT NULL,
  `user_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders_db`
--

INSERT INTO `orders_db` (`id`, `name`, `price`, `people`, `checkin`, `checkout`, `status`, `phone`, `room`, `firstname`, `lastname`, `slip`, `user_id`) VALUES
(18, 'new', 12900, 11, '2024-08-08', '2024-08-09', 'Cancel', '0', '3', '', '', '', ''),
(19, 'new', 12900, 20, '2024-08-09', '2024-08-10', 'Completed', '0', '6', '', '', '', ''),
(23, 'new', 12900, 20, '2024-08-08', '2024-08-09', 'Completed', '0', '6', '', '', '', ''),
(24, 'new', 12900, 20, '2024-08-09', '2024-08-10', 'Completed', '0', '6', '', '', '', ''),
(26, 'new', 12900, 20, '2024-08-09', '2024-08-10', 'Completed', '0', '6', '', '', '', ''),
(35, 'new', 2000, 1, '2024-06-13', '2024-06-14', 'Completed', '0', '', '', '', '', ''),
(36, 'new', 1, 1, '2024-08-09', '2024-08-10', 'Completed', '', '', '', '', '', ''),
(38, 'new', 12900, 20, '2024-08-10', '2024-08-11', 'Completed', '0613989655', '3', '', '', '', ''),
(43, 'ไม่ระบุ', 9900, 20, '2024-08-30', '2024-08-31', 'check', 'ไม่ระบุ', '6ห้อง', 'ไม่ระบุ', 'ไม่ระบุ', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg', ''),
(45, 'ไม่ระบุ', 7900, 20, '2024-08-31', '2024-09-01', 'check', 'ไม่ระบุ', '4ห้อง', 'ไม่ระบุ', 'ไม่ระบุ', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg', ''),
(47, 'panchapol pechmaneeninsai', 7900, 20, '2024-08-31', '2024-09-01', 'check', '0613989655', '4ห้อง', 'ไม่ระบุ', 'pechmaneeninsai', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg', ''),
(51, 'panchapol pechmaneeninsai', 7900, 20, '2024-08-13', '2024-08-14', 'check', '0613989655', '4ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', ''),
(53, '111', 9900, 20, '2024-08-17', '2024-08-18', 'check', '111', '6ห้อง', '1111', '11', 'uploads/7893d51529d96c609daecf25069a4e38.jpg', ''),
(55, '112', 6900, 20, '2024-08-15', '2024-08-16', 'check', '123', '3ห้อง', '123', '123', 'uploads/2019-01-29_06-14-27_406714-400x300.jpg', ''),
(56, 'panchapol pechmaneeninsai', 9900, 12, '2024-09-27', '2024-09-28', 'Waiting to enter', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/449747974_1243024893532699_6277750800584664954_n.jpg', ''),
(58, 'ปัญจพล เพชรมณีนิลใส', 7900, 12, '2024-08-22', '2024-08-23', 'check', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/reset.png', '0'),
(59, 'ปัญจพล เพชรมณีนิลใส', 7900, 12, '2024-08-22', '2024-08-23', 'check', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '0'),
(60, 'ปัญจพล เพชรมณีนิลใส', 7900, 12, '2024-08-22', '2024-08-23', 'check', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '0'),
(61, 'ปัญจพล เพชรมณีนิลใส', 7900, 12, '2024-08-22', '2024-08-23', 'Waiting to enter', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '16'),
(62, 'panchapol pechmaneeninsai', 9900, 20, '2024-11-16', '2024-11-17', 'check', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/IMG_7259.JPG', '16'),
(63, 'ปัญจพล เพชรมณีนิลใส', 14900, 20, '2024-12-21', '2024-12-22', 'check', '0613989655', '6ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/52896830_292850684742979_7165446952421687296_n.jpg', '16'),
(64, 'new', 1111111, 12, '2024-08-16', '2024-08-17', 'Waiting to enter', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `room_pirce`
--

CREATE TABLE `room_pirce` (
  `id` int(11) NOT NULL,
  `room` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `room_pirce`
--

INSERT INTO `room_pirce` (`id`, `room`, `price`) VALUES
(1, '3ห้อง', 6900.00),
(2, '4ห้อง', 7900.00),
(3, '5ห้อง', 8900.00),
(11, '6ห้อง', 9900.00);

-- --------------------------------------------------------

--
-- Table structure for table `villa_details`
--

CREATE TABLE `villa_details` (
  `id` int(11) NOT NULL,
  `detail_type` varchar(255) NOT NULL,
  `detail_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_details`
--

INSERT INTO `villa_details` (`id`, `detail_type`, `detail_description`) VALUES
(1, 'ราคาเหมาทั้งหลัง (6 ห้องนอน)', 'วันอาทิตย์ - วันพฤหัส ราคาเหมา 9,900.- บาท/คืน\r\n                      <br />วันศุกร์ ราคาเหมา 12,900.- บาท/คืน<br />วันเสาร์/วันหยุดนขัตฤกษ์\r\n                      ราคาเหมา 14,900.- บาท/คืน <br />วันขึ้นปีใหม่ วันสงกรานต์ ราคาเหมา 16,900.-                      บาท/คืน'),
(2, 'รายละเอียดแต่ละห้อง', '- ห้องนอนที่ 1 ติดสระว่ายน้ำ ประกอบด้วย เตียงนอนขนาด  5 ฟุต <br/> 2 เตียง\r\n                        ห้องน้ำในตัว TV และโต๊ะเครื่องแป้ง<br />\r\n                      - ห้องนอนที่ 2 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง <br/> ห้องน้ำในตัวพร้อม TV และโต๊ะเครื่องแป้ง<br />\r\n                      - ห้องนอนที่ 3 ห้องนอนเด็ก ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง <br />\r\n                      - ห้องนอนที่ 4 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง TV และโต๊ะเครื่องแป้ง<br />\r\n                      - ห้องนอนที่ 5 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง<br />\r\n                      - ห้องนอนที่ 6 ประกอบด้วย เตียงนอนขนาด 6 ฟุต 1 เตียง <br /> ห้องน้ำในตัว\r\n                        พร้อมอ่างจากุชชี่ TV และโต๊ะเครื่องแป้ง'),
(3, 'ราคาวันธรรมดา (วันอาทิตย์ - วันพฤหัส)', '3 ห้อง ราคาเหมา 6,900.- บาท/คืน<br />\r\n                      4 ห้อง ราคาเหมา 7,900.- บาท/คืน<br />\r\n                      5 ห้อง ราคาเหมา 8,900.- บาท/คืน'),
(4, 'ลานจอดรถ', 'จอดได้ 3 คัน'),
(5, 'ห้องทั้งหมด', '6 ห้องนอน'),
(6, 'จำนวนคนเข้าพักสูงสุด', '20 คน');

-- --------------------------------------------------------

--
-- Table structure for table `villa_home_content`
--

CREATE TABLE `villa_home_content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_home_content`
--

INSERT INTO `villa_home_content` (`id`, `title`, `description`) VALUES
(2, 'บ้านนันท์นภัส พลูวิลล่า อัมพวา', ' Luxury Pool Villa <br />บ้านพัก 6 ห้องนอน 6 ห้องน้ำ <br />รองรับลูกค้าถึง 20 ท่าน/คืน<br />ตกแต่งสไตล์\r\n              Luxury มีความหรูหรา <br />มาพร้อมห้องคาราโอเกะที่กว้างขวาง\r\n              <br /> มีสระว่ายน้ำ สไลด์เดอร์ \r\n              อุปกรณ์เครื่องครัวครบครัน ใกล้สถานที่ท่องเที่ยวมากมาย <br />\r\n              พร้อมให้บริการลูกค้าทุกท่าน');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_db`
--
ALTER TABLE `orders_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_pirce`
--
ALTER TABLE `room_pirce`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villa_details`
--
ALTER TABLE `villa_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villa_home_content`
--
ALTER TABLE `villa_home_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `orders_db`
--
ALTER TABLE `orders_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `room_pirce`
--
ALTER TABLE `room_pirce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `villa_details`
--
ALTER TABLE `villa_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `villa_home_content`
--
ALTER TABLE `villa_home_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
