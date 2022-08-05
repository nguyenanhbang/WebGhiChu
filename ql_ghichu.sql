-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2022 at 03:26 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_ghichu`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ThemSuaGC` (IN `maghichu_i` BIGINT, IN `user_id_i` BIGINT, IN `iconghichu_i` TEXT, IN `tieudeghichu_i` VARCHAR(255), IN `ndghichu_i` TEXT, IN `trangthai_i` TINYINT)   BEGIN
DECLARE trave bigint DEFAULT 0;
	SET trave = 0;
    if maghichu_i = 0 then
		INSERT INTO ghichu(user_id,tieudeghichu,ndghichu,trangthai,ngaytao,ngaycapnhat,linkanhnen,iconghichu) 
        VALUES(user_id_i,tieudeghichu_i,ndghichu_i,trangthai_i,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP(),'no',iconghichu_i);
    SET trave = LAST_INSERT_ID();
    else
		UPDATE ghichu SET tieudeghichu = tieudeghichu_i , 
        ndghichu = ndghichu_i , iconghichu = iconghichu_i , 
        trangthai = trangthai_i, ngaycapnhat = CURRENT_TIMESTAMP() WHERE maghichu = maghichu_i ;
    end if;
    SELECT trave as ghichuid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `XoaGC` (IN `maghichu_i` BIGINT)   BEGIN
	DELETE FROM theghichu WHERE maghichu = maghichu_i;
    DELETE FROM ghichu WHERE maghichu = maghichu_i;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ghichu`
--

CREATE TABLE `ghichu` (
  `maghichu` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tieudeghichu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ndghichu` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT NULL,
  `ngaytao` datetime DEFAULT NULL,
  `ngaycapnhat` datetime DEFAULT NULL,
  `linkanhnen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iconghichu` text CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ghichu`
--

INSERT INTO `ghichu` (`maghichu`, `user_id`, `tieudeghichu`, `ndghichu`, `trangthai`, `ngaytao`, `ngaycapnhat`, `linkanhnen`, `iconghichu`) VALUES
(1, 1, 'Tieu de ghi chu blabla', 'dfkhgsdhbgf<div>fhgdfhbbg</div><div>djhfjhdjjhd</div><div><font size=\"6\" color=\"#0000ff\">dshfbhdsvhfhds</font></div><div><font size=\"6\" color=\"#0000ff\">jhdbjhdjf</font></div><div><font size=\"6\" color=\"#0000ff\">hdfbhdfhdjsjsskk</font></div><div>sdhbfhb</div>', 1, '2022-06-12 18:08:41', '2022-06-15 11:40:11', 'no', '😬'),
(7, 1, 'Ajax trong jquery string', 'vfhsdhvhfvsjdf<div>djhfvsjdhvfshbdf</div><div>djhvfsdvfj</div><div>djbfshdbhbf</div><div>dhvfsdhhfb</div><div>sdbjfhbjdsbjkfbjkdsn</div><div>fjbvkjbkf</div><div>dkhbfh<br>;jsdbiufbuds</div><div>hbsdhb</div><div>kjdfbhsdb</div><div>sljrrg</div>', 1, '2022-06-15 11:46:36', '2022-06-15 12:29:38', 'no', '😁'),
(11, 1, 'minh139963', 'hvcjhjhxcb<div>jbcjhbzxhj</div><div>dkjdcbjhbzx</div>', 1, '2022-06-15 12:57:22', '2022-06-15 12:57:42', 'no', '😁'),
(24, 1, 'dkjhbsdhbh bal', 'hvxjhcvhvzhxvhcb<div>shjdvcjhv</div><div>sdbcjhbj</div><div>chshdbdjbcbsd</div><div>jhdvc</div>', 1, '2022-06-15 13:18:54', '2022-06-15 14:12:44', 'no', '🙃'),
(27, 1, 'ygsdjhbhfh', '1234fkhbsjbhdd<div>hdvfhb</div><div>fjbsjdbf</div><div>jbdh</div>', 1, '2022-06-15 13:28:59', '2022-06-15 14:49:50', 'no', '😉'),
(40, 1, 'hbjhxbjbc', 'xvbhjxhbjcbhjbv<div>cvjhbxcjhbv</div><div>xvbjhxb</div><div>xbchvb</div><div>xvbhxb<br>xdvdnbjhx</div><div>bxjbjv</div><div><br></div>', 1, '2022-06-15 14:47:10', '2022-06-15 14:49:39', 'no', '😂'),
(42, 1, 'Lê&nbsp;Đức Minh💀', 'gvfhjsadjhf<div>djhfgujsyhd</div><div>dfgsjyhdjf</div><div>dfyhgsyujhdgbf</div><div>ksadhbgfijh</div>', 1, '2022-06-16 21:36:50', '2022-06-17 13:17:05', 'no', '💀'),
(43, 1, 'ajhdjd', 'jhgjhsdj<div>dhjf</div><div>kdjsj</div><div>dkjf</div><div>sdkjf</div><div>dkjf</div> ', 1, '2022-06-17 13:32:11', '2022-06-18 09:25:32', 'no', '😙'),
(44, 1, 'shhdvhd', 'hhghjsgjgd<div>dkjhc</div><div>shdj</div><div>sdhb</div>', 1, '2022-06-17 13:36:07', '2022-06-17 13:36:33', 'no', '😜'),
(45, 2, 'long cẩu', 'kdjckjsb<div>sdjkbjhbsd</div><div>sdhbfh</div><div>sdhfbjh</div><div>sdkjb</div>', 1, '2022-06-17 14:18:54', '2022-06-17 14:19:15', 'no', '🐺'),
(46, 2, 'Cẩu long&nbsp;', 'djhsjhjhjd<div>jhsdjhsd</div><div>shdbjhsb</div><div>sdvsg</div>', 1, '2022-06-17 14:19:21', '2022-06-17 14:45:43', 'no', '😁'),
(47, 2, 'bjhbdbb', 'jydhgdhgs<div>dshvsgdhnghnd</div><div>sdhvcjhvds</div><div>dsvcndsvnhvc</div><div>sdcvjhsdvhc</div><div>sdchvjhsvhc</div><div>sdcnbvsdvc</div><div>sdscjhsvdvc</div>', 1, '2022-06-17 14:19:46', '2022-06-17 14:50:25', 'no', '😅'),
(48, 2, 'jdfjgdsghdjsd', 'khfgjhdhfhdhghgfv<div>dvchgsgdvc</div><div>dchvghsdvc</div><div>dcvghsdvc</div><div>dcvshdgv</div>', 1, '2022-06-17 14:19:58', '2022-06-17 14:51:10', 'no', '😛'),
(50, 2, 'dsgsdhsd', 'gscfhgdhgfsgd<div>jhdgsjdjhv</div><div>dbcjhvshvd</div><div>sdchvghsdvvc</div><div>dchsvhdvhc</div><div>sdcgsvdgvc</div><div>schvsdhvc</div><div>hsvdhvc</div><div><br></div>', 1, '2022-06-17 14:23:21', '2022-06-17 14:50:57', 'no', '😛'),
(51, 2, 'My Home', 'dsvhgdvvsgvdhghgsvhd4sdsd<div>dvhsvdhvhc</div><div>sdchvjhvdc</div><div>dcvhsdvc</div><div>dcvhsdvhc</div><div>chgwegui</div><div>sdcvjhvsd</div>', 1, '2022-06-17 14:23:39', '2022-06-17 14:50:39', 'no', '🏠'),
(52, 2, 'ehwvjhdhbms', 'egywgye<div>shgsjhe</div><div>sdjhvhjcsv</div><div>sẹhgdysg</div><div>sdjhvhgds</div><div>ehvjhvws</div><div>sjydgys</div>', 1, '2022-06-17 14:40:13', '2022-06-17 14:50:11', 'no', '😋'),
(53, 1, 'shdhsdbb', '<font color=\"#ff0000\">jhdkjsd</font><div><font color=\"#ff0000\">sdhvsjhd</font></div><div><ol><li><font size=\"6\" color=\"#ff0000\">sdhvshbd</font></li><li><font size=\"6\" color=\"#ff0000\">sdhbsjd</font></li><li><font size=\"6\" color=\"#ff0000\">áhvsjvsdvhjsd4</font></li></ol></div><div><font color=\"#ff0000\">jhsdjh</font></div> ', 1, '2022-06-17 14:48:11', '2022-06-17 14:53:25', 'no', '📄'),
(54, 1, 'dgvgshdv', 'ywftyfwte<div>djchgvsd</div><div>ưdchvhjdv<br></div><div>ưdchvsgdv<br></div><div>ưdcjhdvsjc<br></div><div>ưehvcjh<br></div>', 1, '2022-06-17 14:48:37', '2022-06-17 14:52:18', 'no', '😙');

-- --------------------------------------------------------

--
-- Table structure for table `luudangnhap`
--

CREATE TABLE `luudangnhap` (
  `token` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ngayhethan` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `luudangnhap`
