-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2024 at 01:30 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `circuitbay`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `add_id` int(255) NOT NULL,
  `cust_id` int(255) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`add_id`, `cust_id`, `address`) VALUES
(1, 1, 'North Fundidor Molo Iloilo City');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(255) NOT NULL,
  `cust_id` int(255) NOT NULL,
  `prod_id` int(255) NOT NULL,
  `propic_id` int(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `checkout` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `cust_id`, `prod_id`, `propic_id`, `product`, `price`, `quantity`, `checkout`) VALUES
(33, 1, 1, 1, 'Asus Prime', 8099, 1, 1),
(34, 1, 13, 13, 'Intel Core i9', 29990, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_id`, `name`, `email`, `phone`, `password`) VALUES
(1, 'demar', 'demar@gmail.com', '091725368281', '123'),
(2, 'eden', 'eden@gmail.com', '091627835682', '123'),
(3, 'el', 'el@gmail.com', '097176253821', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cust_picture`
--

CREATE TABLE `cust_picture` (
  `custpic_id` int(255) NOT NULL,
  `cust_id` int(255) NOT NULL,
  `picture_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `mess_id` int(255) NOT NULL,
  `cust_id` int(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `read` tinyint(1) DEFAULT 1,
  `admin_delete` tinyint(1) DEFAULT 1,
  `cust_delete` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`mess_id`, `cust_id`, `subject`, `message`, `date`, `read`, `admin_delete`, `cust_delete`) VALUES
(4, 1, 'product accepted', 'yay', '2024-09-26', 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(255) NOT NULL,
  `cust_id` int(255) NOT NULL,
  `prod_id` int(255) NOT NULL,
  `propic_id` int(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `payment` int(255) NOT NULL,
  `items` int(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0=Pending,1=Waiting,2=Arrived',
  `admin_done` tinyint(1) DEFAULT 1,
  `cust_done` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `cust_id`, `prod_id`, `propic_id`, `product`, `payment`, `items`, `payment_method`, `status`, `admin_done`, `cust_done`) VALUES
(18, 1, 15, 15, 'MSI Monitor ', 25899, 1, 'Cash on Delivery', 2, 1, 1),
(19, 1, 13, 13, 'Intel Core i9', 29990, 1, 'Cash on Delivery', 1, 1, 1),
(20, 1, 2, 2, 'Asus GeForce NVIDIA', 8999, 1, 'Cash on Delivery', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `pm_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`pm_id`, `name`) VALUES
(1, 'Cash on Delivery'),
(2, 'GCash'),
(3, 'Credit / Debit Card'),
(6, 'PayPal');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(255) NOT NULL,
  `stock` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `name`, `description`, `price`, `stock`) VALUES
(1, 'Asus Prime', 'B550M A WiFi II Motherboard', 8099, 20),
(2, 'Asus GeForce NVIDIA', 'GT 1030 2GB GDDR5 Graphics Card GT10 30 SL 2G BRK 1', 8999, 9),
(4, 'Asus Prime AP201', 'Tempered Glass Micro ATX Case White', 4989, 9),
(5, 'AWD UPS', 'Aide 400 1000VA Single Phase 600W UPS with AVR Uninterruptible Power Supply', 4999, 14),
(6, 'Corsair Power Supply', 'CX750 80 plus Bronze', 3499, 13),
(7, 'Ensues Fan', 'AK620 ZERO DARK', 899, 16),
(8, 'EPSON L121', ' ECOTANK PRINTER', 4999, 8),
(9, 'Gaming Chair', 'Sharkoon Skiller SGS2', 1499, 5),
(10, 'HP Smart Tank 615 Wireless', ' All in One Y0F71A2', 5999, 9),
(11, 'HyperX Pulsefire Haste Mouse', 'Mini RGB Dual Mode Wireless Gaming Mouse Black', 699, 29),
(12, 'Inplay RGB fan pcs4', 'Cooler Master Sickleflow', 799, 19),
(13, 'Intel Core i9', '14900k 14th Gen 24 Core LGA 1700 36MB Cache Unlocked Desktop Processor 2', 29990, 34),
(14, 'Kingston', 'A400 SATA SSD 500GB', 3000, 24),
(15, 'MSI Monitor ', 'G274QPX 27 Rapid IPS 1ms GtG G Syn Compatible Esports Gaming Monitor 240Hz', 25899, 11),
(16, 'Redragon Gaming  ', 'RGB Mouse and Keyboard 24 Color Mode with MousePad', 1200, 32),
(17, 'Redragon Speaker', 'GS570 Darknets RGB Sound Bar with Dual Speakers', 760, 19),
(18, 'Ryzen 5 5600x', 'AMD Ryzen 5 5600x', 20000, 34),
(19, 'Ryzen 5 9600x', 'AMD Ryzen 5 9600x', 21000, 27);

