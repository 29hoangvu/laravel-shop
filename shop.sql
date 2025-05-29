-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 03:23 PM
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
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`) VALUES
(1, 'Điện thoại', 'Các loại điện thoại mới nhất'),
(2, 'Laptop', 'Máy tính xách tay cao cấp'),
(3, 'Phụ kiện', 'Tai nghe, sạc, cáp...'),
(4, 'Bàn phím', 'Bàn phím máy tính'),
(5, 'Chuột', 'Chuột máy tính'),
(6, 'Smartwatch', 'Đồng hồ thông minh');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `cmt_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `create_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_status` varchar(20) DEFAULT 'pending',
  `order_status` varchar(20) DEFAULT 'new',
  `created_at` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_05_21_061113_create_personal_access_tokens_table', 1),
(2, '2025_05_21_101936_create_cache_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `staff_id`, `category_id`, `name`, `description`, `price`, `stock_quantity`, `image_url`, `status`, `created_at`) VALUES
(1, 1, 1, 'iPhone 14 Pro Max', 'Điện thoại cao cấp của Apple', 33990000.00, 10, 'images/iphone14.jpg', 1, '2025-05-21 16:50:19'),
(2, 1, 2, 'Laptop Dell XPS 13', 'Laptop mỏng nhẹ, hiệu suất cao', 28990000.00, 5, 'images/dellxps.jpg', 1, '2025-05-21 16:50:19'),
(3, 1, 3, 'Tai nghe Bluetooth Sony', 'Chống ồn, pin lâu', 1990000.00, 20, 'images/sony-headphone.jpg', 1, '2025-05-21 16:50:19'),
(24, 1, 1, 'Điện thoại Samsung Galaxy S21', 'Samsung Galaxy S21, 128GB, màu trắng.', 17990000.00, 40, 'images/galaxy_s21.jpg', 1, '2025-05-29 19:16:57'),
(25, 1, 2, 'Laptop MacBook Air M1', 'Apple MacBook Air M1 2020, 8GB RAM, 256GB SSD.', 22990000.00, 20, 'images/macbook_air_m1.jpg', 1, '2025-05-29 19:16:57'),
(26, 1, 3, 'Tai nghe AirPods Pro', 'Apple AirPods Pro, chống ồn chủ động.', 4990000.00, 80, 'images/airpods_pro.jpg', 1, '2025-05-29 19:16:57'),
(27, 1, 4, 'Bàn phím cơ Logitech', 'Bàn phím cơ Logitech G413, led RGB.', 2590000.00, 60, 'images/logitech_keyboard.jpg', 1, '2025-05-29 19:16:57'),
(28, 1, 5, 'Chuột không dây Logitech', 'Chuột không dây Logitech MX Master 3.', 1990000.00, 70, 'images/logitech_mouse.jpg', 1, '2025-05-29 19:16:57'),
(29, 1, 6, 'Smartwatch Xiaomi Mi Band 6', 'Vòng đeo tay thông minh Xiaomi Mi Band 6.', 799000.00, 90, 'images/mi_band_6.jpg', 1, '2025-05-29 19:16:57'),
(30, 1, 2, 'Laptop HP Pavilion', 'Laptop HP Pavilion 15, i7, 16GB RAM, 512GB SSD.', 20990000.00, 25, 'images/hp_pavilion.jpg', 1, '2025-05-29 19:16:57'),
(31, 1, 1, 'Điện thoại Oppo Reno6', 'Oppo Reno6, 128GB, màu xanh dương.', 8990000.00, 55, 'images/oppo_reno6.jpg', 1, '2025-05-29 19:16:57'),
(32, 1, 2, 'Laptop Asus Vivobook', 'Laptop Asus Vivobook 14, i3, 8GB RAM, 256GB SSD.', 10990000.00, 45, 'images/asus_vivobook.jpg', 1, '2025-05-29 19:16:57'),
(33, 1, 3, 'Tai nghe JBL Tune 500BT', 'Tai nghe Bluetooth JBL Tune 500BT.', 1200000.00, 150, 'images/jbl_tune500bt.jpg', 1, '2025-05-29 19:16:57'),
(34, 1, 4, 'Bàn phím Razer BlackWidow', 'Bàn phím cơ Razer BlackWidow V3.', 3500000.00, 35, 'images/razer_blackwidow.jpg', 1, '2025-05-29 19:16:57'),
(35, 1, 5, 'Chuột Gaming Logitech G502', 'Chuột gaming Logitech G502 Hero.', 1500000.00, 40, 'images/logitech_g502.jpg', 1, '2025-05-29 19:16:57'),
(36, 1, 6, 'Smartwatch Apple Watch Series 6', 'Apple Watch Series 6, GPS, 44mm.', 9990000.00, 22, 'images/apple_watch6.jpg', 1, '2025-05-29 19:16:57'),
(37, 1, 1, 'Điện thoại Xiaomi Redmi Note 10', 'Xiaomi Redmi Note 10, 128GB.', 4990000.00, 65, 'images/redmi_note10.jpg', 1, '2025-05-29 19:16:57'),
(38, 1, 2, 'Laptop Lenovo ThinkPad', 'Laptop Lenovo ThinkPad E14, i5, 8GB RAM.', 14990000.00, 28, 'images/lenovo_thinkpad.jpg', 1, '2025-05-29 19:16:57'),
(39, 1, 3, 'Tai nghe Bose QuietComfort', 'Tai nghe chống ồn Bose QC35 II.', 7500000.00, 18, 'images/bose_qc35.jpg', 1, '2025-05-29 19:16:57'),
(40, 1, 4, 'Bàn phím không dây Apple Magic Keyboard', 'Apple Magic Keyboard không dây.', 2990000.00, 50, 'images/magic_keyboard.jpg', 1, '2025-05-29 19:16:57'),
(41, 1, 1, 'Điện thoại Nokia 3310', 'Điện thoại cổ điển Nokia 3310.', 500000.00, 100, 'images/nokia_3310.jpg', 1, '2025-05-29 19:16:57'),
(42, 1, 2, 'Laptop Acer Aspire 5', 'Laptop Acer Aspire 5, i5, 8GB RAM, 256GB SSD.', 11990000.00, 35, 'images/acer_aspire5.jpg', 1, '2025-05-29 19:16:57'),
(43, 1, 3, 'Tai nghe Sony WH-1000XM4', 'Tai nghe Sony WH-1000XM4 chống ồn.', 8200000.00, 15, 'images/sony_wh1000xm4.jpg', 1, '2025-05-29 19:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('47WI6ZscaHqdOTEIIlon13dnKF5rX0cNBj5ZBY2o', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2VtUlZCV3JrREw3NE85NHF3eDlWd1BzYzlxNXFmSFBPUW91M1lwVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fX0=', 1748524360),
('RNLr6jPc8KoFO1ppwehWhanCll44nV2T1vbvOdFb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWhjV2U0Rkwxb2t2NjZHeUdURkNHTVZnSXhjbWJjR1g1aG8yQ1g5aCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1748522781);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `password`, `email`, `address`, `phone`) VALUES
(1, 'Nguyễn Văn A', '$2y$12$Gb2ZNHW40VXd0ogML7Shve/3YrJb/VFUN129NJdRczrc.uEo2UiFy', 'a@example.com', '123 Đường A', '0123456789');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `password`, `email`, `address`, `phone`) VALUES
(2, 'rizu', '$2y$12$Gb2ZNHW40VXd0ogML7Shve/3YrJb/VFUN129NJdRczrc.uEo2UiFy', 'test@gmail.com', NULL, NULL),
(3, 'hvu', '$2y$12$e5I5TvhCVo4hlPsM71sO6O33n4m5E/5CmzTIE8rRwCmLRQXpdNYz6', 'v@gmail.com', NULL, NULL),
(4, 'HV', '$2y$12$mGn1ILlawToRlLKEpjRnmu/89JpeaDN2ZtvJz1naQbV6Oe3iOFSLe', 'vu@gmail.com', NULL, NULL),
(5, 'NHV', '$2y$12$oHc7FihWoU./JkbiJtf0H.ObkWADlqQcrrNbMfGYDT6plM1M/JSWm', 'a@gmail.com', NULL, NULL),
(6, 'ATung', '$2y$12$mq6.Moi00NMnZIQV5qPrTetw9cHMU6z7fXKMr5aplDkEIHdlYI6K2', 'tung@gmail.com', NULL, NULL),
(28, 'PVT', '$2y$12$6w8hvk4Vcoh9Hq393JL4P.aD6Zp7Tk/YXg6MNg9M.Re7LdG4DqBk.', '04794@gmail.com', NULL, NULL),
(31, 'Nguyễn Hoàng Vũ', '$2y$12$wsf/bUOVjFvmQRHS2YoRYemLHVV.VnKyM.5WbnynKxuJ3gNBWKZ7G', 'hoangvu04794@gmail.com', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`cmt_id`),
  ADD KEY `FK_COMMENT_RELATIONS_PRODUCTS` (`product_id`),
  ADD KEY `FK_COMMENT_RELATIONS_USER` (`user_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `FK_FAVORITE_RELATIONS_PRODUCTS` (`product_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `FK_INVOICE_RELATIONS_USER` (`user_id`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`invoice_id`,`product_id`),
  ADD KEY `FK_INVOICE__RELATIONS_PRODUCTS` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `FK_PRODUCTS_RELATIONS_CATEGORI` (`category_id`),
  ADD KEY `FK_PRODUCTS_RELATIONS_STAFF` (`staff_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `Invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_COMMENT_RELATIONS_PRODUCTS` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `FK_COMMENT_RELATIONS_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `FK_FAVORITE_RELATIONS_PRODUCTS` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `FK_FAVORITE_RELATIONS_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `FK_INVOICE_RELATIONS_USER` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `FK_INVOICE__RELATIONS_INVOICE` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`),
  ADD CONSTRAINT `FK_INVOICE__RELATIONS_PRODUCTS` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_PRODUCTS_RELATIONS_CATEGORI` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `FK_PRODUCTS_RELATIONS_STAFF` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
