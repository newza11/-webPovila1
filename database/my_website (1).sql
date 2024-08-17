-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 10:19 AM
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
-- Table structure for table `accordion_items`
--

CREATE TABLE `accordion_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `accordion_items`
--

INSERT INTO `accordion_items` (`id`, `title`, `description`, `image_path`) VALUES
(7, 'สระว่ายน้ำ', 'ให้คุณว่ายน้ำ หรือเล่นสไลด์เดอร์เพื่อความสนุกสนาน เล่นน้ำหย่อนใจอย่างสมบูรณ์แบบและนั่งเล่นริมสระ มอบความเป็นส่วนตัวในการพักผ่อน มีสระสำหรับเด็กๆเล่นอย่างปลอดภัยมีชูชิพ และน้องเป็ดเหลืองเล่นน้ำเป็นเพื่่อนอีกด้วย', 'uploads/2019-01-29_06-14-27_406714-400x300dd.jpg'),
(8, 'ห้องคาราโอเกะ', 'มีห้องคาราโอเกะ พร้อมโต๊ะสนุ๊กให้บริการสำหรับผู้ที่ชื่นชอบเสียงเพลง พร้อมทั้งมีไฟเทค เสริมความสนุกสนานของร้องเพลง ภายในห้องดีไซน์แบบ Luxury มีความหรูหราอย่างลงตัว', 'uploads/home11.jpg'),
(9, 'ห้องครัว', 'ห้องครัวอุปกรณ์ครัวครบครันใกล้สระว่ายน้ำ มีทั้งครัวไทยละครัวฝรั่ง สามารถทำอาหารได้หลากหลายอย่างละ มีเตาย่างบาร์บีคิวโต๊ะกินข้าวบริเวณริมสระน้ำ', 'uploads/ddddddddddddddddddddddd.jpg');

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
(16, '1@gmail.com', '12', '$2y$10$kKdMHcKmG2osJBfFyjJUqe1qoIp/bIBbURVx3jBH3RxFr.oATcWDu', 'User', 'uploads/317866338_830799981476906_1744153505385101006_n.jpg'),
(68, '3@gmail.com', 'new', '$2y$10$hxtkOkpoUTh2PxJjed7SPebkJqnjjbaAPsa6fnuxTNNR7dyG3uv/.', 'User', ''),
(69, 'admin.@gmail.com', '12', '$2y$10$lMeKPKxmwww6ZZ.CuqcxVOgY9jhiZtbFneAwO/liq3XpZVH07ADp2', 'admin', 'uploads/356182793_783017686943161_5396556727909400559_n.jpg'),
(74, '12@gmail.com', 'user1', '$2y$10$o41wN7t72SLH7iHrKJ.osu3qotfi3ia9MptFgXKEE/vblTPVyxnku', 'User', ''),
(75, '122@gmail.com', 'user1', '$2y$10$3tHhqblbAKSiz55cI4tjzOBWM3lVxz7WGkiHZtZoa/Qmfx1BMUkFS', 'User', ''),
(76, '11111@gmail.com', '1', '$2y$10$TlBl35I5fNupG9KZxsbKL.5CnSAFx7KjuT2UTn0jkZTdfoZd2Iziy', 'User', ''),
(78, 'admin@gmail.com', 'admin', '$2y$10$D9UEN.OEwcj2CbtfhhflleFiSORrnSvsnSBATL8ir.01fYO1p1Uxa', 'Admin', ''),
(83, '11@gmail.com', 'new', '$2y$10$4vARCiiyDZUlabP2XwfVAeHRRYaVeEJJ94PCJuswTTDKfIendFXly', 'user', ''),
(84, 'kulwadedde45@gmail.com', 'กกกก', '$2y$10$scg1NMq5wHLRznS99xFZ8es2Q/wofYPBDU6tZ5HvkptFnlwhtmJSW', 'User', ''),
(85, 'dwd', 'wdwdwdw', '$2y$10$SsXx5oM.U/mIcpQ.uZ51TerhWKjWqWKEKL4mIHypBYoey5Uvq4lZu', 'user', '');

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
(23, 'new', 12900, 20, '2024-08-08', '2024-08-09', 'Cancel', '0', '6', '', '', '', ''),
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
(64, 'new', 1111111, 12, '2024-08-16', '2024-08-17', 'Waiting to enter', '', '', '', '', '', ''),
(65, 'panchapol pechmaneeninsai', 14900, 20, '2024-10-26', '2024-10-27', 'check', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '16'),
(66, 'panchapol pechmaneeninsai', 14900, 20, '2025-02-22', '2025-02-23', 'check', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '16'),
(67, 'panchapol pechmaneeninsai', 14900, 20, '2025-01-18', '2025-01-19', 'check', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/313911466_803608717407173_1631427847164603699_n.png', '69'),
(68, 'ปัญจพล เพชรมณีนิลใส', 9900, 20, '2024-08-20', '2024-08-21', 'Waiting to enter', '0613989655', '6ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/main-l_toyota-yaris-toyota-75590_09557_j3oiqyBlcCytNEBDFr8w2z.png', '16'),
(70, 'panchapol pechmaneeninsai', 9900, 12, '2024-09-18', '2024-09-19', 'check', '0613989655', '6ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '69');

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
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_home_content`
--

INSERT INTO `villa_home_content` (`id`, `title`, `description`, `image_path`) VALUES
(2, 'บ้านนันท์นภัส พลูวิลล่า อัมพวา', ' Luxury Pool Villa <br />บ้านพัก 6 ห้องนอน 6 ห้องน้ำ <br />รองรับลูกค้าถึง 20 ท่าน/คืน<br />ตกแต่งสไตล์              Luxury มีความหรูหรา <br />มาพร้อมห้องคาราโอเกะที่กว้างขวาง              <br /> มีสระว่ายน้ำ สไลด์เดอร์               อุปกรณ์เครื่องครัวครบครัน ใกล้สถานที่ท่องเที่ยวมากมาย <br />              พร้อมให้บริการลูกค้าทุกท่าน', 'poo\\home1.jpg'),
(4, '', '', 'poo\\home4.jpg'),
(5, '', '', 'poo/home3.jpg'),
(6, '', '', 'poo/home9.jpg'),
(7, '', '', 'poo/home7.jpg'),
(8, '', '', 'poo/home5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `villa_images`
--

CREATE TABLE `villa_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_images`
--

INSERT INTO `villa_images` (`id`, `image_path`) VALUES
(1, 'poo/1.jpg'),
(2, 'poo/2.jpg'),
(3, 'poo/3.jpg'),
(4, 'poo/4.jpg'),
(5, 'poo/5.jpg'),
(6, 'poo/6.jpg'),
(7, 'poo/7.jpg'),
(8, 'poo/8.jpg'),
(9, 'poo/9.jpg'),
(10, 'poo/10.jpg'),
(11, 'poo/11.jpg'),
(12, 'poo/12.jpg'),
(13, 'poo/13.jpg'),
(14, 'poo/14.jpg'),
(15, 'poo/15.jpg'),
(16, 'poo/16.jpg'),
(17, 'poo/17.jpg'),
(18, 'poo/18.jpg'),
(19, 'poo/19.jpg'),
(20, 'poo/20.jpg'),
(21, 'poo/21.jpg'),
(22, 'poo/22.jpg'),
(23, 'poo/23.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accordion_items`
--
ALTER TABLE `accordion_items`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `villa_images`
--
ALTER TABLE `villa_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accordion_items`
--
ALTER TABLE `accordion_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `orders_db`
--
ALTER TABLE `orders_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `villa_images`
--
ALTER TABLE `villa_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