-- --------------------------------------------------------

--
-- Table structure for table `prod_picture`
--

CREATE TABLE `prod_picture` (
  `propic_id` int(255) NOT NULL,
  `prod_id` int(255) NOT NULL,
  `product_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prod_picture`
--

INSERT INTO `prod_picture` (`propic_id`, `prod_id`, `product_path`) VALUES
(1, 1, 'Asus-Prime-B550M-A-WiFi-II-Motherboard-768x985.jpg'),
(2, 2, 'Asus-GeForce-GT-1030-2GB-GDDR5-Graphics-Card-GT1030-SL-2G-BRK-1-768x985.png'),
(4, 4, 'Asus-Prime-AP201-Tempered-Glass-MicroATX-Case-White-768x985.png'),
(5, 5, 'AWP-Aide-400-1000VA-Single-Phase-600W-UPS-with-AVR-Uninterruptible-Power-Supply-768x985.jpg'),
(6, 6, 'Corsair-CX750-768x985.png'),
(7, 7, 'AK620-ZERO-DARK-jpg-768x985.png'),
(8, 8, 'EPSON-L121-ECOTANK-PRINTER-600x769.jpg'),
(9, 9, 'Sharkoon-Skiller-SGS2-4-768x985.jpg'),
(10, 10, 'HP-Smart-Tank-615-Wireless-All-in-One-Y0F71A2-jpg-768x985.png'),
(11, 11, 'HyperX-Pulsefire-Haste-2-Mini-RGB-Dual-Mode-Wireless-Gaming-Mouse-Black-768x985.jpg'),
(12, 12, 'Cooler-Master-Sickleflow-768x985.jpg'),
(13, 13, 'Intel-Core-i9-14900K-14th-Gen-24-Core-LGA-1700-36MB-Cache-Unlocked-Desktop-Processor-2-768x985.png'),
(14, 14, 'A400-SATA-SSD-768x985.jpg'),
(15, 15, 'MSI-G274QPX-27-Rapid-IPS-1ms-GtG-G-Sync-Compatible-Esports-Gaming-Monitor-240Hz-768x985.png'),
(16, 16, 'Redragon-Gaming-Essentials-768x985 (1).jpg'),
(17, 17, 'Redragon-GS570-Darknets-Sound-Bar-with-Dual-Speakers-768x985 (1).jpg'),
(18, 18, 'AMD-Ryzen-5-5600X-768x985.jpg'),
(19, 19, 'AMD-Ryzen-5-9600X-768x985.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(255) NOT NULL,
  `prod_id` int(255) NOT NULL,
  `old_price` int(255) NOT NULL,
  `new_price` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `prod_id`, `old_price`, `new_price`) VALUES
(1, 1, 8099, 8099),
(2, 2, 8999, 8999),
(4, 4, 4989, 4989),
(5, 5, 4999, 4999),
(6, 6, 3499, 3499),
(7, 7, 899, 899),
(8, 8, 4999, 4999),
(9, 9, 1499, 1499),
(10, 10, 5999, 5999),
(11, 11, 699, 699),
(12, 12, 799, 799),
(13, 13, 29990, 29990),
(14, 14, 3000, 3000),
(15, 15, 25899, 25899),
(16, 16, 1200, 1200),
(17, 17, 760, 760),
(18, 18, 20000, 20000),
(19, 19, 21000, 21000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`add_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `propic_id` (`propic_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `cust_picture`
--
ALTER TABLE `cust_picture`
  ADD PRIMARY KEY (`custpic_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`mess_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `prod_id` (`prod_id`),
  ADD KEY `propic_id` (`propic_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`pm_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `prod_picture`
--
ALTER TABLE `prod_picture`
  ADD PRIMARY KEY (`propic_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `prod_id` (`prod_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `add_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cust_picture`
--
ALTER TABLE `cust_picture`
  MODIFY `custpic_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `mess_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `pm_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `prod_picture`
--
ALTER TABLE `prod_picture`
  MODIFY `propic_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`),
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`propic_id`) REFERENCES `prod_picture` (`propic_id`);

--
-- Constraints for table `cust_picture`
--
ALTER TABLE `cust_picture`
  ADD CONSTRAINT `cust_picture_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customers` (`cust_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`propic_id`) REFERENCES `prod_picture` (`propic_id`);

--
-- Constraints for table `prod_picture`
--
ALTER TABLE `prod_picture`
  ADD CONSTRAINT `prod_picture_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
