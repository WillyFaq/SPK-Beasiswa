-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.6.26 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for dbspk_beasiswa
CREATE DATABASE IF NOT EXISTS `dbspk_beasiswa` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbspk_beasiswa`;

-- Dumping structure for table dbspk_beasiswa.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nama_admin` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.admin: ~2 rows (approximately)
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` (`username`, `password`, `nama_admin`) VALUES
	('admin', 'admin', 'Jamari Abidin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;

-- Dumping structure for table dbspk_beasiswa.hasil
CREATE TABLE IF NOT EXISTS `hasil` (
  `ID_HASIL` int(11) NOT NULL AUTO_INCREMENT,
  `NIS` char(6) DEFAULT NULL,
  `TOTAL_NILAI` double DEFAULT NULL,
  PRIMARY KEY (`ID_HASIL`),
  KEY `NIS` (`NIS`),
  CONSTRAINT `FK_hasil_siswa` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.hasil: ~5 rows (approximately)
/*!40000 ALTER TABLE `hasil` DISABLE KEYS */;
INSERT INTO `hasil` (`ID_HASIL`, `NIS`, `TOTAL_NILAI`) VALUES
	(1, 'N00001', 55.33334),
	(2, 'N00002', 61.33334),
	(3, 'N00003', 52.66667),
	(4, 'N00004', 74.33334),
	(5, 'N00005', 68.66667);
/*!40000 ALTER TABLE `hasil` ENABLE KEYS */;

-- Dumping structure for table dbspk_beasiswa.kriteria
CREATE TABLE IF NOT EXISTS `kriteria` (
  `ID_KRITERIA` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA_KRITERIA` varchar(100) DEFAULT NULL,
  `ATRIBUT` char(1) DEFAULT NULL,
  `BOBOT` float DEFAULT NULL,
  PRIMARY KEY (`ID_KRITERIA`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.kriteria: ~6 rows (approximately)
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` (`ID_KRITERIA`, `NAMA_KRITERIA`, `ATRIBUT`, `BOBOT`) VALUES
	(1, 'Prestasi Akademik', '1', 20),
	(2, 'Prestasi Non Akademik', '1', 15),
	(3, 'Nilai Rapor', '1', 10),
	(4, 'Kepribadian', '1', 20),
	(5, 'Pendapatan Orang Tua', '2', 10),
	(6, 'Tanggungan Orang Tua', '1', 10);
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;

-- Dumping structure for table dbspk_beasiswa.nilai
CREATE TABLE IF NOT EXISTS `nilai` (
  `ID_RANGE` int(11) NOT NULL,
  `NIS` char(6) NOT NULL,
  `NORMALISASI` float DEFAULT NULL,
  PRIMARY KEY (`ID_RANGE`,`NIS`),
  KEY `ID_RANGE` (`ID_RANGE`),
  KEY `FK_NILAI2` (`NIS`),
  CONSTRAINT `FK_NILAI2` FOREIGN KEY (`NIS`) REFERENCES `siswa` (`NIS`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_nilai_range_nilai` FOREIGN KEY (`ID_RANGE`) REFERENCES `range_nilai` (`ID_RANGE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.nilai: ~30 rows (approximately)
/*!40000 ALTER TABLE `nilai` DISABLE KEYS */;
INSERT INTO `nilai` (`ID_RANGE`, `NIS`, `NORMALISASI`) VALUES
	(2, 'N00003', 0.4),
	(3, 'N00001', 0.6),
	(3, 'N00002', 0.6),
	(4, 'N00005', 0.8),
	(5, 'N00004', 1),
	(7, 'N00003', 0.4),
	(9, 'N00001', 0.8),
	(9, 'N00002', 0.8),
	(9, 'N00005', 0.8),
	(10, 'N00004', 1),
	(13, 'N00003', 0.6),
	(14, 'N00001', 0.8),
	(14, 'N00002', 0.8),
	(14, 'N00005', 0.8),
	(15, 'N00004', 1),
	(16, 'N00001', 0.2),
	(18, 'N00004', 0.6),
	(19, 'N00002', 0.8),
	(19, 'N00005', 0.8),
	(20, 'N00003', 1),
	(22, 'N00005', 1),
	(23, 'N00001', 0.666667),
	(23, 'N00002', 0.666667),
	(23, 'N00003', 0.666667),
	(23, 'N00004', 0.666667),
	(27, 'N00001', 0.666667),
	(27, 'N00002', 0.666667),
	(27, 'N00004', 0.666667),
	(27, 'N00005', 0.666667),
	(28, 'N00003', 1);
/*!40000 ALTER TABLE `nilai` ENABLE KEYS */;

-- Dumping structure for table dbspk_beasiswa.range_nilai
CREATE TABLE IF NOT EXISTS `range_nilai` (
  `ID_RANGE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KRITERIA` int(11) NOT NULL,
  `KETERANGAN` varchar(100) DEFAULT NULL,
  `NILAI` float DEFAULT NULL,
  PRIMARY KEY (`ID_RANGE`),
  KEY `ID_KRITERIA` (`ID_KRITERIA`),
  CONSTRAINT `FK_range_nilai_kriteria` FOREIGN KEY (`ID_KRITERIA`) REFERENCES `kriteria` (`ID_KRITERIA`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.range_nilai: ~30 rows (approximately)
/*!40000 ALTER TABLE `range_nilai` DISABLE KEYS */;
INSERT INTO `range_nilai` (`ID_RANGE`, `ID_KRITERIA`, `KETERANGAN`, `NILAI`) VALUES
	(1, 1, 'Tidak Berprestasi', 1),
	(2, 1, 'Berprestasi Tingkat Sekolah', 2),
	(3, 1, 'Berprestasi Tingkat Kabupaten', 3),
	(4, 1, 'Berprestasi Tingkat Provinsi', 4),
	(5, 1, 'Berprestasi Tingkat Nasional', 5),
	(6, 2, 'Tidak Berprestasi', 1),
	(7, 2, 'Berprestasi Tingkat Sekolah', 2),
	(8, 2, 'Berprestasi Tingkat Kabupaten', 3),
	(9, 2, 'Berprestasi Tingkat Provinsi', 4),
	(10, 2, 'Berprestasi Tingkat Nasional', 5),
	(11, 4, 'Sangat Kurang', 1),
	(12, 4, 'Kurang Baik', 2),
	(13, 4, 'Cukup', 3),
	(14, 4, 'Baik', 4),
	(15, 4, 'Sangat Baik', 5),
	(16, 3, 'Rangking 5 Keatas', 1),
	(17, 3, 'Rangking 4', 2),
	(18, 3, 'Rangking 3', 3),
	(19, 3, 'Rangking 2', 4),
	(20, 3, 'Rangking 1', 5),
	(21, 5, 'Lebih dari Rp. 10,000,000', 1),
	(22, 5, 'Rp. 5,000,000 - 10,000,000', 2),
	(23, 5, 'Rp. 2,500,000 - 5,000,000', 3),
	(24, 5, 'Rp. 1,000,000 - 2,500,000', 4),
	(25, 5, 'Kurang dari Rp. 1,000,000', 5),
	(26, 6, '1', 1),
	(27, 6, '2', 2),
	(28, 6, '3', 3),
	(29, 6, '4', 4),
	(30, 6, 'Lebih dari 5', 5);
/*!40000 ALTER TABLE `range_nilai` ENABLE KEYS */;

-- Dumping structure for table dbspk_beasiswa.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `NIS` char(6) NOT NULL,
  `NAMA_SISWA` varchar(200) DEFAULT NULL,
  `JENIS_KELAMIN` char(1) DEFAULT NULL,
  `ALAMAT` text,
  `PEKERJAAN_ORANGTUA` varchar(100) DEFAULT NULL,
  `PENGHASILAN_ORANGTUA` float DEFAULT NULL,
  `JUMLAH_SAUDARA` int(11) DEFAULT NULL,
  PRIMARY KEY (`NIS`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table dbspk_beasiswa.siswa: ~5 rows (approximately)
/*!40000 ALTER TABLE `siswa` DISABLE KEYS */;
INSERT INTO `siswa` (`NIS`, `NAMA_SISWA`, `JENIS_KELAMIN`, `ALAMAT`, `PEKERJAAN_ORANGTUA`, `PENGHASILAN_ORANGTUA`, `JUMLAH_SAUDARA`) VALUES
	('N00001', 'Abdullah Addaba', 'L', 'Sidoarjo', 'Swasta', 4000000, 2),
	('N00002', 'Budi Laksana', 'L', 'Sidoarjo', 'Swasta', 2000000, 1),
	('N00003', 'Citra Kumala', 'P', 'Sidoarjo', 'PNS', 3000000, 3),
	('N00004', 'Dini Andini', 'P', 'Sidoarjo', 'PNS', 3500000, 2),
	('N00005', 'Eka Dwi Triputra', 'L', 'Sidoarjo', 'Swasta', 5000000, 2);
/*!40000 ALTER TABLE `siswa` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
