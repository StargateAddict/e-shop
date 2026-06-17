-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: 127.0.0.1
-- Čas generovania: Št 18.Jún 2026, 01:04
-- Verzia serveru: 10.4.32-MariaDB
-- Verzia PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `e-shop`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `size` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT 0,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `categories`
--

INSERT INTO `categories` (`id`, `name`, `photo`, `parent_id`, `description`) VALUES
(1, 'Uniform', '[{\"src\":\"uploads/1781364166-6519.jpg\",\"thumb\":\"uploads/thumb_1781364166-6519.jpg\"}]', 0, 'Something about this...'),
(2, 'Pants', '[]', 0, '0');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `discount` decimal(5,2) DEFAULT 0.00,
  `brand` varchar(255) DEFAULT NULL,
  `sizes` text DEFAULT NULL,
  `colors` text DEFAULT NULL,
  `status` enum('active','inactive','draft') NOT NULL DEFAULT 'active',
  `featured` tinyint(1) DEFAULT 0,
  `description` text DEFAULT NULL,
  `photos` text DEFAULT NULL,
  `category_id` int(11) DEFAULT 1,
  `user_id` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `products`
--

INSERT INTO `products` (`id`, `name`, `buying_price`, `selling_price`, `stock`, `discount`, `brand`, `sizes`, `colors`, `status`, `featured`, `description`, `photos`, `category_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Uniforms', 100.00, 150.00, 0, 0.00, NULL, NULL, NULL, 'active', 0, '', '[\r\n  {\r\n    \"src\":\"uploads/9950137_1_x.webp\",\r\n    \"thumb\":\"uploads/9950137_1_x.webp\"\r\n  },\r\n  {\r\n    \"src\":\"uploads/233658426_1_x.webp\",\r\n    \"thumb\":\"uploads/233658426_1_x.webp\"\r\n  }]', 1, 1, '2026-06-13 18:20:00', '2026-06-14 18:06:12'),
(2, 'Uniform2\r\n', 100.00, 150.00, 0, 0.00, NULL, NULL, NULL, 'active', 0, '', '[{\"src\":\"uploads/1781379956-3182.jpg\",\"thumb\":\"uploads/1781379956-3182.jpg\"}]', 1, 1, '2026-06-13 19:45:56', '2026-06-17 13:59:03'),
(3, 'Uniform3', 100.00, 150.00, 0, 0.00, NULL, NULL, NULL, 'active', 0, '', '[{\"src\":\"uploads/1781381832-8039.webp\",\"thumb\":\"uploads/1781381832-8039.webp\"}]', 1, 1, '2026-06-13 20:17:12', '2026-06-17 13:59:03');

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_type` enum('admin','customer') DEFAULT 'customer',
  `created` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `user_name`, `password`, `phone_number`, `email`, `address`, `user_type`, `created`) VALUES
(1, 'Liam', 'Tate', NULL, '$2y$10$HUhQ05F8ja5bIDXVkKGwM.xrojbQobe8aBQl0TgLfjSzuEND/i/oq', '0912338873', 'william.tate.liam3@gmail.com', NULL, 'customer', NULL),
(5, 'Liam', 'Tate', NULL, '$2y$10$YOP5HwL5p0FS/xte8oAFAuqHElF9p764A9Yatdd9rvG7Mxnol4fRe', '0912338872', 'william.tate.liam2@gmail.com', NULL, 'customer', '1781265368');

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`,`size`,`color`);

--
-- Indexy pre tabuľku `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pre tabuľku `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category_id` (`category_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`);

--
-- Indexy pre tabuľku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pre tabuľku `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pre tabuľku `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pre tabuľku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
