-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table simpus.anggota
DROP TABLE IF EXISTS `anggota`;
CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `kode_anggota` varchar(9) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `jk_anggota` char(1) NOT NULL,
  `jurusan_anggota` varchar(2) NOT NULL,
  `no_telp_anggota` varchar(13) NOT NULL,
  `alamat_anggota` varchar(100) NOT NULL,
  `kelompok` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`),
  UNIQUE KEY `kode_anggota` (`kode_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table simpus.anggota: ~2 rows (approximately)
DELETE FROM `anggota`;
INSERT INTO `anggota` (`id_anggota`, `kode_anggota`, `nama_anggota`, `jk_anggota`, `jurusan_anggota`, `no_telp_anggota`, `alamat_anggota`, `kelompok`) VALUES
	(1, '12', 'Paijo OK', 'L', 'TI', '082227131797', 'Taman Siswa Yogyakarta', 'Mahasiswa'),
	(3, '99', 'OK', 'P', 'In', '1', '1', 'Dosen');

-- Dumping structure for table simpus.buku
DROP TABLE IF EXISTS `buku`;
CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `kode_buku` char(5) NOT NULL,
  `judul_buku` varchar(50) NOT NULL,
  `id_penulis` varchar(50) NOT NULL,
  `id_penerbit` varchar(50) NOT NULL,
  `tahun_penerbit` char(4) NOT NULL,
  `jenisbuku` varchar(100) DEFAULT 'Buku',
  `jmlbuku` int(11) DEFAULT 0,
  `stok` int(11) NOT NULL,
  `noklasifikasi` varchar(50) DEFAULT '-',
  `edisi` text DEFAULT '-',
  `kolasi` text DEFAULT '-',
  `isbn` text DEFAULT '-',
  `kunci_jejakan` text DEFAULT '-',
  `jejakan` text DEFAULT '-',
  PRIMARY KEY (`id_buku`),
  UNIQUE KEY `kode_buku` (`kode_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table simpus.buku: ~2 rows (approximately)
DELETE FROM `buku`;
INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul_buku`, `id_penulis`, `id_penerbit`, `tahun_penerbit`, `jenisbuku`, `jmlbuku`, `stok`, `noklasifikasi`, `edisi`, `kolasi`, `isbn`, `kunci_jejakan`, `jejakan`) VALUES
	(1, '1234', 'Sepanjang Tambak Bandeng ', '3', '2', '2020', 'Modul', 15, 9, '912', '--Cet. 4. – Bandung: CV Lestari, 2005.', '128 hlm.; 21cm.', 'ISBN 979-9133-86-6', '1. Bandeng', 'I. Judul'),
	(2, '12345', 'Algoritma Pemrograman', '2', '2', '2019', 'Skripsi', 25, 14, '523', '-- Cet 1. Bandung 2018', '1200 hal', 'ISBN 1289889', '1. Algoritma', 'I. Judul');

-- Dumping structure for table simpus.jenisbuku
DROP TABLE IF EXISTS `jenisbuku`;
CREATE TABLE IF NOT EXISTS `jenisbuku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenisbuku` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simpus.jenisbuku: ~6 rows (approximately)
DELETE FROM `jenisbuku`;
INSERT INTO `jenisbuku` (`id`, `jenisbuku`) VALUES
	(1, 'Diktat'),
	(2, 'Skripsi'),
	(3, 'Kerja Praktek'),
	(4, 'Referensi'),
	(5, 'Modul'),
	(6, 'Buku');

-- Dumping structure for table simpus.peminjaman
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `f_pinjam` varchar(1) CHARACTER SET utf8mb4 DEFAULT '1',
  PRIMARY KEY (`id_peminjaman`),
  KEY `id_buku` (`id_buku`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_petugas` (`id_petugas`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table simpus.peminjaman: ~7 rows (approximately)
DELETE FROM `peminjaman`;
INSERT INTO `peminjaman` (`id_peminjaman`, `tanggal_pinjam`, `tanggal_kembali`, `id_buku`, `id_anggota`, `id_petugas`, `f_pinjam`) VALUES
	(36, '2022-04-27', '2022-04-30', 1, 1, 1, '0'),
	(37, '2022-04-27', '2022-04-30', 2, 1, 1, '0'),
	(38, '2022-04-27', '2022-04-30', 2, 1, 1, '0'),
	(39, '2022-04-27', '2022-04-30', 1, 1, 1, '0'),
	(40, '2022-04-27', '2022-04-30', 2, 1, 1, '0'),
	(41, '2022-04-30', '2022-05-03', 2, 1, 1, '1'),
	(42, '2022-04-30', '2022-05-03', 1, 1, 1, '1');

-- Dumping structure for table simpus.penerbit
DROP TABLE IF EXISTS `penerbit`;
CREATE TABLE IF NOT EXISTS `penerbit` (
  `id_penerbit` int(11) NOT NULL AUTO_INCREMENT,
  `nama_penerbit` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  PRIMARY KEY (`id_penerbit`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simpus.penerbit: ~2 rows (approximately)
DELETE FROM `penerbit`;
INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`) VALUES
	(1, 'Ganesha', 'Bandung'),
	(2, 'InfoKom', 'Jakarta');

