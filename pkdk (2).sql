-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2025 at 06:35 AM
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
-- Database: `pkdk`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image_url`, `link_url`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'DatLich.jpg', '1', 1, '2025-05-27 13:18:25', '2025-06-22 12:39:53', NULL),
(12, '91c0d15501634c8985ec5898c9a77572.jpg', '2', 1, '2025-05-27 13:24:42', '2025-06-22 12:39:44', NULL),
(13, 'banner_bed-1-scaled.jpg', '3', 1, '2025-05-27 13:24:52', '2025-06-22 12:39:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `benhnhan`
--

CREATE TABLE `benhnhan` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'patient',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benhnhan`
--

INSERT INTO `benhnhan` (`id`, `username`, `fullname`, `email`, `phone`, `dob`, `address`, `avatar`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Nguyen Van Truong', 'admin@gmail.com', '0915199188', '1998-11-18', 'Bắc Ninh', NULL, 'admin', '2025-06-25 15:51:13', '2025-06-29 08:31:05'),
(7, 'thanh', 'nguyen cong thanh', 'thanhnct@gmail.com', '0343621792', '2002-06-20', 'Bắc Ninh', 'avatar_7_1751185575.png', 'user', '2025-06-06 07:52:27', '2025-06-29 08:26:15'),
(10, 'nhung', 'Nguyen Hong Nhung', 'nhung@gmail.com', '0335451860', '2001-11-28', 'Hà Nội', 'avatar_10_1751185539.jpg', 'user', '2025-06-07 03:36:23', '2025-06-29 08:25:39'),
(20, 'nctthanh', 'Nguyễn Công Thành', 'thanh@gmail.com', '0335451860', '0000-00-00', 'Tiên Du, Bắc Ninh', 'avatar_20_1751410358.jpg', 'user', '2025-07-01 22:52:20', '2025-07-01 22:52:44');

-- --------------------------------------------------------

--
-- Table structure for table `certifications`
--

CREATE TABLE `certifications` (
  `id` int(11) NOT NULL,
  `certification_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certifications`
--

INSERT INTO `certifications` (`id`, `certification_image`) VALUES
(7, '7 (1).jpg'),
(8, '7 (1).jpg'),
(9, '7 (1).jpg'),
(10, '7 (1).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `datlichhen`
--

CREATE TABLE `datlichhen` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `appointment_time` varchar(50) NOT NULL,
  `appointment_date` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT 0,
  `benhnhan_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datlichhen`
--

INSERT INTO `datlichhen` (`id`, `name`, `phone`, `email`, `appointment_time`, `appointment_date`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `confirmed`, `benhnhan_id`, `created_by`) VALUES
(19, 'Nguyen Hong Nhung', '0335451860', 'nhung@gmail.com', '14:00', '2025-06-20', NULL, '2025-06-15 16:46:37', '2025-06-25 14:42:48', NULL, 1, NULL, 10),
(24, 'nguyen cong thanh', '0343621792', 'thanhnct@gmail.com', '09:00', '2025-06-29', NULL, '2025-06-18 13:57:43', '2025-06-29 15:31:37', NULL, 1, NULL, 7),
(34, 'nguyen cong thanh', '0343621792', 'thanhnct@gmail.com', '09:00', '2025-06-30', NULL, '2025-06-26 14:12:25', '2025-06-26 14:12:25', NULL, 0, NULL, 7),
(35, 'Nguyen Hong Nhung', '0335451860', 'nhung@gmail.com', '16:00', '2025-07-02', NULL, '2025-06-26 14:16:43', '2025-06-29 19:10:05', NULL, 0, NULL, 10),
(38, 'Nguyen Hong Nhung', '0335451860', 'nhung@gmail.com', '17:00', '2025-07-10', NULL, '2025-07-02 05:24:23', '2025-07-02 05:24:42', NULL, 0, NULL, 10),
(58, 'Nguyễn Công Thành', '0335451860', 'thanh@gmail.com', '15:00', '2025-07-10', NULL, '2025-07-02 07:41:55', '2025-07-02 07:41:55', NULL, 0, NULL, 20),
(59, 'Nguyễn Công Thành', '0335451860', 'thanh@gmail.com', '14:00', '2025-07-18', NULL, '2025-07-02 07:50:54', '2025-07-02 07:50:54', NULL, 0, NULL, 20);

-- --------------------------------------------------------

--
-- Table structure for table `dichvu`
--

CREATE TABLE `dichvu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dichvu`
--

INSERT INTO `dichvu` (`id`, `title`, `content`, `image_url`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'Phẫu thuật Amiđan', '<p>Mô tả: Phẫu thuật cắt bỏ amiđan trong các trường hợp viêm amiđan mạn tính, tái phát nhiều lần hoặc biến chứng.</p>', 'images (3).jpg', 1, '2025-01-15 17:29:55', '2025-06-27 12:55:48', NULL),
(12, 'Điều trị viêm xoang', '<p>Mô tả: Các phương pháp điều trị nội khoa hoặc ngoại khoa cho viêm xoang cấp và mạn tính, bao gồm rửa mũi, thuốc và phẫu thuật nội soi xoang.</p>', 'images (2).jpg', 1, '2025-05-27 13:53:23', '2025-06-27 12:58:13', NULL),
(13, 'Điều trị viêm tai giữa ', '<p>Mô tả: Điều trị viêm tai giữa cấp và mạn tính bằng thuốc hoặc phẫu thuật (đặt ống thông khí, vá màng nhĩ).</p>', 'viemtaigiua).jpg', 1, '2025-05-27 13:55:25', '2025-06-27 12:57:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gioithieu`
--

CREATE TABLE `gioithieu` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gioithieu`
--

INSERT INTO `gioithieu` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(11, 'Giới Thiệu', '<h2>Giới Thiệu Về Phòng Khám Chuyên Khoa Tai Mũi Họng</h2><p>Phòng khám chuyên khoa tai mũi họng chuyên thăm khám và điều trị các bệnh liên quan đến Tai – Mũi – Họng. Đội ngũ nhân viên là các bác sĩ chuyên khoa có chuyên môn cao, sử dụng trang thiết bị và phương pháp điều trị tiên tiến nhất. Tại đây chúng tôi luôn ân cần đón tiếp, chăm sóc sức khỏe bệnh nhân chu đáo và chuyên nghiệp. Trả lời các câu hỏi và giải thích những thắc mắc của bệnh nhân đồng thời tư vấn trực tiếp&nbsp;chăm sóc sức khỏe người bệnh.</p>', 1, '2025-05-27 19:55:35', '2025-05-27 19:55:35', NULL),
(12, 'Chất lượng dịch vụ', '<p>Dịch vụ tại phòng khám cam kết mang lại trải nghiệm an tâm cho người bệnh với chất lượng khám chữa bệnh chuyên nghiệp và uy tín. Hỗ trợ chu đáo, tận tâm xuyên suốt quá trình khám, chữa bệnh và tái khám. Đảm bảo khách hàng không chỉ chữa trị dứt điểm mà còn cảm thấy thoải mái ngay cả khi tiếp xúc với môi trường khám chữa bệnh.</p>', 1, '2025-05-27 19:56:27', '2025-06-27 05:52:45', NULL),
(13, 'Trải nghiệm của bệnh nhân tại phòng khám.', '<p>Khi đến các cơ sở khám chữa bệnh khác bệnh nhân thường “hiếm khi” được một bác sĩ khám, điều trị và theo dõi trong suốt quá trình điều trị, như vậy bác sĩ không nắm được chính xác tình hình diễn biến bệnh qua từng giai đoạn dẫn đến khả năng điều trị bệnh lý không đạt hiệu quả cao nhất. Tại phòng khám chuyên khoa Tai – Mũi – Họng toàn bộ bệnh nhân được khám và theo dõi diễn biến bệnh bởi 1 bác sĩ duy nhất, điều trị bệnh theo cơ chế gốc giúp bệnh nhân không những khỏi bệnh mà còn giảm thiểu tối đa nguy cơ viêm tái phát, tiết kiệm cho người bệnh chi phí và thời gian đi lại. Đây cũng là yếu tố tiên quyết tạo nên thành công trong chăm sóc và điều trị bệnh về Tai – Mũi – Họng ở phòng khám ck Tai Mũi Họng.</p>', 1, '2025-05-27 19:56:46', '2025-05-27 19:57:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hosobenhan`
--

CREATE TABLE `hosobenhan` (
  `id` int(11) NOT NULL,
  `benhnhan_id` int(11) NOT NULL,
  `bacsi` varchar(255) DEFAULT NULL,
  `ngaykham` date NOT NULL,
  `trangthai` varchar(100) DEFAULT NULL,
  `ghichu` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hosobenhan`
--

INSERT INTO `hosobenhan` (`id`, `benhnhan_id`, `bacsi`, `ngaykham`, `trangthai`, `ghichu`, `created_at`) VALUES
(19, 10, 'Bác Sĩ Trường', '2025-06-12', 'completed', 'viêm họng\r\n', '2025-06-19 10:26:14'),
(21, 10, 'Bác Sĩ Trường', '2025-06-28', 'active', 'cái này em không biết nói gì Google', '2025-06-27 16:34:34'),
(22, 20, 'Bác Sĩ Trường', '2025-07-10', 'active', 'Viêm họng\r\n\r\ntriệu chứng của viêm họng mãn tính là đau họng kéo dài', '2025-07-02 07:49:09'),
(23, 20, 'Bác Sĩ Trường', '2025-07-11', 'active', 'Viêm amidan\r\nChán ăn \r\nCơ thể mệt mỏi\r\nTiểu ít', '2025-07-02 07:50:30'),
(24, 20, 'Bác Sĩ Trường', '2025-07-18', 'active', 'Viêm họng\r\n\r\ntriệu chứng của viêm họng', '2025-07-02 08:14:20');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `primary_color` varchar(7) NOT NULL,
  `secondary_color` varchar(7) NOT NULL,
  `bg_color` varchar(7) NOT NULL,
  `text_color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `zalo` varchar(255) DEFAULT NULL,
  `tiktok` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `company_email` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_media`
--

INSERT INTO `social_media` (`id`, `facebook`, `zalo`, `tiktok`, `phone_number`, `created_at`, `updated_at`, `company_email`, `company_address`) VALUES
(1, 'https://facebook/', 'https://zalo.me/0343621792', 'https://tiktok.com/', '1234567890', '2025-01-15 10:33:41', '2025-06-25 07:53:07', 'congthanh04092003@gmail.com', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `taimuihong`
--

CREATE TABLE `taimuihong` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taimuihong`
--

INSERT INTO `taimuihong` (`id`, `title`, `content`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 'Viêm họng', 'Đây là bệnh lý về họng rất phổ biến, đặc biệt hay xảy ra ở trẻ em, gồm 2 giai đoạn là cấp tính và mãn tính. Dấu hiệu viêm họng bao gồm cảm giác đau hoặc ngứa ngáy ở cổ họng khi nuốt hoặc nói. Cổ họng bị sưng lên, tấy đỏ, có mảng trắng hoặc vệt mủ. Nếu đau họng do virus cảm lạnh gây nên, người bệnh cũng có thể bị sổ mũi, ho, có thể sốt và cảm thấy rất mệt mỏi.&nbsp;', 1, '2025-06-08 16:13:38', '2025-06-26 15:20:18', NULL),
(10, 'Viêm họng hạt', 'Là sự tiến triển của viêm họng mạn tính, viêm nhiễm tái diễn nhiều lần khiến các thể lympho trong họng và amidan phì đại, kích ứng, phát triển thành dạng hạt. Một số biểu hiện của viêm họng hạt như ngứa họng, vướng họng; ho khan có đờm; cảm giác nóng rát ở cổ họng; hơi khàn tiếng; kèm theo biểu hiện buồn nôn, thỉnh thoảng chóng mặt.\r\n', 1, '2025-06-08 16:13:55', '2025-06-26 15:20:12', NULL),
(11, 'Viêm VA', 'VA là một tổ chức lympho nằm ở vòm họng, là một phần thuộc vòng bạch huyết thường phát triển mạnh ở lứa tuổi nhỏ và bắt đầu thoái triển từ 5 – 6 tuổi trở đi. Bệnh gồm 2 giai đoạn cấp tính và mãn tính với những dấu hiệu điển hình như sốt cao 38–40°C; nghẹt mũi, chảy nước mũi màu vàng/xanh; ho khan hoặc ho có đờm; thở khò khè, khó ngủ,… Bệnh nếu không được điều trị sớm có thể gây viêm nhiễm sang họng, mũi,…', 1, '2025-06-08 16:14:09', '2025-06-26 15:20:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tintuc`
--

CREATE TABLE `tintuc` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tintuc`
--

INSERT INTO `tintuc` (`id`, `title`, `content`, `image_url`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(9, 'Điều trị viêm tai giữa', '<p>Điều trị viêm tai giữa: Mô tả: Điều trị viêm tai giữa cấp và mạn tính bằng thuốc hoặc phẫu thuật (đặt ống thông khí, vá màng nhĩ).&nbsp;</p>', 'viemtaigiua).jpg', 1, '2025-01-15 17:31:54', '2025-06-27 13:03:49', NULL),
(10, 'Điều trị viêm xoang', '<p>Điều trị viêm xoang: Mô tả: Các phương pháp điều trị nội khoa hoặc ngoại khoa cho viêm xoang cấp và mạn tính, bao gồm rửa mũi, thuốc và phẫu thuật nội soi xoang.</p>', 'images (2).jpg', 1, '2025-01-15 17:32:17', '2025-06-27 13:08:09', NULL),
(11, 'Phẫu thuật Amiđan', '<p>Phẫu thuật Amiđan: Mô tả: Phẫu thuật cắt bỏ amiđan trong các trường hợp viêm amiđan mạn tính, tái phát nhiều lần hoặc biến chứng.&nbsp;</p>', 'viem amidan.jpg', 1, '2025-01-15 17:32:42', '2025-06-27 13:03:54', NULL),
(12, 'Phẫu thuật Amiđan', '<p>Amidan là gồm 2 tổ chức bạch huyết (lympho) nằm ở phía sau của hầu họng, cũng là nơi giao nhau của đường ăn uống và đường hô hấp. Đây là cơ quan đóng vai trò quan trọngtrong việc bảo vệ đường hô hấp bằng hai cách (1) amidan ngăn chặn sự xâm nhập của các vi sinh vật gây bệnh như vi khuẩn, nấm và virus, (2) amindan tiết ra các kháng thể chống lại nhiễm khuẩn do các tác nhân gây bệnh. Viêm amidan là bệnh phổ biến gặp ở mọi lứa tuổi trong cộng đồng, gây ra những triệu chứng đau rát họng, khó nuốt, thậm chí nếu không được chẩn đoán sớm và điều trị kịp thời, diễn biến của bệnh sẽ trở nên nặng hơn, thậm chí dẫn tới nhiễm khuẩn máu, viêm hệ hô hấp và viêm cầu thận. Tuy nhiên, đôi khi viêm amidan được chẩn đoán nhầm với các bệnh đường hô hấp</p>', 'images (3).jpg', 1, '2025-06-08 16:12:12', '2025-06-27 13:03:56', NULL),
(13, 'Viêm amidan', '<p>Amidan là gồm 2 tổ chức bạch huyết (lympho) nằm ở phía sau của hầu họng, cũng là nơi giao nhau của đường ăn uống và đường hô hấp. Đây là cơ quan đóng vai trò quan trọngtrong việc bảo vệ đường hô hấp bằng hai cách (1) amidan ngăn chặn sự xâm nhập của các vi sinh vật gây bệnh như vi khuẩn, nấm và virus, (2) amindan tiết ra các kháng thể chống lại nhiễm khuẩn do các tác nhân gây bệnh. Viêm amidan là bệnh phổ biến gặp ở mọi lứa tuổi trong cộng đồng, gây ra những triệu chứng đau rát họng, khó nuốt, thậm chí nếu không được chẩn đoán sớm và điều trị kịp thời, diễn biến của bệnh sẽ trở nên nặng hơn, thậm chí dẫn tới nhiễm khuẩn máu, viêm hệ hô hấp và viêm cầu thận. Tuy nhiên, đôi khi viêm amidan được chẩn đoán nhầm với các bệnh đường hô hấp</p>', 'images.jpg', 1, '2025-06-08 16:12:41', '2025-06-27 13:03:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transcript`
--

CREATE TABLE `transcript` (
  `id` int(11) NOT NULL,
  `hosobenhan_id` int(11) NOT NULL,
  `file_audio` varchar(255) DEFAULT NULL,
  `transcript` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','editor','poster','user') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$J0K3/Z6NvbMOWPJu/OWrmeeWL77016xgBGs/kA3PAxz4SYzFt63h2', 'admin@gmail.com', 'admin', '2024-12-25 17:28:01', '2025-06-29 15:31:05'),
(7, 'thanh', '$2y$10$wfd5f0.HyWaWg0F4zTsR8ewIYZWeGgx5ebpOBdIVAi1n5j1GFzE5K', 'thanhnct@gmail.com', 'user', '2025-06-04 16:47:42', '2025-06-28 23:57:37'),
(10, 'nhung', '$2y$10$vZsfHsx9LwMLjTUJVkfNPOtuibLwxpPxlNKcBmuh1y7l7T1orUdj2', 'nhung@gmail.com', 'user', '2025-06-07 10:36:23', '2025-06-29 15:03:44'),
(20, 'nctthanh', '$2y$10$XOdCWkV5QiIdsoW0DYrGqutPc8uC4nSnmrwWQ69onYtET5If7/ms2', 'thanh@gmail.com', 'user', '2025-07-02 05:52:20', '2025-07-02 05:52:44');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO benhnhan (id, username, fullname, email, role)
    VALUES (NEW.id, NEW.username, NEW.username, NEW.email, NEW.role);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_user_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    UPDATE benhnhan
    SET username = NEW.username,
        email = NEW.email,
        role = NEW.role,
        updated_at = NOW()
    WHERE id = NEW.id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `certifications`
--
ALTER TABLE `certifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `datlichhen`
--
ALTER TABLE `datlichhen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `benhnhan_id` (`benhnhan_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `gioithieu`
--
ALTER TABLE `gioithieu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hosobenhan`
--
ALTER TABLE `hosobenhan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `benhnhan_id` (`benhnhan_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taimuihong`
--
ALTER TABLE `taimuihong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transcript`
--
ALTER TABLE `transcript`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hosobenhan_id` (`hosobenhan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `benhnhan`
--
ALTER TABLE `benhnhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `certifications`
--
ALTER TABLE `certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `datlichhen`
--
ALTER TABLE `datlichhen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `dichvu`
--
ALTER TABLE `dichvu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `gioithieu`
--
ALTER TABLE `gioithieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `hosobenhan`
--
ALTER TABLE `hosobenhan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `taimuihong`
--
ALTER TABLE `taimuihong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transcript`
--
ALTER TABLE `transcript`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banner`
--
ALTER TABLE `banner`
  ADD CONSTRAINT `banner_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD CONSTRAINT `fk_benhnhan_users` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `datlichhen`
--
ALTER TABLE `datlichhen`
  ADD CONSTRAINT `datlichhen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `datlichhen_ibfk_2` FOREIGN KEY (`benhnhan_id`) REFERENCES `benhnhan` (`id`),
  ADD CONSTRAINT `datlichhen_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `dichvu`
--
ALTER TABLE `dichvu`
  ADD CONSTRAINT `dichvu_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `gioithieu`
--
ALTER TABLE `gioithieu`
  ADD CONSTRAINT `gioithieu_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hosobenhan`
--
ALTER TABLE `hosobenhan`
  ADD CONSTRAINT `hosobenhan_ibfk_1` FOREIGN KEY (`benhnhan_id`) REFERENCES `benhnhan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `taimuihong`
--
ALTER TABLE `taimuihong`
  ADD CONSTRAINT `taimuihong_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `tintuc_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transcript`
--
ALTER TABLE `transcript`
  ADD CONSTRAINT `transcript_ibfk_1` FOREIGN KEY (`hosobenhan_id`) REFERENCES `hosobenhan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
