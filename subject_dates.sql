-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2023-12-07 08:23:30
-- 伺服器版本： 8.0.31
-- PHP 版本： 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `laravel`
--

-- --------------------------------------------------------

--
-- 資料表結構 `subject_dates`
--

DROP TABLE IF EXISTS `subject_dates`;
CREATE TABLE IF NOT EXISTS `subject_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL COMMENT '資料日期',
  `subject` varchar(50) NOT NULL,
  `intro` text NOT NULL,
  `multiple_img` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `start_date` date NOT NULL,
  `sort` int DEFAULT NULL COMMENT '排序',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- 傾印資料表的資料 `subject_dates`
--

INSERT INTO `subject_dates` (`id`, `date`, `subject`, `intro`, `multiple_img`, `start_date`, `sort`, `created_at`, `updated_at`) VALUES
(2, '2023-12-01', '【12/01精彩內容】', '2023/12/01精彩內容', 'SubjectDate/2_img2.jpg;SubjectDate/2_img1.jpg;SubjectDate/2_img3.jpg', '2023-12-06', 0, '2023-12-06 10:02:43', '2023-12-07 08:08:13'),
(7, '2023-11-15', '【11/15精彩內容】', '11/15精彩內容', 'SubjectDate/7_img1.jpg;SubjectDate/7_img3.jpg;SubjectDate/7_img2.jpg', '2023-12-07', 2, '2023-12-07 08:07:24', '2023-12-07 08:08:13'),
(8, '2023-10-05', '【10/05精彩內容】', '10/05精彩內容', 'SubjectDate/8_img1.PNG;SubjectDate/8_img2.png;SubjectDate/8_img3.PNG', '2023-12-08', 1, '2023-12-07 08:08:06', '2023-12-07 08:08:13');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
