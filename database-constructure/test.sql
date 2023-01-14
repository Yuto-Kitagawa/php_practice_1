-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-01-14 13:16:22
-- サーバのバージョン： 10.4.25-MariaDB
-- PHP のバージョン: 8.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `campaign`
--

CREATE TABLE `campaign` (
  `merchandise_id` varchar(16) NOT NULL,
  `rate` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `good`
--

CREATE TABLE `good` (
  `user_id` varchar(16) NOT NULL,
  `merchandise_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- テーブルのデータのダンプ `good`
--

INSERT INTO `good` (`user_id`, `merchandise_id`) VALUES
('u_63beb5f84a160', 'm_63be48559fe0d'),
('u_63beb5f84a160', 'm_63be290d32bfd');

-- --------------------------------------------------------

--
-- テーブルの構造 `history`
--

CREATE TABLE `history` (
  `merchandise_id` varchar(16) NOT NULL,
  `user_id` varchar(16) NOT NULL,
  `number` int(2) NOT NULL,
  `type` int(1) NOT NULL,
  `bought_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `history`
--

INSERT INTO `history` (`merchandise_id`, `user_id`, `number`, `type`, `bought_time`) VALUES
('m_63be290d32bfd', 'u_63beb5f84a160', 2, 0, '2023-01-13 15:06:55'),
('m_63be48559fe0d', 'u_63beb5f84a160', 2, 0, '2023-01-13 15:13:26'),
('m_63be74afe4ce0', 'u_63beb5f84a160', 99, 1, '2023-01-13 15:16:41'),
('m_63be290d32bfd', 'u_63beb5f84a160', 3, 0, '2023-01-13 17:08:00'),
('m_63be290d32bfd', 'u_63beb5f84a160', 1, 0, '2023-01-13 17:38:46');

-- --------------------------------------------------------

--
-- テーブルの構造 `merchandise`
--

CREATE TABLE `merchandise` (
  `merchandise_id` varchar(16) NOT NULL,
  `merchandise_name` varchar(30) NOT NULL,
  `merchandise_price` int(6) NOT NULL,
  `img1` varchar(255) NOT NULL,
  `img2` varchar(255) NOT NULL,
  `img3` varchar(255) NOT NULL,
  `registered_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `soldout_flag` tinyint(1) NOT NULL DEFAULT 0,
  `deadline` datetime NOT NULL DEFAULT '2999-12-31 23:59:59'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `merchandise`
--

INSERT INTO `merchandise` (`merchandise_id`, `merchandise_name`, `merchandise_price`, `img1`, `img2`, `img3`, `registered_time`, `soldout_flag`, `deadline`) VALUES
('m_63be290d32bfd', 'merchandise_sample_name1', 1300, 'merchandise_img1.jpg', 'merchandise_img2.jpg', 'merchandise_img3.jpg', '2023-01-11 03:12:13', 0, '2999-12-31 23:59:59'),
('m_63be48559fe0d', 'merchandise_sample_name2', 1400, 'merchandise_img4.jpg', 'merchandise_img5.jpg', 'merchandise_img6.jpg', '2023-01-11 05:25:41', 0, '2999-12-31 23:59:59'),
('m_63be74afe4ce0', 'food1', 1000, 'merchandise_img5.jpg', '', '', '2023-01-11 08:34:55', 0, '2999-12-31 23:59:59'),
('m_63be74d11d1cc', 'food2', 800, 'merchandise_img6.jpg', '', '', '2023-01-11 08:35:29', 0, '2999-12-31 23:59:59'),
('m_63be795f7007f', 'food3', 850, 'merchandise_img2.jpg', '', '', '2023-01-11 08:54:55', 0, '2999-12-31 23:59:59'),
('m_63be7972e79cc', 'food4', 850, 'merchandise_img3.jpg', '', '', '2023-01-11 08:55:14', 0, '2999-12-31 23:59:59'),
('m_63beb6182dea7', 'food5', 1250, 'merchandise_img7.jpg', '', '', '2023-01-11 13:14:00', 0, '2999-12-31 23:59:59'),
('m_63beb6e677423', 'food6', 2000, 'merchandise_img8.jpg', '', '', '2023-01-11 13:17:26', 0, '2999-12-31 23:59:59');

-- --------------------------------------------------------

--
-- テーブルの構造 `price`
--

CREATE TABLE `price` (
  `merchandise_id` varchar(16) NOT NULL,
  `price` int(6) NOT NULL,
  `changed_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `user_id` varchar(16) NOT NULL,
  `user_name` varchar(16) NOT NULL,
  `user_number` varchar(11) NOT NULL,
  `user_mail` varchar(50) NOT NULL,
  `user_age` int(2) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_post_number` varchar(7) NOT NULL,
  `user_address` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `registered_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_number`, `user_mail`, `user_age`, `user_birthday`, `user_post_number`, `user_address`, `password`, `registered_time`) VALUES
('u_63beb5f84a160', '北川悠斗', '07028382961', 'info@yutons.com', 21, '2001-03-01', '5360001', '大阪府大阪市城東区古市1-11-21', '$2y$10$xKs7bx8D64xeV2/8Jwgmru3Jtdu4zrhfrjRnMKldcTq/mLotn2BuW', '2023-01-11 13:13:28');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`merchandise_id`);

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
