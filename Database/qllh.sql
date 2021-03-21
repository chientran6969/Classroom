-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2020 at 06:54 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qllh`
--

-- --------------------------------------------------------

--
-- Table structure for table `baitap`
--

CREATE TABLE `baitap` (
  `IdBaiTap` int(11) NOT NULL,
  `TenBT` varchar(100) NOT NULL,
  `NoiDung` text NOT NULL,
  `Link` text NOT NULL,
  `Due` date NOT NULL,
  `IdLop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `baitap`
--

INSERT INTO `baitap` (`IdBaiTap`, `TenBT`, `NoiDung`, `Link`, `Due`, `IdLop`) VALUES
(7, 'Bài tập số 1', 'đây là yêu cầu', 'https://docs.google.com/forms/d/e/1FAIpQLSekgRsj6ETugaMvUbC6hGqQIICA4f8gh5KTRI67MIRwL2cIgA/viewform?usp=sf_link', '2020-12-31', 23);

-- --------------------------------------------------------

--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `IdBinhLuan` int(11) NOT NULL,
  `NoiDung` text NOT NULL,
  `IdThongBao` int(11) NOT NULL,
  `IdNguoiDung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`IdBinhLuan`, `NoiDung`, `IdThongBao`, `IdNguoiDung`) VALUES
(2, 'hí anh em', 1, 10),
(3, 'xin chào cô chú, xin chào các bạn', 1, 10),
(8, 'hôm nay thế nào em?\r\n', 1, 11),
(13, 'các em có thắc mắc gì kh nào', 26, 8),
(14, 'thầy ơi thầy đẹp trai quá', 26, 11);

-- --------------------------------------------------------

--
-- Table structure for table `fileupload`
--

CREATE TABLE `fileupload` (
  `IdFile` int(11) NOT NULL,
  `TenFile` varchar(50) NOT NULL,
  `Link` varchar(200) NOT NULL,
  `IdThongBao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fileupload`
--

INSERT INTO `fileupload` (`IdFile`, `TenFile`, `Link`, `IdThongBao`) VALUES
(4, 'botay.png', '../uploads/botay.png', 1),
(6, 'Screenshot (24)_LI.jpg', '../uploads/Screenshot (24)_LI.jpg', 1),
(8, 'Screenshot (105).png', '../uploads/Screenshot (105).png', 1),
(9, 'Screenshot (5).png', '../uploads/Screenshot (5).png', 1),
(22, '51800387_NguyenNgocHieu_Lab2.docx', '../uploads/51800387_NguyenNgocHieu_Lab2.docx', 26),
(23, 'Lab02.pdf', '../uploads/Lab02.pdf', 26),
(24, 'UntitledUserPersona.png', '../uploads/UntitledUserPersona.png', 26);

-- --------------------------------------------------------

--
-- Table structure for table `lop`
--

CREATE TABLE `lop` (
  `IdLop` int(11) NOT NULL,
  `TenLop` varchar(255) NOT NULL,
  `Phong` varchar(10) NOT NULL,
  `Mon` varchar(50) NOT NULL,
  `HinhLop` varchar(255) NOT NULL,
  `MaLop` int(11) NOT NULL,
  `IdGV` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lop`
--

INSERT INTO `lop` (`IdLop`, `TenLop`, `Phong`, `Mon`, `HinhLop`, `MaLop`, `IdGV`) VALUES
(23, 'HTML5', 'A0102', 'web', '../uploads/hocsinh.jpg', 79199, 8),
(24, 'CSS', 'A0103', 'web', '../uploads/p3.jpg', 10983, 8),
(25, 'Angular JS', 'C0101', 'web', '../uploads/UntitledUserPersona.png', 59252, 8);

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `IdNguoiDung` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Birth` date NOT NULL,
  `Role` int(11) NOT NULL,
  `Token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`IdNguoiDung`, `Name`, `Username`, `Password`, `Email`, `Birth`, `Role`, `Token`) VALUES
