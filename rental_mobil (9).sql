-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2024 at 02:06 PM
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
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailtrans`
--

CREATE TABLE `detailtrans` (
  `id` int(11) NOT NULL,
  `id_trans` varchar(255) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `harga` int(255) NOT NULL,
  `subtotal` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailtrans`
--

INSERT INTO `detailtrans` (`id`, `id_trans`, `kode_mobil`, `no_polisi`, `harga`, `subtotal`) VALUES
(3, 'TRX001', 'MBL001', 'D 1234 SBF', 1000000, 1000000),
(4, 'TRX002', 'MBL001', 'D 1234 SBF', 1000000, 1000000),
(5, 'TRX003', 'MBL001', 'D 1234 SBF', 1000000, 1000000),
(6, 'TRX004', 'MBL001', 'D 1234 SBF', 1000000, 1000000),
(7, 'TRX005', 'MBL003', 'D 1234 FA', 1000000, 0),
(8, 'TRX006', 'MBL002', 'D 2231 DA', 1000000, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `headtrans`
--

CREATE TABLE `headtrans` (
  `id_trans` varchar(255) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total` int(255) NOT NULL,
  `bayar` int(255) NOT NULL,
  `kembalian` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headtrans`
--

INSERT INTO `headtrans` (`id_trans`, `tanggal_transaksi`, `total`, `bayar`, `kembalian`) VALUES
('TRX001', '2024-06-09', 1000000, 2000000, 1000000),
('TRX002', '2024-06-09', 1000000, 2000000, 1000000),
('TRX003', '2024-06-09', 1000000, 3000000, 2000000),
('TRX004', '2024-06-09', 1000000, 2000000, 1000000),
('TRX005', '2024-06-09', 0, 2000000, 2000000),
('TRX006', '2024-06-09', 1000000, 2000000, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `konsumen`
--

CREATE TABLE `konsumen` (
  `id` int(11) NOT NULL,
  `kode_konsumen` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(27) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konsumen`
--

INSERT INTO `konsumen` (`id`, `kode_konsumen`, `nik`, `nama`, `jenis_kelamin`, `alamat`, `telp`) VALUES
(5, 'KSN001', '1933', 'Kido', 'Laki-Laki', 'Cimindi', '08908098'),
(8, 'KSN002', '1231312', 'Hansen', 'Laki-Laki', 'Ngamprah', '01010'),
(9, 'KSN003', '13212312', 'Daffa', 'Laki-Laki', 'Bandung', '08818128');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `harga` int(30) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `status` enum('Siap','Sedang Di Pakai') NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `kode_mobil`, `no_polisi`, `merek`, `harga`, `warna`, `status`, `images`) VALUES
(49, 'MBL001', 'D 1234 SBF', 'R34', 1000000, 'Merah', 'Siap', '984881350_merah.png'),
(54, 'MBL002', 'D 2231 DA', 'Kijang', 1000000, 'Biru', 'Sedang Di Pakai', '903142544_biru.png'),
(55, 'MBL003', 'D 1234 FA', 'Avanza', 1000000, 'Hitam', 'Siap', '42394246_hitam.png');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `id_transaksi` varchar(255) NOT NULL,
  `kode_konsumen` varchar(255) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `harga` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(30) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(27) NOT NULL,
  `hak` enum('Admin','Petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `alamat`, `telp`, `hak`) VALUES
(1127, 'super admin', 'superadmin', 'Super Admin', 'Bandung', '088229374948', 'Admin'),
(1128, 'petugas', 'petugas', 'executive', 'Cimindi', '08821321351', 'Petugas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailtrans`
--
ALTER TABLE `detailtrans`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `headtrans`
--
ALTER TABLE `headtrans`
  ADD PRIMARY KEY (`id_trans`);

--
-- Indexes for table `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`username`,`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailtrans`
--
ALTER TABLE `detailtrans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1132;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