--

INSERT INTO `luudangnhap` (`token`, `user_id`, `ngayhethan`) VALUES
('02354f94b11d969b5ddafadcea1e78cf', 1, '2022-06-23 16:36:42'),
('0ef329b7285b1ffd648d7bb486ac7b87', 1, '2022-06-23 16:36:40'),
('188e541fe79495499d0229de94b8dced', 1, '2022-06-20 04:28:25'),
('32e91a97ab974e39877ff9f0d768d75c', 1, '2022-06-17 08:34:12'),
('357e29ef755bb8337c6c18ae9c44af78', 1, '2022-06-18 09:29:17'),
('3cbf7c2bac68dac56268f73eb3adbc9f', 1, '2022-06-20 16:43:32'),
('4ad65a0c1b9f52a6627a812368566f83', 2, '2022-06-16 20:07:25'),
('52047f29e4fcec66adaf9a1d92a85fa3', 2, '2022-06-16 20:07:16'),
('5469d9742196b669b3d2fce36f2538b5', 1, '2022-06-19 12:17:33'),
('5b8afd017e10f3d1111f1ea095402915', 1, '2022-06-19 15:13:27'),
('602b42b18dbed0e9d42f4a873df310d8', 2, '2022-06-17 09:04:05'),
('74cf84bb4dd1578704734673d6b566de', 1, '2022-06-17 08:34:47'),
('827566dbba2dded714c82d2061873816', 2, '2022-06-16 19:59:24'),
('83944b9bc0ca8eef34b2fd832dab8d0d', 1, '2022-06-24 06:57:48'),
('8bf75ef63f7a229ecbc73134afb7e5646665a8863fc7f032a40ee46454428bda', 1, '2022-06-16 19:29:21'),
('920dd7b4d8abfb6578c7ad8e8ab9d1bf', 1, '2022-06-21 15:06:25'),
('9b13d76fecb0d9928d62219b6a473318', 1, '2022-06-22 15:03:19'),
('9cc4e55788792c73502f616ff4665706', 1, '2022-06-19 15:15:03'),
('a61f62f9f396de63a88b7afba0a1d657', 1, '2022-06-17 08:34:01'),
('a820b115228c71bdc3ce1a841f9856fe', 1, '2022-06-19 15:15:03'),
('afc245ad1b9f5c0a1ad3d3cac10d7ae0', 1, '2022-06-25 04:25:11'),
('b0a3be7309d5ec80e79cb6484b463af1', 1, '2022-06-17 09:12:51'),
('c82b39d2cb7edd240ab9f1c7c299dbc8', 1, '2022-06-21 07:51:13'),
('ddc64486c1e2ab3833ff517f90105115', 1, '2022-06-21 07:51:12'),
('f317d5ec90dfa664a85922ab30c7bd33', 2, '2022-06-18 15:56:32'),
('f53f10d8a8dd4bf5d1f9ebf5d538b278', 1, '2022-06-25 04:25:09'),
('f5f8b486ec27556d7acadc77721b67bcebbacf3ab5aac49aea9556f82917b4a8', 1, '2022-07-09 10:58:02'),
('f6128b1c5c9f9bbed89f2369655b7f64', 1, '2022-06-21 08:15:46'),
('f90db92f4507f0add98019ffc985719d', 1, '2022-06-19 15:22:08'),
('fef4b611cfafe0b0e52526cfe882eb15', 1, '2022-06-22 08:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `linkanh` varchar(255) DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT NULL,
  `makhoiphuc` varchar(6) DEFAULT NULL,
  `ngaykichhoat` datetime DEFAULT NULL,
  `thoihanmakhoiphuc` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`id`, `name`, `email`, `password`, `linkanh`, `trangthai`, `makhoiphuc`, `ngaykichhoat`, `thoihanmakhoiphuc`) VALUES
