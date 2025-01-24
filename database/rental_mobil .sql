-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2025 at 03:05 AM
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
-- Database: `rental_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailtrans`
--

CREATE TABLE `detailtrans` (
  `id` int(11) NOT NULL,
  `id_trans` varchar(255) NOT NULL,
  `kode_konsumen` varchar(255) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `harga` varchar(255) NOT NULL,
  `subtotal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailtrans`
--

INSERT INTO `detailtrans` (`id`, `id_trans`, `kode_konsumen`, `kode_mobil`, `no_polisi`, `tgl_pinjam`, `tgl_kembali`, `harga`, `subtotal`) VALUES
(55, 'TRX001', 'KSN003', 'MBL001', 'D 9783 SBF', '2025-01-22', '2025-01-25', '3500000000', '10500000000'),
(56, 'TRX001', 'KSN003', 'MBL005', 'D 4592 SBF', '2025-01-26', '2025-01-31', '350000000', '1750000000'),
(58, 'TRX002', 'KSN003', 'MBL002', 'D 9364 SBF', '2025-02-01', '2025-02-05', '2700000000', '10800000000'),
(59, 'TRX002', 'KSN003', 'MBL003', 'D 4970 SBF', '2025-02-05', '2025-02-10', '3700000000', '18500000000'),
(60, 'TRX002', 'KSN003', 'MBL004', 'D 8918 SBF', '2025-02-10', '2025-02-15', '4250000000', '21250000000');

-- --------------------------------------------------------

--
-- Table structure for table `headtrans`
--

CREATE TABLE `headtrans` (
  `id_trans` varchar(255) NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total` varchar(255) NOT NULL,
  `bayar` varchar(255) NOT NULL,
  `kembalian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `headtrans`
--

INSERT INTO `headtrans` (`id_trans`, `tanggal_transaksi`, `total`, `bayar`, `kembalian`) VALUES
('TRX001', '2025-01-22', '12250000000', '15000000000', '2750000000'),
('TRX002', '2025-01-22', '50550000000', '70000000000', '19450000000');

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
(5, 'KSN001', '12345678901234567', 'Kido', 'Laki-Laki', 'Cimindi', '08908098123134'),
(8, 'KSN002', '12341267890123456', 'Hansen', 'Laki-Laki', 'Ngamprah', '08123781253131'),
(9, 'KSN003', '12345678901235045', 'Daffa', 'Laki-Laki', 'Bandung', '0882293374948');

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int(11) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `no_polisi` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `harga` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `kode_mobil`, `no_polisi`, `merek`, `harga`, `warna`, `status`, `images`) VALUES
(75, 'MBL001', 'D 9783 SBF', 'Nissan GT-R Nismo', '3500000000', 'Abu - Abu', 'Disewa', '657588882_gtr.jpg'),
(76, 'MBL002', 'D 9364 SBF', 'Nissan Skyline R34', '2700000000', 'Metalic', 'Disewa', '1613806812_r34.jpg'),
(77, 'MBL003', 'D 4970 SBF', 'Supra MK4', '3700000000', 'Putih', 'Disewa', '856492692_supra.jpg'),
(78, 'MBL004', 'D 8918 SBF', 'Mazda RX-7', '4250000000', 'Orange', 'Disewa', '817564249_rx7.jpg'),
(79, 'MBL005', 'D 4592 SBF', 'Nissan Silvia S15', '350000000', 'Kunig', 'Disewa', '2115074245_silvia.jpg');

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
  `harga` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `telp` varchar(255) NOT NULL,
  `hak` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `alamat`, `telp`, `hak`) VALUES
(5, 'Super Admin', 'super admin', '21232f297a57a5a743894a0e4a801fc3', 'Bandung', '088229374948', 'Admin'),
(6, 'petugas', 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'Cimahi', '081236712368', 'Petugas');

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailtrans`
--
ALTER TABLE `detailtrans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `konsumen`
--
ALTER TABLE `konsumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