-- Dumping structure for table simpus.pengembalian
DROP TABLE IF EXISTS `pengembalian`;
CREATE TABLE IF NOT EXISTS `pengembalian` (
  `id_pengembalian` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_pengembalian` date NOT NULL,
  `denda` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  PRIMARY KEY (`id_pengembalian`),
  KEY `id_petugas` (`id_petugas`),
  KEY `id_anggota` (`id_anggota`),
  KEY `id_buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table simpus.pengembalian: ~5 rows (approximately)
DELETE FROM `pengembalian`;
INSERT INTO `pengembalian` (`id_pengembalian`, `tanggal_pengembalian`, `denda`, `id_buku`, `id_anggota`, `id_petugas`) VALUES
	(1, '2022-04-27', 0, 2, 1, 1),
	(2, '2022-04-27', 0, 2, 1, 1),
	(3, '2022-04-27', 0, 1, 1, 1),
	(4, '2022-04-27', 0, 1, 1, 1),
	(5, '2022-04-27', 0, 2, 1, 1);

-- Dumping structure for table simpus.pengunjung
DROP TABLE IF EXISTS `pengunjung`;
CREATE TABLE IF NOT EXISTS `pengunjung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tglkunjung` date DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `keperluan` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simpus.pengunjung: ~6 rows (approximately)
DELETE FROM `pengunjung`;
INSERT INTO `pengunjung` (`id`, `tglkunjung`, `id_anggota`, `nama`, `keperluan`) VALUES
	(1, '2022-04-20', 0, 'Tamu', NULL),
	(2, '2022-04-20', 1, 'Paijo', NULL),
	(3, '2022-04-26', 0, 'Tamu', NULL),
	(4, '2022-04-26', 1, 'Paijo', NULL),
	(5, '2022-04-29', 0, 'Tamu', NULL);

-- Dumping structure for table simpus.penulis
DROP TABLE IF EXISTS `penulis`;
CREATE TABLE IF NOT EXISTS `penulis` (
  `id_penulis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `nama_penulis` text DEFAULT NULL,
  PRIMARY KEY (`id_penulis`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simpus.penulis: ~3 rows (approximately)
DELETE FROM `penulis`;
INSERT INTO `penulis` (`id_penulis`, `nama_depan`, `nama_belakang`, `nama_penulis`) VALUES
	(1, 'Jons', 'Willey', 'Jons Willey and Sons'),
	(2, 'Pepep', 'Andromeda', 'Pepep Andromeda'),
	(3, 'Kardiman', 'Kardiman', 'Kardiman');

-- Dumping structure for table simpus.petugas
DROP TABLE IF EXISTS `petugas`;
CREATE TABLE IF NOT EXISTS `petugas` (
  `id_petugas` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) DEFAULT NULL,
  `role_id` varchar(50) DEFAULT NULL,
  `pwd` text DEFAULT NULL,
  PRIMARY KEY (`id_petugas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table simpus.petugas: ~1 rows (approximately)
DELETE FROM `petugas`;
INSERT INTO `petugas` (`id_petugas`, `userid`, `role_id`, `pwd`) VALUES
	(1, 'admin', 'admin', '444bcb3a3fcf8389296c49467f27e1d6');

-- Dumping structure for table simpus.rak
DROP TABLE IF EXISTS `rak`;
CREATE TABLE IF NOT EXISTS `rak` (
  `id_rak` int(11) NOT NULL AUTO_INCREMENT,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi_rak` varchar(50) NOT NULL,
  `id_buku` int(11) NOT NULL,
  PRIMARY KEY (`id_rak`),
  KEY `id_buku` (`id_buku`),
  CONSTRAINT `rak_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table simpus.rak: ~2 rows (approximately)
DELETE FROM `rak`;
INSERT INTO `rak` (`id_rak`, `nama_rak`, `lokasi_rak`, `id_buku`) VALUES
	(1, 'Rak 1', 'Lemari 1', 2),
	(2, 'Rak 2', 'Lemari 2', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