(1, 'minh', 'minh139963@nuce.edu.vn', 'Minh1234', 'http://webghichu.com.vn/sendpic&name=1.jpg', 1, NULL, NULL, NULL),
(2, 'long', 'long129363@nuce.edu.vn', '123456', 'http://webghichu.com.vn/sendpic&name=minh.jpg', 1, NULL, NULL, NULL),
(5, 'Lê Đức Minh', 'minh01694634466@gmail.com', 'Minh1234', 'http://webghichu.com.vn/sendpic&name=minh.jpg', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `the`
--

CREATE TABLE `the` (
  `mathe` int(11) NOT NULL,
  `tenthe` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `the`
--

INSERT INTO `the` (`mathe`, `tenthe`, `user_id`) VALUES
(1, 'Học Lập Trình', 1),
(2, 'Việc làm', 1),
(3, 'Cuộc sống', 1),
(4, 'Cần nhớ', 1),
(27, 'Học tập', 2),
(28, 'làm việc', 2),
(29, 'Căn nhà', 2),
(30, 'Quan trọng', 2),
(31, 'Công việc', 2);

-- --------------------------------------------------------

--
-- Table structure for table `theghichu`
--

CREATE TABLE `theghichu` (
  `maghichu` int(11) NOT NULL,
  `mathe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `theghichu`
--

INSERT INTO `theghichu` (`maghichu`, `mathe`) VALUES
(1, 1),
(1, 2),
(1, 4),
(7, 1),
(7, 2),
(7, 3),
(11, 2),
(11, 3),
(24, 1),
(24, 2),
(24, 3),
(27, 2),
(27, 3),
(40, 1),
(40, 2),
(40, 3),
(42, 1),
(42, 2),
(43, 3),
(44, 1),
(47, 28),
(47, 29),
(50, 27),
(51, 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ghichu`
--
ALTER TABLE `ghichu`
  ADD PRIMARY KEY (`maghichu`);

--
-- Indexes for table `luudangnhap`
--
ALTER TABLE `luudangnhap`
  ADD PRIMARY KEY (`token`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `the`
--
ALTER TABLE `the`
  ADD PRIMARY KEY (`mathe`);

--
-- Indexes for table `theghichu`
--
ALTER TABLE `theghichu`
  ADD PRIMARY KEY (`maghichu`,`mathe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ghichu`
--
ALTER TABLE `ghichu`
  MODIFY `maghichu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `the`
--
ALTER TABLE `the`
  MODIFY `mathe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
