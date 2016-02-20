-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2016 at 10:10 
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poliklinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE IF NOT EXISTS `dokter` (
  `kode_dokter` varchar(10) NOT NULL,
  `kode_poli` varchar(10) NOT NULL,
  `nama_dokter` text NOT NULL,
  `alamat_dokter` text NOT NULL,
  `telpn_dokter` text NOT NULL,
  PRIMARY KEY (`kode_dokter`),
  KEY `kode_poli` (`kode_poli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`kode_dokter`, `kode_poli`, `nama_dokter`, `alamat_dokter`, `telpn_dokter`) VALUES
('DKTR-001', 'POLI-001', 'sulis', 'doko', '12345'),
('DKTR-002', 'POLI-002', 'mantri', 'sumber', '12346'),
('DKTR-003', 'POLI-003', 'sandi', 'sragi', '12347'),
('DKTR-004', 'POLI-005', 'bagong', 'jauh banget', '089456876543');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_praktek`
--

CREATE TABLE IF NOT EXISTS `jadwal_praktek` (
  `kode_jadwal` varchar(10) NOT NULL,
  `kode_dokter` varchar(10) NOT NULL,
  `hari` text NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  PRIMARY KEY (`kode_jadwal`),
  KEY `kode_dokter` (`kode_dokter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_praktek`
--

INSERT INTO `jadwal_praktek` (`kode_jadwal`, `kode_dokter`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
('JDWL-001', 'DKTR-001', 'senin', '00:09:00', '00:11:00'),
('JDWL-002', 'DKTR-002', 'selasa', '00:10:00', '00:11:00'),
('JDWL-003', 'DKTR-003', 'rabu', '00:08:00', '00:11:00');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_biaya`
--

CREATE TABLE IF NOT EXISTS `jenis_biaya` (
  `id_jenisbiaya` varchar(10) NOT NULL,
  `nama_biaya` text NOT NULL,
  `tarif` float NOT NULL,
  PRIMARY KEY (`id_jenisbiaya`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_biaya`
--

INSERT INTO `jenis_biaya` (`id_jenisbiaya`, `nama_biaya`, `tarif`) VALUES
('BAY-001', 'BPJS Kesehatan', 0),
('BAY-002', 'Pasien Umum', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `user` varchar(10) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `tipe_user` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user`, `pass`, `tipe_user`) VALUES
(1, 'superuser', '0baea2f0ae20150db78f58cddac442a9', 'super_user'),
(2, 'pegawai', '047aeeb234644b9e2d4138ed3bc7976a', 'pegawai'),
(3, 'dokter', 'd22af4180eee4bd95072eb90f94930e5', 'dokter'),
(4, 'apotik', '446cc4098bad4fdfc3332b0cdea675c9', 'apotik'),
(5, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE IF NOT EXISTS `obat` (
  `kode_obat` varchar(10) NOT NULL,
  `nama_obat` text NOT NULL,
  `merk` text NOT NULL,
  `satuan` text NOT NULL,
  `harga_jual` float NOT NULL,
  PRIMARY KEY (`kode_obat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`kode_obat`, `nama_obat`, `merk`, `satuan`, `harga_jual`) VALUES
('OBT-001', 'sakit kepala', 'panadol exstra', '2000', 2500),
('OBT-002', 'panu', 'kaplanak', '5000', 5500),
('OBT-003', 'panas', 'parasetamol', '2100', 2500);

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE IF NOT EXISTS `pasien` (
  `no_pas` varchar(10) NOT NULL,
  `nama_pas` text NOT NULL,
  `alamat_pas` text NOT NULL,
  `tlp_pas` text NOT NULL,
  `tgl_lhr` date NOT NULL,
  `jenis_kel` enum('P','L') NOT NULL,
  `tgl_registrasi` date NOT NULL,
  PRIMARY KEY (`no_pas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`no_pas`, `nama_pas`, `alamat_pas`, `tlp_pas`, `tgl_lhr`, `jenis_kel`, `tgl_registrasi`) VALUES
('PSN-001', 'jessica', 'doko sragi', '085645969222', '1997-12-15', 'P', '2016-02-11'),
('PSN-002', 'bahrul', 'sajda', '0892', '1997-06-09', 'L', '2016-02-19'),
('PSN-003', 'figi aditya savana', 'burengan', '089556771234', '1997-08-27', 'L', '2016-02-11'),
('PSN-004', 'febry', 'al-huda', '085764356876', '1997-06-09', 'L', '2016-02-14'),
('PSN-005', 'Rudy', 'Kediri', '0876547829992', '1997-06-09', 'L', '2016-02-14'),
('PSN-006', 'vicky', 'kandat', '085645969222', '1997-06-09', 'P', '2016-02-14');

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `nip` varchar(10) NOT NULL,
  `nama_peg` text NOT NULL,
  `almt_peg` text NOT NULL,
  `telpn_peg` text NOT NULL,
  `tgl_lhr` date NOT NULL,
  `jenis_kel` enum('P','L') NOT NULL,
  PRIMARY KEY (`nip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`nip`, `nama_peg`, `almt_peg`, `telpn_peg`, `tgl_lhr`, `jenis_kel`) VALUES
('PGW-001', 'anggi', 'ngronggo', '0851888757213', '1997-06-09', 'L'),
('PGW-003', 'nurlia nur', 'palembang', '087654223456', '1975-06-01', 'P'),
('PGW-004', 'babu', 'sumatra', '0851888757213', '1990-12-12', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

CREATE TABLE IF NOT EXISTS `pemeriksaan` (
  `no_pemeriksaan` varchar(10) NOT NULL,
  `no_pas` varchar(10) NOT NULL,
  `keluhan` varchar(225) NOT NULL,
  `diagnosa` varchar(225) NOT NULL,
  `perawatan` varchar(225) NOT NULL,
  `tindakan` varchar(225) NOT NULL,
  `berat_badan` float NOT NULL,
  `tensi_diastolik` int(11) NOT NULL,
  `tensi_sistolik` int(11) NOT NULL,
  PRIMARY KEY (`no_pemeriksaan`),
  KEY `no_pas` (`no_pas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pemeriksaan`
--

INSERT INTO `pemeriksaan` (`no_pemeriksaan`, `no_pas`, `keluhan`, `diagnosa`, `perawatan`, `tindakan`, `berat_badan`, `tensi_diastolik`, `tensi_sistolik`) VALUES
('PMRS-001', 'PSN-001', 'sakit', 'hati', 'minum', 'racun', 55, 10, 20),
('PMRS-002', 'PSN-002', 'kecapekan', 'banyak bekerja', 'istrahat', 'minum susu', 65, 20, 20),
('PMRS-003', 'PSN-006', 'mati rasa', 'jkbkb', 'nkjbk', 'jlbkl', 80, 70, 80);

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE IF NOT EXISTS `pendaftaran` (
  `no_pendaftaran` varchar(10) NOT NULL,
  `no_pas` varchar(10) NOT NULL,
  `nip` varchar(10) NOT NULL,
  `kode_jadwal` varchar(10) NOT NULL,
  `id_jenisbiaya` varchar(10) NOT NULL,
  `tgl_pendaftaran` datetime NOT NULL,
  `no_urut` int(11) NOT NULL,
  PRIMARY KEY (`no_pendaftaran`),
  KEY `id_jenisbiaya` (`id_jenisbiaya`),
  KEY `nip` (`nip`),
  KEY `kode_jadwal` (`kode_jadwal`),
  KEY `no_pas` (`no_pas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`no_pendaftaran`, `no_pas`, `nip`, `kode_jadwal`, `id_jenisbiaya`, `tgl_pendaftaran`, `no_urut`) VALUES
('1', 'PSN-001', 'PGW-001', 'JDWL-001', 'BAY-002', '2016-02-14 21:02:55', 1),
('2', 'PSN-006', 'PGW-003', 'JDWL-001', 'BAY-001', '2016-02-15 08:02:38', 2),
('3', 'PSN-006', 'PGW-001', 'JDWL-001', 'BAY-001', '2016-02-19 07:02:54', 3),
('4', 'PSN-001', 'PGW-001', 'JDWL-001', 'BAY-001', '2016-02-19 07:02:36', 4);

-- --------------------------------------------------------

--
-- Table structure for table `poli_klinik`
--

CREATE TABLE IF NOT EXISTS `poli_klinik` (
  `kode_poli` varchar(10) NOT NULL,
  `nama_poli` text NOT NULL,
  PRIMARY KEY (`kode_poli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `poli_klinik`
--

INSERT INTO `poli_klinik` (`kode_poli`, `nama_poli`) VALUES
('POLI-001', 'poli anak'),
('POLI-002', 'poli gigi'),
('POLI-003', 'poli kandungan'),
('POLI-004', 'poli kia'),
('POLI-005', 'poli mata'),
('POLI-006', 'poli payudara');

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE IF NOT EXISTS `resep` (
  `no_resep` varchar(10) NOT NULL,
  `no_pemeriksaan` varchar(10) NOT NULL,
  `kode_obat` varchar(10) NOT NULL,
  `dosis` text NOT NULL,
  `jumlah` float NOT NULL,
  PRIMARY KEY (`no_resep`),
  KEY `no_pemeriksaan` (`no_pemeriksaan`),
  KEY `kode_obat` (`kode_obat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resep`
--

INSERT INTO `resep` (`no_resep`, `no_pemeriksaan`, `kode_obat`, `dosis`, `jumlah`) VALUES
(' RSP-001', 'PMRS-001', 'OBT-001', '3x sehari', 2),
(' RSP-002', 'PMRS-003', 'OBT-002', '3x sehari', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