(5, 'Trần Minh Chiến', 'chientran', '$2y$10$dpfwvkqad2WfXLoRBgVVl.B4MDpdbnidm9f8fDxoVXcYD6Ryb8D96', 'chientranplus@gmail.com', '2000-01-01', 2, ''),
(6, 'Trần Minh Chiến', 'chien', '$2y$10$1qjIHKWKWXPqLmJBKeQXv.jW6hF4XxJRici/bBZ0EWI4z3VjG7OjK', 'chientranplus@gmail.co', '2000-01-01', 0, ''),
(7, 'admin', 'admin', '$2y$10$q1iZmtvdzyn335FsURkUPu/OD2qYeJ6CLzcvaPgQ6TAkigAqCu7zO', 'chientran@gmail.com', '2000-01-01', 0, ''),
(8, 'Nguyễn Ngọc Hiếu', 'giaovien', '$2y$10$5zq02aND3SThNn2cHdGE3.op1tqJqGZO.J2/x90I7.msma6a3pXBG', 'hieutravinhaxe@gmail.com', '2000-01-01', 1, ''),
(9, 'Nguyễn Ngọc', 'hieutravinh', '$2y$10$DlNuvZ5wd.pno7fLImzEOe5xe8lLr.iRxzfbwlR7Zs1Mo1aoeKirK', 'hieutravinhaxe02@gmail.com', '2000-01-01', 2, 'd5271ea083e91b1cc0732229dd68c5465fc5fdc818288'),
(10, 'Nguyễn Ngọc H', 'hieuhieu', '$2y$10$.m0g5qyHCk50yAzW1FNiOuBMyDQJGKUcQAvGqlIc2DRNIlG.pfk2a', 'hieutravinhaxe03@gmail.com', '2000-01-01', 2, '2ebb5cf5ba9edb53720a1bbf987380bd5fc5e54d46d73'),
(11, 'Nguyễn Ngọc Hiếu', 'ngocngoc', '$2y$10$Su01hSFZ6n5aUj4GPTjzkuz5F3rDaGTYNIYxiUHcq2OsKuzr8b9Vm', 'hieutravinh10@gmail.com', '2000-01-01', 2, '86eaa58aee81b878dfe5c882634116df5fc5fdba4efb9');

-- --------------------------------------------------------

--
-- Table structure for table `thanhvien`
--

CREATE TABLE `thanhvien` (
  `IdLop` int(11) NOT NULL,
  `IdNguoiDung` int(11) NOT NULL,
  `agree` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thanhvien`
--

INSERT INTO `thanhvien` (`IdLop`, `IdNguoiDung`, `agree`) VALUES
(23, 11, 1),
(23, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `thongbao`
--

CREATE TABLE `thongbao` (
  `IdThongBao` int(11) NOT NULL,
  `ChuDe` varchar(50) NOT NULL,
  `NoiDung` text NOT NULL,
  `IdLop` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `thongbao`
--

INSERT INTO `thongbao` (`IdThongBao`, `ChuDe`, `NoiDung`, `IdLop`) VALUES
(26, 'thông báo số 1', 'đây là yêu cầu cho bài tập số 1', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baitap`
--
ALTER TABLE `baitap`
  ADD PRIMARY KEY (`IdBaiTap`);

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`IdBinhLuan`);

--
-- Indexes for table `fileupload`
--
ALTER TABLE `fileupload`
  ADD PRIMARY KEY (`IdFile`);

--
-- Indexes for table `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`IdLop`),
  ADD UNIQUE KEY `IdLop` (`IdLop`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`IdNguoiDung`);

--
-- Indexes for table `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD KEY `IdLop` (`IdLop`),
  ADD KEY `IdNguoiDung` (`IdNguoiDung`);

--
-- Indexes for table `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`IdThongBao`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baitap`
--
ALTER TABLE `baitap`
  MODIFY `IdBaiTap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `IdBinhLuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fileupload`
--
ALTER TABLE `fileupload`
  MODIFY `IdFile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `lop`
--
ALTER TABLE `lop`
  MODIFY `IdLop` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `IdNguoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `IdThongBao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
