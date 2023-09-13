-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2023 at 05:01 PM
-- Server version: 10.6.14-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aple7114_terapi-ponsel`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `id_login` int(11) NOT NULL,
  `nama_admin` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `id_login`, `nama_admin`) VALUES
(1, 1, 'arip');

-- --------------------------------------------------------

--
-- Table structure for table `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `deskripsi_barang` varchar(255) NOT NULL,
  `harga_barang` varchar(50) NOT NULL,
  `stok_awal` int(30) NOT NULL,
  `stok_barang` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `nama_barang`, `deskripsi_barang`, `harga_barang`, `stok_awal`, `stok_barang`) VALUES
(1, 'tempered glass', 'barang bagus berkualitas', '50000', 10, 12),
(3, 'casing samsung s7', 'Idkasd', '10000', 30, 30);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_kerusakan`
--

CREATE TABLE `tb_jenis_kerusakan` (
  `id_kerusakan` int(11) NOT NULL,
  `nama_kerusakan` varchar(50) NOT NULL,
  `harga_perbaikan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_jenis_kerusakan`
--

INSERT INTO `tb_jenis_kerusakan` (`id_kerusakan`, `nama_kerusakan`, `harga_perbaikan`) VALUES
(1, 'Kerusakan LCD', '120000'),
(2, 'Lecet dikit ga ngaruh', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kasir`
--

CREATE TABLE `tb_kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` enum('admin','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_kasir`
--

INSERT INTO `tb_kasir` (`id_kasir`, `nama`, `username`, `password`, `role`) VALUES
(1, 'henky', 'admin', 'admin', 'admin'),
(2, 'fadhlizon', 'kasir', 'kasir', 'kasir');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `keperluan` enum('RESTOK','LOGISTIK','AKOMODASI','LAINNYA','SPAREPART') NOT NULL,
  `id_opsional` int(11) NOT NULL,
  `num_opsional` varchar(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `total_pengeluaran` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`id_pengeluaran`, `id_kasir`, `keperluan`, `id_opsional`, `num_opsional`, `deskripsi`, `total_pengeluaran`, `bukti`, `tanggal`) VALUES
(9, 1, 'RESTOK', 1, '5', 'Restok tempered glass (5)', '200000', '2023-08-28-1-S02A18-undraw_Result_re_uj08.png', '2023-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan`
--

CREATE TABLE `tb_penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `nama_pembeli` varchar(50) NOT NULL,
  `stok_dijual` int(30) NOT NULL,
  `total_bayar` varchar(50) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_penjualan`
--

INSERT INTO `tb_penjualan` (`id_penjualan`, `id_barang`, `id_kasir`, `nama_pembeli`, `stok_dijual`, `total_bayar`, `tanggal`) VALUES
(6, 1, 1, 'Kitagawa', 3, '150000', '2023-08-28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_perbaikan`
--

CREATE TABLE `tb_perbaikan` (
  `id_perbaikan` int(11) NOT NULL,
  `id_kasir` int(11) NOT NULL,
  `id_kerusakan` int(11) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `merk_seri_hp` varchar(30) NOT NULL,
  `status_perbaikan` enum('belum','selesai') NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_perbaikan`
--

INSERT INTO `tb_perbaikan` (`id_perbaikan`, `id_kasir`, `id_kerusakan`, `nama_pelanggan`, `alamat`, `no_hp`, `merk_seri_hp`, `status_perbaikan`, `tanggal`) VALUES
(1, 1, 1, 'awala', 'chincanet', '083863434232', 'samsung a10s', 'selesai', '2023-08-10'),
(2, 2, 2, 'neoho', 'disini', '01212312', 'oddo', 'belum', '2023-08-12'),
(3, 2, 2, 'rahman', 'benda', '1231242141', 'realme', 'selesai', '2023-08-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_login` (`id_login`);

--
-- Indexes for table `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `tb_jenis_kerusakan`
--
ALTER TABLE `tb_jenis_kerusakan`
  ADD PRIMARY KEY (`id_kerusakan`);

--
-- Indexes for table `tb_kasir`
--
ALTER TABLE `tb_kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`),
  ADD KEY `id_kasir` (`id_kasir`);

--
-- Indexes for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_barang` (`id_barang`,`id_kasir`,`nama_pembeli`);

--
-- Indexes for table `tb_perbaikan`
--
ALTER TABLE `tb_perbaikan`
  ADD PRIMARY KEY (`id_perbaikan`),
  ADD KEY `id_kasir` (`id_kasir`,`id_kerusakan`,`nama_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_jenis_kerusakan`
--
ALTER TABLE `tb_jenis_kerusakan`
  MODIFY `id_kerusakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_kasir`
--
ALTER TABLE `tb_kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_penjualan`
--
ALTER TABLE `tb_penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_perbaikan`
--
ALTER TABLE `tb_perbaikan`
  MODIFY `id_perbaikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
