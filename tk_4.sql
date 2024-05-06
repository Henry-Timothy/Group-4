-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 03:19 AM
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
-- Database: `tk_4`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_acces`
--

CREATE TABLE `tb_acces` (
  `id_acces` int(11) NOT NULL,
  `acces_name` varchar(255) NOT NULL,
  `acces_inserted_at` datetime NOT NULL,
  `acces_last_updated` datetime NOT NULL,
  `acces_softdel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_acces`
--

INSERT INTO `tb_acces` (`id_acces`, `acces_name`, `acces_inserted_at`, `acces_last_updated`, `acces_softdel`) VALUES
(1, 'Admin', '2024-05-04 14:21:04', '2024-05-04 19:24:48', 0),
(2, 'Kasir', '2024-05-04 22:04:29', '2024-05-04 22:04:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_customer` smallint(2) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `customer_inserted_at` datetime NOT NULL,
  `customer_last_updated` datetime DEFAULT NULL,
  `customer_softdel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `customer_name`, `address`, `phone_number`, `customer_inserted_at`, `customer_last_updated`, `customer_softdel`) VALUES
(1, 'Bambang', 'Malang', '712819', '2024-05-03 07:56:15', '2024-05-04 10:51:12', 0),
(2, 'Michelle', 'Jakarta', '8172', '2024-05-03 07:56:15', '2024-05-04 10:51:05', 0),
(3, 'Adit', 'Malang', '12123134', '2024-05-04 10:44:13', '2024-05-04 10:44:13', 1),
(4, 'Bagus', 'Malang', '87654312', '2024-05-04 19:24:59', '2024-05-04 19:25:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_transaction`
--

CREATE TABLE `tb_detail_transaction` (
  `id_detail_transaction` int(3) NOT NULL,
  `id_transaction` smallint(3) NOT NULL,
  `id_item` smallint(3) NOT NULL,
  `qty` smallint(3) NOT NULL,
  `price` int(5) NOT NULL,
  `total_price` int(5) NOT NULL,
  `detail_transaction_softdel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_detail_transaction`
--

INSERT INTO `tb_detail_transaction` (`id_detail_transaction`, `id_transaction`, `id_item`, `qty`, `price`, `total_price`, `detail_transaction_softdel`) VALUES
(1, 1, 1, 10, 25000, 250000, 0),
(2, 2, 1, 10, 25000, 250000, 0),
(3, 3, 2, 10, 6000, 60000, 0),
(4, 3, 1, 10, 25000, 250000, 0),
(5, 4, 2, 10, 6000, 60000, 0),
(6, 5, 1, 10, 25000, 250000, 0),
(7, 5, 2, 20, 6000, 120000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_item`
--

CREATE TABLE `tb_item` (
  `id_item` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `item_inserted_at` datetime DEFAULT NULL,
  `item_last_updated` datetime DEFAULT NULL,
  `item_softdel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_item`
--

INSERT INTO `tb_item` (`id_item`, `item_name`, `description`, `unit`, `price`, `id_supplier`, `item_inserted_at`, `item_last_updated`, `item_softdel`) VALUES
(1, 'Buku', 'Buku tulis', '60', '25000', 1, '2024-05-04 19:28:07', '2024-05-04 19:34:50', 0),
(2, 'Pensil', '2b', '70', '6000', 1, '2024-05-04 20:52:30', '2024-05-04 20:53:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_purchase`
--

CREATE TABLE `tb_purchase` (
  `id_purchase` int(11) NOT NULL,
  `purchase_amount` int(11) NOT NULL,
  `purchase_price` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `purchase_inserted_at` datetime DEFAULT NULL,
  `purchase_softdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_purchase`
--

INSERT INTO `tb_purchase` (`id_purchase`, `purchase_amount`, `purchase_price`, `id_user`, `id_item`, `purchase_inserted_at`, `purchase_softdel`) VALUES
(11, 100, '1000000', 1, 1, '2024-05-04 19:37:53', 0),
(12, 100, '500000', 1, 2, '2024-05-04 20:53:11', 0),
(13, 10, '100000', 1, 2, '2024-05-05 21:10:19', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_phone` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_inserted_at` datetime NOT NULL,
  `supplier_last_updated` datetime NOT NULL,
  `supplier_softdel` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `supplier_name`, `supplier_phone`, `supplier_address`, `supplier_inserted_at`, `supplier_last_updated`, `supplier_softdel`) VALUES
(1, 'Maju Jaya', '987654', 'Malang', '2024-05-04 19:26:53', '2024-05-04 19:26:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaction`
--

CREATE TABLE `tb_transaction` (
  `id_transaction` int(2) NOT NULL,
  `id_customer` smallint(3) NOT NULL,
  `total_amount` int(5) NOT NULL,
  `transaction_inserted_at` datetime NOT NULL,
  `transaction_inserted_by` smallint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_transaction`
--

INSERT INTO `tb_transaction` (`id_transaction`, `id_customer`, `total_amount`, `transaction_inserted_at`, `transaction_inserted_by`) VALUES
(1, 2, 250000, '2024-05-04 19:39:36', 1),
(2, 4, 250000, '2024-05-04 19:40:28', 1),
(3, 4, 310000, '2024-05-04 20:53:59', 1),
(4, 1, 60000, '2024-05-04 20:58:07', 1),
(5, 2, 370000, '2024-05-05 21:20:59', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `id_acces` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_inserted_at` datetime DEFAULT NULL,
  `user_last_updated` datetime DEFAULT NULL,
  `user_softdel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `first_name`, `last_name`, `phone_number`, `address`, `id_acces`, `password`, `user_inserted_at`, `user_last_updated`, `user_softdel`) VALUES
(1, 'admin.admin', 'Admin', '1', '098765123', 'Malang', 1, '123456', '2024-05-02 19:22:58', '2024-05-04 10:15:52', 0),
(2, 'kasir.kasir', 'Kasir', '1', '1223456', 'Malang', 2, '123456', '2024-05-03 23:27:20', '2024-05-04 22:04:41', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_acces`
--
ALTER TABLE `tb_acces`
  ADD PRIMARY KEY (`id_acces`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `tb_detail_transaction`
--
ALTER TABLE `tb_detail_transaction`
  ADD PRIMARY KEY (`id_detail_transaction`);

--
-- Indexes for table `tb_item`
--
ALTER TABLE `tb_item`
  ADD PRIMARY KEY (`id_item`);

--
-- Indexes for table `tb_purchase`
--
ALTER TABLE `tb_purchase`
  ADD PRIMARY KEY (`id_purchase`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `tb_transaction`
--
ALTER TABLE `tb_transaction`
  ADD PRIMARY KEY (`id_transaction`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `tb_user_ibfk_1` (`id_acces`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_acces`
--
ALTER TABLE `tb_acces`
  MODIFY `id_acces` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `id_customer` smallint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_detail_transaction`
--
ALTER TABLE `tb_detail_transaction`
  MODIFY `id_detail_transaction` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_item`
--
ALTER TABLE `tb_item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_purchase`
--
ALTER TABLE `tb_purchase`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_transaction`
--
ALTER TABLE `tb_transaction`
  MODIFY `id_transaction` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `tb_user_ibfk_1` FOREIGN KEY (`id_acces`) REFERENCES `tb_acces` (`id_acces`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
