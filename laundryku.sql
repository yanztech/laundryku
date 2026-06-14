-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 07:34 PM
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
-- Database: `laundryku`
--

-- --------------------------------------------------------

--
-- Table structure for table `paket_laundry`
--

CREATE TABLE `paket_laundry` (
  `id_paket` int(11) NOT NULL,
  `jenis_layanan` enum('Cuci Komplit','Cuci Satuan','Dry Clean') NOT NULL,
  `nama_paket` varchar(100) NOT NULL,
  `waktu_kerja` varchar(50) DEFAULT NULL,
  `tarif` int(11) NOT NULL,
  `satuan` enum('Kg','Pcs') DEFAULT 'Kg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paket_laundry`
--

INSERT INTO `paket_laundry` (`id_paket`, `jenis_layanan`, `nama_paket`, `waktu_kerja`, `tarif`, `satuan`) VALUES
(1, 'Cuci Komplit', 'Reguler', '2 Hari', 7000, 'Kg'),
(2, 'Cuci Komplit', 'Express', '1 Hari', 12000, 'Kg'),
(3, 'Cuci Komplit', 'Kilat', '6 Jam', 15000, 'Kg'),
(4, 'Cuci Satuan', 'Selimut', '1 Hari', 15000, 'Pcs'),
(5, 'Cuci Satuan', 'Bed Cover', '2 Hari', 25000, 'Pcs'),
(6, 'Cuci Satuan', 'Boneka Kecil', '1 Hari', 10000, 'Pcs'),
(7, 'Cuci Satuan', 'Boneka Besar', '2 Hari', 30000, 'Pcs'),
(8, 'Dry Clean', 'Reguler', '1 Hari', 12000, 'Kg'),
(9, 'Dry Clean', 'Express', '6 Jam', 18000, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `no_telp`, `alamat`, `created_at`) VALUES
(1, 'Adam', '081234567890', 'Jl. Mawar No.1', '2026-06-13 17:34:15'),
(2, 'Dedi', '081234567891', 'Jl. Melati No.2', '2026-06-13 17:34:15'),
(3, 'Johan', '081234567892', 'Jl. Kenanga No.3', '2026-06-13 17:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_bayar` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `metode` enum('Cash','Transfer','QRIS') DEFAULT 'Cash',
  `jumlah_bayar` int(11) NOT NULL,
  `tanggal_bayar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `no_nota` varchar(30) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `tanggal_keluar` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('Antrean','Proses','Selesai','Diambil') DEFAULT 'Antrean',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `no_nota`, `id_pelanggan`, `id_paket`, `qty`, `harga_satuan`, `total_bayar`, `tanggal_masuk`, `tanggal_keluar`, `keterangan`, `status`, `created_at`) VALUES
(1, 'INV-001', 1, 1, 5.00, 7000, 35000, '2026-06-14', '2026-06-16', 'Laundry keluarga', 'Antrean', '2026-06-13 17:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Karyawan') DEFAULT 'Karyawan',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `level`, `created_at`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 'Admin', '2026-06-13 17:34:15');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dashboard_harian`
-- (See below for the actual view)
--
CREATE TABLE `v_dashboard_harian` (
`total_order` bigint(21)
,`total_pendapatan` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_laporan_transaksi`
-- (See below for the actual view)
--
CREATE TABLE `v_laporan_transaksi` (
`id_transaksi` int(11)
,`no_nota` varchar(30)
,`pelanggan` varchar(100)
,`no_telp` varchar(20)
,`jenis_layanan` enum('Cuci Komplit','Cuci Satuan','Dry Clean')
,`nama_paket` varchar(100)
,`satuan` enum('Kg','Pcs')
,`qty` decimal(10,2)
,`harga_satuan` int(11)
,`total_bayar` int(11)
,`tanggal_masuk` date
,`tanggal_keluar` date
,`status` enum('Antrean','Proses','Selesai','Diambil')
,`keterangan` text
);

-- --------------------------------------------------------

--
-- Structure for view `v_dashboard_harian`
--
DROP TABLE IF EXISTS `v_dashboard_harian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_dashboard_harian`  AS SELECT count(0) AS `total_order`, coalesce(sum(`transaksi`.`total_bayar`),0) AS `total_pendapatan` FROM `transaksi` WHERE `transaksi`.`tanggal_masuk` = curdate() ;

-- --------------------------------------------------------

--
-- Structure for view `v_laporan_transaksi`
--
DROP TABLE IF EXISTS `v_laporan_transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_laporan_transaksi`  AS SELECT `t`.`id_transaksi` AS `id_transaksi`, `t`.`no_nota` AS `no_nota`, `p`.`nama` AS `pelanggan`, `p`.`no_telp` AS `no_telp`, `pl`.`jenis_layanan` AS `jenis_layanan`, `pl`.`nama_paket` AS `nama_paket`, `pl`.`satuan` AS `satuan`, `t`.`qty` AS `qty`, `t`.`harga_satuan` AS `harga_satuan`, `t`.`total_bayar` AS `total_bayar`, `t`.`tanggal_masuk` AS `tanggal_masuk`, `t`.`tanggal_keluar` AS `tanggal_keluar`, `t`.`status` AS `status`, `t`.`keterangan` AS `keterangan` FROM ((`transaksi` `t` join `pelanggan` `p` on(`p`.`id_pelanggan` = `t`.`id_pelanggan`)) join `paket_laundry` `pl` on(`pl`.`id_paket` = `t`.`id_paket`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `paket_laundry`
--
ALTER TABLE `paket_laundry`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_bayar`),
  ADD KEY `fk_pembayaran_transaksi` (`id_transaksi`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `no_nota` (`no_nota`),
  ADD KEY `fk_transaksi_pelanggan` (`id_pelanggan`),
  ADD KEY `fk_transaksi_paket` (`id_paket`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `paket_laundry`
--
ALTER TABLE `paket_laundry`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_bayar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket_laundry` (`id_paket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_transaksi_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
