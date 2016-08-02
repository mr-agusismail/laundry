-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 25, 2016 at 06:42 
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_cucian`
--

CREATE TABLE IF NOT EXISTS `data_cucian` (
  `id_paket` varchar(5) NOT NULL,
  `nm_paket` varchar(20) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `banyak` decimal(4,2) NOT NULL,
  `total_bayar` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_cucian`
--


-- --------------------------------------------------------

--
-- Table structure for table `data_detailtransaksi`
--

CREATE TABLE IF NOT EXISTS `data_detailtransaksi` (
  `id_nota` int(10) NOT NULL,
  `id_paket` varchar(5) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `banyak` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  KEY `id_nota` (`id_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detailtransaksi`
--

INSERT INTO `data_detailtransaksi` (`id_nota`, `id_paket`, `harga`, `banyak`, `subtotal`) VALUES
(1, 'pk001', 7000, 4, 28000),
(2, 'p004', 8000, 2, 16000),
(2, 'pk001', 7000, 4, 28000);

-- --------------------------------------------------------

--
-- Table structure for table `data_detailtransaksi_sistemsaldo`
--

CREATE TABLE IF NOT EXISTS `data_detailtransaksi_sistemsaldo` (
  `id_nota` int(10) NOT NULL,
  `id_paket` varchar(5) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `banyak` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_detailtransaksi_sistemsaldo`
--

INSERT INTO `data_detailtransaksi_sistemsaldo` (`id_nota`, `id_paket`, `harga`, `banyak`, `subtotal`) VALUES
(2, 'p004', 8000, 1, 8000),
(4, 'pk002', 5000, 3, 17000),
(4, 'pk001', 7000, 2, 14000),
(4, 'p004', 8000, 3, 24000),
(5, 'pk001', 7000, 3, 21000),
(6, 'p004', 8000, 4, 32000),
(7, 'pk002', 5000, 2, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `data_paket`
--

CREATE TABLE IF NOT EXISTS `data_paket` (
  `id_paket` varchar(5) NOT NULL,
  `nm_paket` varchar(20) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id_paket`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_paket`
--

INSERT INTO `data_paket` (`id_paket`, `nm_paket`, `harga`, `ket`) VALUES
('p004', 'selimut', 8000, '3 hari selesai'),
('pk001', 'Reguler', 7000, '3 hari selesai'),
('pk002', 'Setrika', 5000, '2 hari selesai'),
('pk003', 'Express', 14000, '8 jam selesai'),
('pk004', 'Bedcover', 20000, '4 hari selesai');

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

CREATE TABLE IF NOT EXISTS `data_pelanggan` (
  `id_pel` varchar(12) NOT NULL,
  `nm_pel` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(12) NOT NULL,
  PRIMARY KEY (`id_pel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id_pel`, `nm_pel`, `alamat`, `no_hp`) VALUES
('085726203298', 'Mahardika', 'jalan jalan', '085726203298'),
('087737697213', 'Usman', 'jalan cinangkan nomer sekian', '087737697213');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi`
--

CREATE TABLE IF NOT EXISTS `data_transaksi` (
  `id_nota` int(10) NOT NULL AUTO_INCREMENT,
  `id_pel` varchar(20) NOT NULL,
  `tgl` date NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `status_bayar` varchar(20) NOT NULL,
  `status_cucian` varchar(20) NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `data_transaksi`
--

INSERT INTO `data_transaksi` (`id_nota`, `id_pel`, `tgl`, `total`, `status_bayar`, `status_cucian`) VALUES
(1, '087737697213', '2016-05-07', 28000, 'Belum Lunas', 'Selesai'),
(2, '085726203298', '2016-05-09', 44000, 'Lunas', 'Sudah Diambil'),
(3, '085726203298', '2016-05-10', 0, 'Lunas', 'Proses');

-- --------------------------------------------------------

--
-- Table structure for table `data_transaksi_sistemsaldo`
--

CREATE TABLE IF NOT EXISTS `data_transaksi_sistemsaldo` (
  `id_nota` int(10) NOT NULL AUTO_INCREMENT,
  `id_pel` varchar(20) NOT NULL,
  `debit` int(50) DEFAULT NULL,
  `kredit` int(50) DEFAULT NULL,
  `sisa_saldo` int(50) NOT NULL,
  `tgl` date NOT NULL,
  PRIMARY KEY (`id_nota`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `data_transaksi_sistemsaldo`
--

INSERT INTO `data_transaksi_sistemsaldo` (`id_nota`, `id_pel`, `debit`, `kredit`, `sisa_saldo`, `tgl`) VALUES
(2, '085726203298', 8000, 0, 0, '2016-05-10'),
(3, '085726203298', 100000, 0, 0, '2016-05-10'),
(4, '085726203298', 0, 55000, 0, '2016-05-10'),
(5, '087737697213', 0, 21000, 0, '2016-05-12'),
(6, '087737697213', 0, 32000, 0, '2016-05-12'),
(7, '087737697213', 0, 10000, 0, '2016-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(3) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(5) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_detailtransaksi`
--
ALTER TABLE `data_detailtransaksi`
  ADD CONSTRAINT `data_detailtransaksi_ibfk_1` FOREIGN KEY (`id_nota`) REFERENCES `data_transaksi` (`id_nota`) ON DELETE CASCADE ON UPDATE CASCADE;
