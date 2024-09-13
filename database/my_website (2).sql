-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2024 at 12:03 PM
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
(7, 'สระว่ายน้ำ', 'ให้คุณว่ายน้ำ หรือเล่นสไลด์เดอร์เพื่อความสนุกสนาน เล่นน้ำหย่อนใจอย่างสมบูรณ์แบบและนั่งเล่นริมสระ มอบความเป็นส่วนตัวในการพักผ่อน มีสระสำหรับเด็กๆเล่นอย่างปลอดภัยมีชูชีพ และน้องเป็ดเหลืองเล่นน้ำเป็นเพื่อนอีกด้วย', 'uploads/2019-01-29_06-14-27_406714-400x300dd.jpg'),
(8, 'ห้องคาราโอเกะ', 'มีห้องคาราโอเกะ พร้อมโต๊ะสนุ๊กให้บริการสำหรับผู้ที่ชื่นชอบเสียงเพลง พร้อมทั้งมีไฟเทค เสริมความสนุกสนานของร้องเพลง ภายในห้องดีไซน์แบบ Luxury มีความหรูหราอย่างลงตัว', 'uploads/home11.jpg'),
(9, 'ห้องครัว', 'ห้องครัวอุปกรณ์ครัวครบครันใกล้สระว่ายน้ำ มีทั้งครัวไทยละครัวฝรั่ง สามารถทำอาหารได้หลากหลายอย่างละ มีเตาย่างบาร์บีคิวโต๊ะกินข้าวบริเวณริมสระน้ำ', 'uploads/ddddddddddddddddddddddd.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `phone`, `message`, `created_at`) VALUES
(15, 'ปัญจพล เพชรมณีนิลใส', 'kulwadee45@gmail.com', '0613989655', '11', '2024-08-21 07:22:24'),
(17, 'ปัญจพล เพชรมณีนิลใส', 'kulwadee45@gmail.com', '0613989655', 'ๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅๅ', '2024-08-21 07:26:12'),
(23, 'ปัญจพล', 'kulwadee45@gmail.com', '0613989655', 'ๅ', '2024-09-13 09:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `holidays_db`
--

CREATE TABLE `holidays_db` (
  `id` int(11) NOT NULL,
  `holiday_name` varchar(255) NOT NULL,
  `holiday_date` date NOT NULL,
  `holiday_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `holidays_db`
--

INSERT INTO `holidays_db` (`id`, `holiday_name`, `holiday_date`, `holiday_price`) VALUES
(2, 'Makha Bucha Day', '2024-02-26', 14900.00),
(3, 'Songkran', '2024-04-13', 16900.00),
(4, 'Songkran', '2024-04-14', 16900.00),
(5, 'Songkran', '2024-04-15', 16900.00),
(6, 'Labour Day', '2024-05-01', 14900.00),
(7, 'HM King\'s Birthday', '2024-07-28', 14900.00),
(8, 'Queen Mother\'s Birthday', '2024-08-12', 14900.00),
(9, 'Father\'s Day', '2024-12-05', 14900.00),
(10, 'Constitution Day', '2024-12-10', 14900.00),
(11, 'New Year\'s Eve', '2024-12-31', 16900.00),
(12, 'New Year\'s Day', '2025-01-01', 16900.00);

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
(15, 'kulwadee45@gmail.com', 'new', '$2y$10$tDyF.om0BPSibSne4oLke.Dk9y.ZmrxxvFKvSIrZxW57rJYDyojrG', 'User', 'uploads/317725595_619719976569850_914231069959707125_n.jpg'),
(16, '1@gmail.com', '12', '$2y$10$kKdMHcKmG2osJBfFyjJUqe1qoIp/bIBbURVx3jBH3RxFr.oATcWDu', 'User', 'uploads/317725595_619719976569850_914231069959707125_n.jpg'),
(69, 'admin.@gmail.com', 'superadmin', '$2y$10$HMlobgQTvEjvC3guHD72HeV2XXQxrbOPOJqDLPVcQn9BsTZSjWmcG', 'Admin', 'uploads/356182793_783017686943161_5396556727909400559_n.jpg'),
(78, 'admin@gmail.com', 'admin', '$2y$10$6TQembZxTZ8HvRIINcg5y.BHkS9ubFUEZ/n3u8gdePJKpnSKOUa5O', 'Admin', 'uploads/NEWHOME.jpg'),
(83, '11@gmail.com', 'new', '$2y$10$4vARCiiyDZUlabP2XwfVAeHRRYaVeEJJ94PCJuswTTDKfIendFXly', 'user', ''),
(84, 'kulwadedde45@gmail.com', 'กกกก', '$2y$10$scg1NMq5wHLRznS99xFZ8es2Q/wofYPBDU6tZ5HvkptFnlwhtmJSW', 'User', ''),
(86, 'chanlika.naa@gmail.com', 'chanlika', '$2y$10$YfQlIe51RB0b.il/NCbzO.v8Oy/ZvmgdoA2cuT4Omddo3dTOcSpYS', 'User', 'uploads/317725595_619719976569850_914231069959707125_n.jpg'),
(91, 'ad@ad.com', 'new', '$2y$10$KPFpHAuLl6gu19VjQ69CQOrL6yDPWWwf1OxdRN1rpcg.T8CBWwwKq', 'Admin', 'uploads/IMG_2337.jpeg');

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
(61, 'ปัญจพล เพชรมณีนิลใส', 7900, 12, '2024-08-22', '2024-08-23', 'Waiting to enter', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/317725595_619719976569850_914231069959707125_n.jpg', '16'),
(130, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'Completed', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/pay.jpg', '69'),
(131, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'Cancel', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/pay.jpg', '69'),
(132, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'Waiting to enter', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/pay.jpg', '69'),
(133, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'check', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/Huawei-Logo.jpg', '69'),
(134, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'check', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/Huawei-Logo.jpg', '69'),
(135, 'panchapol pechmaneeninsai', 8900, 2, '2024-08-29', '2024-08-30', 'Completed', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/Huawei-Logo.jpg', '69'),
(150, 'ryr35435435 67565465454 ', 26700, 20, '2024-09-23', '2024-09-26', 'check', '4', '5ห้อง', '4', '4', 'uploads/image (2).png', '15'),
(151, 'ปัญจพล เพชรมณีนิลใส', 35600, 1, '2024-09-26', '2024-09-30', 'check', '0613989655', '3ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/pay.jpg', '15'),
(152, 'นิว', 9900, 3, '2024-09-04', '2024-09-05', 'check', '0613989655', '6ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/pay.jpg', '78'),
(154, 'new', 8900, 4, '2024-09-18', '2024-09-19', 'check', '0613989655', '5ห้อง', 'panchapol', 'pechmaneeninsai', 'uploads/458240151_3888955781393788_7086781230857662308_n.jpg', '78'),
(156, 'ปัญจพล', 17800, 3, '2024-10-02', '2024-10-04', 'check', '0613989655', '5ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/458240151_3888955781393788_7086781230857662308_n.jpg', '15'),
(158, 'ปัญจพล', 7900, 2, '2024-09-19', '2024-09-20', 'check', '0613989655', '4ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/NEWHOME.jpg', '78'),
(160, 'ปัญจพล', 0, 0, '0000-00-00', '0000-00-00', 'check', '0613989655', 'ไม่ระบุ', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/pay.jpg', '78'),
(161, 'ปัญจพล', 16900, 5, '2025-01-01', '2025-01-02', 'check', '0613989655', '6ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/pay.jpg', '78'),
(162, 'ปัญจพล', 8900, 4, '2025-01-15', '2025-01-16', 'check', '0613989655', '5ห้อง', 'ปัญจพล', 'เพชรมณีนิลใส', 'uploads/pay.jpg', '78');

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
-- Table structure for table `villa_about`
--

CREATE TABLE `villa_about` (
  `content` varchar(255) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_about`
--

INSERT INTO `villa_about` (`content`, `id`) VALUES
('พูลวิลล่าอัมพวา', 1),
('จองพูลวิลล่าอัมพวากับเรา (Pool Villa Amphawa) ที่พักหรูหรา และบ้านพักส่วนตัวที่ตอบโจทย์ความต้องการของคุณ ไม่ว่าจะเป็นการพักผ่อนอย่างสงบในบรรยากาศที่เป็นธรรมชาติ และเต็มไปด้วยความเป็นส่วนตัว สัมผัสประสบการณ์การพักผ่อนที่แตกต่างกับบริการที่เหนือชั้น', 2),
('เหตุผลที่ควรเลือกใช้บริการกับเรา', 3),
('คุ้มค่า ราคาดี', 4),
('สะดวกสบาย ติดต่อได้ตลอด 24 ชั่วโมง', 5),
('ดูแลด้วยใจและใส่ใจ', 6);

-- --------------------------------------------------------

--
-- Table structure for table `villa_descriptions`
--

CREATE TABLE `villa_descriptions` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_descriptions`
--

INSERT INTO `villa_descriptions` (`id`, `content`, `image_path`) VALUES
(1, 'T. 098 646 1451', 'poo/1.jpg'),
(2, 'nannaphas12345678@gmail.com', 'poo/2.jpg'),
(3, 'โครงการพูลวิลล่า ต.คลองเขิน อ.อัมพวา จ.สมุทรสงคราม 75110', 'poo/3.jpg'),
(4, '', 'poo/4.jpg'),
(9, '', 'poo/5.jpg'),
(10, '', 'poo/6.jpg');

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
(1, 'ราคาเหมาทั้งหลัง (6 ห้องนอน)', 'วันอาทิตย์ - วันพฤหัส ราคาเหมา 9,900.- บาท/คืน                      <br />วันศุกร์ ราคาเหมา 12,900.- บาท/คืน<br />วันเสาร์/วันหยุดนขัตฤกษ์                      ราคาเหมา 14,900.- บาท/คืน <br />วันขึ้นปีใหม่ วันสงกรานต์ ราคาเหมา 16,900.-                      บาท/คืน'),
(2, 'รายละเอียดแต่ละห้อง', '- ห้องนอนที่ 1 ติดสระว่ายน้ำ ประกอบด้วย เตียงนอนขนาด 5 ฟุต <br /> 2 เตียง ห้องน้ำในตัว TV และโต๊ะเครื่องแป้ง<br />\n                      - ห้องนอนที่ 2 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง <br/> ห้องน้ำในตัวพร้อม TV และโต๊ะเครื่องแป้ง<br />\n                      - ห้องนอนที่ 3 ห้องนอนเด็ก ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง <br />\n                      - ห้องนอนที่ 4 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง TV และโต๊ะเครื่องแป้ง<br />\n                      - ห้องนอนที่ 5 ประกอบด้วย เตียงนอนขนาด 5 ฟุต 2 เตียง<br />\n                      - ห้องนอนที่ 6 ประกอบด้วย เตียงนอนขนาด 6 ฟุต 1 เตียง <br /> ห้องน้ำในตัว\n                        พร้อมอ่างจากุชชี่ TV และโต๊ะเครื่องแป้ง'),
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
(2, 'บ้านนันท์นภัส พลูวิลล่า อัมพวา', ' Luxury Pool Villa <br />บ้านพัก 6 ห้องนอน 6 ห้องน้ำ <br />รองรับลูกค้าถึง 20 ท่าน/คืน<br />ตกแต่งสไตล์              Luxury มีความหรูหรา <br />มาพร้อมห้องคาราโอเกะที่กว้างขวาง              <br /> มีสระว่ายน้ำ สไลด์เดอร์               อุปกรณ์เครื่องครัวครบครัน ใกล้สถานที่ท่องเที่ยวมากมาย <br />              พร้อมให้บริการลูกค้าทุกท่าน', 'uploads/home1.jpg'),
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
  `image_path` varchar(255) NOT NULL,
  `too` varchar(234) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_images`
--

INSERT INTO `villa_images` (`id`, `image_path`, `too`) VALUES
(1, 'uploads/home1.jpg', ''),
(2, 'poo/2.jpg', ''),
(3, 'poo/3.jpg', ''),
(4, 'poo/4.jpg', ''),
(5, 'poo/5.jpg', ''),
(6, 'poo/6.jpg', ''),
(7, 'poo/7.jpg', ''),
(8, 'poo/8.jpg', ''),
(9, 'poo/9.jpg', ''),
(10, 'poo/10.jpg', ''),
(11, 'poo/11.jpg', ''),
(12, 'poo/12.jpg', ''),
(13, 'poo/13.jpg', ''),
(14, 'poo/14.jpg', ''),
(15, 'poo/15.jpg', ''),
(16, 'poo/16.jpg', ''),
(17, 'poo/17.jpg', ''),
(18, 'poo/18.jpg', ''),
(19, 'poo/19.jpg', ''),
(20, 'poo/20.jpg', ''),
(21, 'poo/21.jpg', ''),
(22, 'poo/22.jpg', ''),
(23, 'uploads/home11.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `villa_main`
--

CREATE TABLE `villa_main` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `image_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `villa_main`
--

INSERT INTO `villa_main` (`id`, `content`, `image_path`) VALUES
(1, 'บ้านนันท์นภัส', 'uploads/home2.jpg'),
(2, 'พลูวิลล่า อัมพวา', 'poo/10.jpg'),
(3, 'Luxury Pool Villa บ้านพัก 6 ห้องนอน 6 ห้องน้ำที่ตกแต่งไปด้วยสไตล์Luxuryมีความหรูหรา<br>มาพร้อมห้องคาราโอเกะที่กว้างขวาง พร้อมรองรับลูกค้าถึง 20 ท่าน มาพร้อมกับสระว่ายน้ำ สไลด์เดอร์<br> อุปกรณ์ครัวครบครันใกล้สถานที่ท่องเที่ยวมากมาย ณ อัมพวา พร้อมให้บริการ', 'poo/3.jpg'),
(7, 'นันท์นภัส พลูวิลล่า อัมพวา', 'poo/4.jpg'),
(8, '', 'poo/5.jpg'),
(9, '', 'poo/2.jpg'),
(10, '', 'poo/8.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accordion_items`
--
ALTER TABLE `accordion_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays_db`
--
ALTER TABLE `holidays_db`
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
-- Indexes for table `villa_about`
--
ALTER TABLE `villa_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villa_descriptions`
--
ALTER TABLE `villa_descriptions`
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
-- Indexes for table `villa_main`
--
ALTER TABLE `villa_main`
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
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `holidays_db`
--
ALTER TABLE `holidays_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `orders_db`
--
ALTER TABLE `orders_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `room_pirce`
--
ALTER TABLE `room_pirce`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `villa_about`
--
ALTER TABLE `villa_about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `villa_descriptions`
--
ALTER TABLE `villa_descriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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

--
-- AUTO_INCREMENT for table `villa_main`
--
ALTER TABLE `villa_main`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
