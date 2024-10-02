-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 11:32 AM
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
-- Database: `automotive_parts_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`) VALUES
(1, 'Weight (Kg)'),
(2, 'Dimensions (L/W/H inches)'),
(3, 'Color'),
(4, 'Voltage'),
(5, 'Material'),
(6, 'Engine Type Compatibility');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Automobile'),
(2, 'Automotive Parts'),
(3, 'Tires and Wheels'),
(4, 'Car Maintenance'),
(5, 'Electronics and Gadgets'),
(6, 'Exterior Upgrades'),
(7, 'Interior Accessories'),
(8, 'Performance Parts'),
(9, 'Safety and Security'),
(10, 'Body Parts'),
(11, 'Lights and Electronics');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `short_description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `feature_product` tinyint(1) DEFAULT 0,
  `main_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `short_description`, `price`, `description`, `feature_product`, `main_image`, `category_id`, `old_price`) VALUES
(1, 'Aluminum Intercooler', 'ALT-001', 'High-quality car alternator for enhanced performance.', 1350.00, 'High-quality aluminum intercooler designed to provide enhanced cooling efficiency.', 1, NULL, 2, 1500.00),
(2, 'Power Steering Pump', 'PSP-002', 'Reliable power steering pump for smooth steering.', 1620.00, 'This power steering pump ensures smooth and responsive steering.', 1, NULL, 2, 1800.00),
(3, 'Rim and Tire Set', 'RT-003', 'Premium rims and tires for enhanced style and performance.', 3150.00, 'These rims and tires offer superior performance and add a stylish touch to your vehicle.', 1, NULL, 3, 4500.00),
(4, 'Ball Joints', 'BJ-004', 'Heavy-duty ball joints for smoother suspension.', 810.00, 'These ball joints are designed for strength and durability, providing smoother suspension and steering.', 1, NULL, 2, 900.00),
(5, 'Oxygen Sensors', 'OS-005', 'High-quality oxygen sensors for better fuel efficiency.', 1800.00, 'These oxygen sensors ensure better fuel efficiency by monitoring the oxygen levels in the exhaust gases.', 1, NULL, 8, 2000.00),
(6, 'Momo MOD27/C Steering Wheel', 'SW-006', 'High-quality Momo steering wheel for improved control.', 6750.00, 'This Momo steering wheel offers exceptional control and grip for a superior driving experience.', 1, NULL, 7, 7600.00),
(7, 'AutoSky Reverse Backup Camera', 'RC-007', 'High-resolution reverse camera for better visibility.', 4500.00, 'This reverse backup camera offers clear visibility when reversing, improving safety and convenience.', 1, NULL, 9, 5000.00),
(8, 'Bosch Oil Filter', 'OF-008', 'High-performance oil filter by Bosch.', 4500.00, 'This Bosch oil filter ensures clean engine oil for better engine health and longevity.', 1, NULL, 2, 5000.00),
(9, 'Spark Plug Car', 'SP-009', 'High-performance spark plugs for efficient ignition.', 675.00, 'These spark plugs offer efficient ignition for improved engine performance and fuel economy.', 1, NULL, 8, 750.00),
(10, 'Front and Rear Autospecialty Brake Kit', 'BK-010', 'Complete brake kit for superior braking performance.', 9000.00, 'This comprehensive brake kit includes all necessary components for optimal braking performance.', 1, NULL, 2, 10000.00),
(11, 'Car Battery Charger', 'BC-011', 'Portable car battery charger for emergencies.', 13500.00, 'This car battery charger is perfect for keeping your car battery charged during emergencies.', 1, NULL, 4, 15000.00),
(12, 'Catalytic Converters', 'CC-012', 'Advanced catalytic converters for reduced emissions.', 4950.00, 'These catalytic converters help reduce emissions and improve overall engine efficiency.', 1, NULL, 8, 5500.00),
(13, 'Gear Stick', 'GS-013', 'Durable gear stick for smooth shifting.', 1350.00, 'This gear stick is designed for smooth and precise shifting, enhancing your driving experience.', 1, NULL, 7, 1500.00),
(14, 'Momo R1907/33S Steering Wheel', 'SW-014', 'Stylish Momo steering wheel with superior grip.', 1800.00, 'This stylish Momo steering wheel provides excellent grip and adds a sporty touch to your vehicle.', 1, NULL, 7, 2000.00),
(15, 'Recliner Car Seat', 'CS-015', 'Comfortable and ergonomic car seat.', 13500.00, 'This ergonomic car seat provides maximum comfort and support during long drives.', 1, NULL, 7, 15000.00),
(16, 'Engine Piston and Spark Plug Isolated White', 'EP-016', 'Durable piston spark plugs for enhanced performance.', 7200.00, 'These piston spark plugs are designed to improve performance and durability.', 1, '', 8, 8000.00),
(17, 'Brake Disc', 'BD-017', 'High-quality brake discs for reliable stopping power.', 4500.00, 'These brake discs provide exceptional braking performance, ensuring reliable stopping power in all conditions.', 1, NULL, 2, 5000.00),
(18, 'Alternator Electrical Wires & Cable Spare Part', 'ALT-018', 'Alternator designed to provide high electrical output.', 18000.00, 'This alternator provides high electrical output for improved engine performance.', 1, NULL, 8, 20000.00),
(19, 'Spark Plugs', 'SP-019', 'Premium spark plugs for improved ignition and fuel efficiency.', 2250.00, 'These premium spark plugs enhance engine performance and fuel efficiency by ensuring reliable ignition.', 1, NULL, 8, 2500.00),
(20, 'Service Tyre', 'ST-020', 'Durable service tyre for long-lasting performance.', 7200.00, 'This service tyre is built to withstand tough conditions, offering long-lasting performance.', 1, NULL, 4, 8000.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`product_id`, `attribute_id`, `value`) VALUES
(1, 1, '5.5'),
(1, 2, '24 x 12 x 6'),
(1, 3, ''),
(1, 4, ''),
(1, 5, 'Aluminum'),
(1, 6, 'Turbocharged Engines'),
(2, 1, '3.2'),
(2, 2, '8 x 6 x 5'),
(2, 3, ''),
(2, 4, '12V'),
(2, 5, 'Aluminum'),
(2, 6, 'Gasoline Engines'),
(3, 1, '20 per tire'),
(3, 2, '32 x 32 x 12'),
(3, 3, 'Black'),
(3, 4, ''),
(3, 5, 'Rubber and Steel'),
(3, 6, 'All-Terrain Vehicles'),
(4, 1, '1.2'),
(4, 2, ''),
(4, 3, ''),
(4, 4, ''),
(4, 5, 'Steel'),
(4, 6, 'Various'),
(5, 1, '0.15'),
(5, 2, '3 x 1 x 1'),
(5, 3, ''),
(5, 4, '12V'),
(5, 5, 'Stainless Steel'),
(5, 6, 'Gasoline Engines'),
(6, 1, '1.5'),
(6, 2, '14 x 14 x 3'),
(6, 3, 'Black'),
(6, 4, ''),
(6, 5, 'Leather and Aluminum'),
(6, 6, ''),
(7, 1, '0.2'),
(7, 2, '3 x 2 x 1.5'),
(7, 3, ''),
(7, 4, '12V'),
(7, 5, 'Plastic'),
(7, 6, ''),
(8, 1, '0.5'),
(8, 2, '4 x 4 x 4'),
(8, 3, 'Black'),
(8, 4, ''),
(8, 5, 'Steel'),
(8, 6, 'Gasoline and Diesel Engines'),
(9, 1, '0.05'),
(9, 2, ''),
(9, 3, ''),
(9, 4, ''),
(9, 5, 'Nickel Alloy'),
(9, 6, 'Gasoline Engines'),
(10, 1, '18'),
(10, 2, '14 x 12 x 4'),
(10, 3, ''),
(10, 4, ''),
(10, 5, 'Steel'),
(10, 6, ''),
(11, 1, '3'),
(11, 2, ''),
(11, 3, 'Red'),
(11, 4, '12V/24V'),
(11, 5, 'Plastic and Steel'),
(11, 6, ''),
(12, 1, '6.8'),
(12, 2, '12 x 8 x 5'),
(12, 3, ''),
(12, 4, ''),
(12, 5, 'Stainless Steel'),
(12, 6, 'Gasoline and Diesel Engines'),
(13, 1, '0.7'),
(13, 2, '5 x 3 x 3'),
(13, 3, 'Silver'),
(13, 4, ''),
(13, 5, 'Steel'),
(13, 6, ''),
(14, 1, '1.2'),
(14, 2, '14 x 14 x 3'),
(14, 3, 'Black'),
(14, 4, ''),
(14, 5, 'Steel'),
(14, 6, ''),
(15, 1, '12'),
(15, 2, '20 x 20 x 40'),
(15, 3, 'Black and Brown'),
(15, 4, ''),
(15, 5, 'Leather and Steel'),
(15, 6, ''),
(16, 1, '2.5'),
(16, 2, ''),
(16, 3, ''),
(16, 4, ''),
(16, 5, 'Steel and Alloy'),
(16, 6, 'V6 and V8 Engines'),
(17, 1, '5'),
(17, 2, '14 x 14 x 2'),
(17, 3, ''),
(17, 4, ''),
(17, 5, 'Steel'),
(17, 6, ''),
(18, 1, '7'),
(18, 2, ''),
(18, 3, ''),
(18, 4, '12V'),
(18, 5, 'Copper and Steel'),
(18, 6, 'Gasoline and Diesel Engines'),
(19, 1, '0.05'),
(19, 2, ''),
(19, 3, ''),
(19, 4, ''),
(19, 5, 'Nickel Alloy'),
(19, 6, 'Gasoline Engines'),
(20, 1, '10 per tire'),
(20, 2, '30 x 30 x 10'),
(20, 3, 'Black'),
(20, 4, ''),
(20, 5, 'Rubber and Steel'),
(20, 6, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(1, 1, '/e-commerce/assets/products/aluminum-intercooler.png'),
(2, 2, '/e-commerce/assets/products/power-steering-pump.png'),
(3, 3, '/e-commerce/assets/products/rims-tires.png'),
(4, 4, '/e-commerce/assets/products/ball-joints.png'),
(5, 5, '/e-commerce/assets/products/oxygen-sensors.png'),
(6, 6, '/e-commerce/assets/products/momo-steering-wheel-1.png'),
(7, 7, '/e-commerce/assets/products/reverse-backup-camera.png'),
(8, 8, '/e-commerce/assets/products/bosch-oil-filter.png'),
(9, 9, '/e-commerce/assets/products/car-spark-plug.png'),
(10, 10, '/e-commerce/assets/products/brake-kit.png'),
(11, 11, '/e-commerce/assets/products/car-battery-charger.png'),
(12, 12, '/e-commerce/assets/products/catalytic-converters.png'),
(13, 13, '/e-commerce/assets/products/gear-stick.png'),
(14, 14, '/e-commerce/assets/products/momo-steering-wheel-2.png'),
(15, 15, '/e-commerce/assets/products/car-seat.png'),
(16, 16, '/e-commerce/assets/products/piston-sparkplug.png'),
(17, 17, '/e-commerce/assets/products/brake-disc.png'),
(18, 18, '/e-commerce/assets/products/alternator.png'),
(19, 19, '/e-commerce/assets/products/spark-plugs.png'),
(20, 20, '/e-commerce/assets/products/service-tyre.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`product_id`,`attribute_id`),
  ADD KEY `attribute_id` (`attribute_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
