-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2019 at 02:13 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_service_panggil`
--
CREATE DATABASE IF NOT EXISTS `db_service_panggil` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_service_panggil`;

-- --------------------------------------------------------

--
-- Table structure for table `data_biaya_tambahan`
--

CREATE TABLE `data_biaya_tambahan` (
  `id_biaya_tambahan` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_biaya_tambahan`
--

INSERT INTO `data_biaya_tambahan` (`id_biaya_tambahan`, `id_pemesanan`, `keterangan`, `jumlah`) VALUES
(1, 1, 'Biaya Admninistrasi', 20000),
(2, 2, 'Biaya Admninistrasi', 20000),
(3, 8, 'Biaya Admninistrasi', 20000),
(4, 9, 'Biaya Admninistrasi', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `data_foto_kerusakan`
--

CREATE TABLE `data_foto_kerusakan` (
  `id_foto_kerusakan` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `url_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_foto_kerusakan`
--

INSERT INTO `data_foto_kerusakan` (`id_foto_kerusakan`, `id_pemesanan`, `url_file`) VALUES
(1, 1, 'assets/img/foto_kerusakan/08ecfe09f758cece49f1a3981e3a956b11451053.png'),
(2, 2, 'assets/img/foto_kerusakan/15b679aa92b7cf11ddcf08b0288644da61dca833.png'),
(3, 3, 'assets/img/foto_kerusakan/b8616e2a8bb160710a5e133f47bafe58aebcce26.jpg'),
(4, 5, 'assets/img/foto_kerusakan/ef3e0bad1c7c6ab1436edff6dc585305d2729007.png'),
(5, 5, 'assets/img/foto_kerusakan/6b896777123c4f0f2cf480774b40884e5942a7a3.png'),
(6, 6, 'assets/img/foto_kerusakan/fd7a1dde8a665fc704ea02888b2c603cd4d71e53.png'),
(7, 6, 'assets/img/foto_kerusakan/fbd97662a8f45082c705173fdff7214efeb5f093.png'),
(8, 7, 'assets/img/foto_kerusakan/ab9f2918b286fce188f960323373eb47df8b8935.png'),
(9, 7, 'assets/img/foto_kerusakan/ef3e0bad1c7c6ab1436edff6dc585305d2729007.png'),
(10, 8, 'assets/img/foto_kerusakan/2d0bd1261b6c54281b03727bf7ef0965281e9cde.png'),
(11, 8, 'assets/img/foto_kerusakan/2b4a9eab63aa15580e6d97fdff4a775d6e341442.jpeg'),
(12, 9, 'assets/img/foto_kerusakan/da9eb31afa662bbf05b8613342f43aade6530b15.png');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_menu_admin`
--

CREATE TABLE `data_konfigurasi_menu_admin` (
  `id_konfigurasi_menu_admin` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `konfigurasi_css` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_menu_pelanggan`
--

CREATE TABLE `data_konfigurasi_menu_pelanggan` (
  `id_konfigurasi_menu_pelanggan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `konfigurasi_css` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_menu_pelanggan`
--

INSERT INTO `data_konfigurasi_menu_pelanggan` (`id_konfigurasi_menu_pelanggan`, `nama`, `parent`, `url`, `konfigurasi_css`) VALUES
(1, 'Beranda', 0, '/service-panggil', ''),
(2, 'Layanan', 0, '#', ''),
(3, 'Perbaikan', 0, '/service-panggil/?content=perbaikan', ''),
(4, 'Teknisi', 0, '/service-panggil/?content=teknisi', NULL),
(5, 'Perbaikan', 2, '#', ''),
(6, 'Sparepart', 2, '/service-panggil/?content=layanan_sparepart', NULL),
(7, 'Personal Computer (PC)', 5, '/service-panggil/?content=layanan_perbaikan&amp;id=5', ''),
(8, 'Laptop / Notebook', 5, '/service-panggil/?content=layanan_perbaikan&amp;id=4', ''),
(9, 'Handphone', 5, '/service-panggil/?content=layanan_perbaikan&amp;id=3', ''),
(10, 'Smartphone', 5, '/service-panggil/?content=layanan_perbaikan&amp;id=2', ''),
(11, 'Tablet', 5, '/service-panggil/?content=layanan_perbaikan&amp;id=1', ''),
(12, 'Kontak', 0, '/service-panggil/?content=kontak', ''),
(13, 'SOP', 0, '?content=sop', ''),
(14, '&lt;i class=&quot;fa fa-cog&quot;&gt;&lt;/i&gt;', 0, '#', 'fz-18'),
(15, 'Profil', 14, '/service-panggil/?content=profil', ''),
(16, 'Login', 14, 'login.php', ''),
(17, 'Register', 14, 'register.php', ''),
(18, 'Logout', 14, '/service-panggil/?content=login_proses&amp;proses=logout', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_menu_teknisi`
--

CREATE TABLE `data_konfigurasi_menu_teknisi` (
  `id_konfigurasi_menu_teknisi` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `parent` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `konfigurasi_css` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_menu_teknisi`
--

INSERT INTO `data_konfigurasi_menu_teknisi` (`id_konfigurasi_menu_teknisi`, `nama`, `parent`, `url`, `konfigurasi_css`) VALUES
(1, 'Dashboard', 0, '/service-panggil/teknisi/?content=beranda', '');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_syarat_ketentuan`
--

CREATE TABLE `data_konfigurasi_syarat_ketentuan` (
  `id_konfigurasi_syarat_ketentuan` int(11) NOT NULL,
  `deskripsi_syarat_ketentuan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_syarat_ketentuan`
--

INSERT INTO `data_konfigurasi_syarat_ketentuan` (`id_konfigurasi_syarat_ketentuan`, `deskripsi_syarat_ketentuan`) VALUES
(1, 'Untuk setiap transaksi yang menggunakan layanan diantarkan ke lokasi dan telah disetujui akan dikenakan biaya administrasi sebesar Rp. 20.000.'),
(2, 'Apabila dalam transaksi terdapat alat/sparepart yang harus dibeli, maka biaya pembelian alat/sparepart dibebankan pada pelanggan dan akan dibayar pada saat akhir transaksi (Pembayaran Lunas). Ini berlaku juga pada transaksi yang telah dibatalkan.');

-- --------------------------------------------------------

--
-- Table structure for table `data_konfigurasi_umum`
--

CREATE TABLE `data_konfigurasi_umum` (
  `id_konfigurasi_umum` int(11) NOT NULL,
  `nama_konfigurasi` varchar(100) NOT NULL,
  `nilai_konfigurasi` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_konfigurasi_umum`
--

INSERT INTO `data_konfigurasi_umum` (`id_konfigurasi_umum`, `nama_konfigurasi`, `nilai_konfigurasi`, `keterangan`) VALUES
(2, 'no_rek_transaksi', '0901111111111111111', 'Bank BRI Atas Nama : Bla bla bla'),
(3, 'harga_panjar', '20000', 'Biaya panjar bagi pelanggan.'),
(4, 'office_address', 'Jl. Ance Dg. Ngoyo No.3, Masale, Kec. Panakkukang, Kota Makassar, Sulawesi Selatan 90324', 'Alamat Kantor : Jl. Ance Dg. Ngoyo No.3, Masale, Kec. Panakkukang, Kota Makassar, Sulawesi Selatan 90324'),
(5, 'phone_number', '0411 366 2291 / +62 813 4261 6083', 'No. Telp : 0411 366 2291 / +62 813 4261 6083'),
(6, 'official_website', 'http://www.fortinusa.co.id', 'Situs Resmi : http://www.fortinusa.co.id'),
(7, 'official_email', '', 'Email Resmi :'),
(8, 'open_hours', 'Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA', 'Jam Kerja : Senin-Jumat, pukul 08:00 AM â€“ 06:00 PM WITA'),
(10, 'biaya_administrasi', '20000', 'Biaya administrasi untuk setiap transaksi.');

-- --------------------------------------------------------

--
-- Table structure for table `data_layanan_jenis`
--

CREATE TABLE `data_layanan_jenis` (
  `id_layanan_jenis` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `sub_kategori` enum('Hardware','Software') NOT NULL,
  `nama_jenis_layanan` text NOT NULL,
  `harga` int(11) NOT NULL,
  `deskripsi_jenis_layanan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_layanan_jenis`
--

INSERT INTO `data_layanan_jenis` (`id_layanan_jenis`, `id_kategori`, `sub_kategori`, `nama_jenis_layanan`, `harga`, `deskripsi_jenis_layanan`) VALUES
(2, 1, 'Hardware', 'Ganti port charger', 20000, '<p>Layanan/Jasa penggantian&nbsp;sparepart&nbsp;port charger untuk perangkat Tablet...</p>\r\n'),
(3, 1, 'Hardware', 'Backup Data [&lt;= 10 GB]', 20000, ''),
(4, 1, 'Hardware', 'Backup Data [&gt; 10 GB]', 30000, ''),
(5, 1, 'Hardware', 'Backup Data [&gt; 50 GB]', 45000, ''),
(6, 1, 'Hardware', 'Layar Blank', 25000, ''),
(7, 1, 'Software', 'Layar Blank', 25000, ''),
(8, 1, 'Software', 'Install OS', 25000, ''),
(9, 1, 'Software', 'Install Aplikasi Standar', 25000, ''),
(10, 2, 'Hardware', 'Perbaikan LCD Rusak', 100000, ''),
(11, 2, 'Hardware', 'Perbaikan port charger rusak', 150000, ''),
(12, 2, 'Hardware', 'Ganti Battery', 10000, ''),
(13, 2, 'Software', 'Install OS', 50000, ''),
(14, 2, 'Software', 'Install Aplikasi', 10000, ''),
(15, 2, 'Software', 'Backup Data 5-10 Mb', 10000, ''),
(16, 2, 'Software', 'Backup Data &gt; 10 Mb', 20000, ''),
(17, 3, 'Hardware', 'Ganti LCD', 50000, ''),
(18, 3, 'Hardware', 'Ganti Battery', 10000, ''),
(19, 3, 'Hardware', 'Ganti Chasing', 10000, '<p>Blablablablablabla...</p>\r\n'),
(20, 3, 'Software', 'Reset Factory', 20000, ''),
(21, 3, 'Software', 'Install Aplikasi', 25000, ''),
(22, 3, 'Software', 'Backup Data 5-10 Mb', 30000, ''),
(23, 3, 'Software', 'Backup Data &gt; 10 Mb', 37000, ''),
(24, 1, 'Software', 'Reset Factory', 30000, ''),
(25, 4, 'Software', 'Install Ulang OS', 200000, ''),
(26, 4, 'Software', 'Install Aplikasi', 10000, ''),
(27, 4, 'Software', 'Backup Data [&gt; 50 MB]', 30000, ''),
(28, 4, 'Software', 'Backup Data [&gt; 10 MB]', 15000, ''),
(29, 4, 'Software', 'Backup Data [&gt; 5 MB]', 10000, '<p>Layanan untuk&nbsp;<em>back-up</em>&nbsp;data berupa&nbsp;file gambar,&nbsp;musik, dokumen atau file lain yang berada dalam perangkat Laptop/Notebook. Terbatas hanya untuk kapasitas kurang atau sama dengan 5 Mb dari total keseluruhan besar file...&nbsp;</p>\r\n'),
(30, 5, 'Hardware', 'Pengecekan PC', 50000, ''),
(31, 5, 'Software', 'Install OS + Software Office', 15000, ''),
(32, 5, 'Software', 'Install OS + Software Standar + Backup Email + Setting Email Outlook', 200000, ''),
(33, 5, 'Software', 'Install OS + Software Standar + Backup &amp; Restore Data [50 GB]', 250000, ''),
(34, 5, 'Software', 'Install OS + Software Standar + Backup &amp; Restore Data [80-100 GB]', 300000, ''),
(35, 5, 'Software', 'Install OS + Software Standar + Backup &amp; Restore Data [&gt; 150 GB]', 350000, '');

-- --------------------------------------------------------

--
-- Table structure for table `data_layanan_kategori`
--

CREATE TABLE `data_layanan_kategori` (
  `id_layanan_kategori` int(11) NOT NULL,
  `nama_kategori_layanan` varchar(50) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_layanan_kategori`
--

INSERT INTO `data_layanan_kategori` (`id_layanan_kategori`, `nama_kategori_layanan`, `gambar`, `deskripsi`) VALUES
(1, 'Tablet', 'assets/img/kategori_layanan/ff08bcfec83f8e42b91f65ea77ff454eebb48b7c.jpg', '&lt;p&gt;Layanan perbaikan serta penggantian sparepart untuk jenis perangkat Tablet masa kini dengan dukungan dari berbagai merk seperti :&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;- Apple.&lt;/li&gt;\r\n	&lt;li&gt;- Samsung.&lt;/li&gt;\r\n	&lt;li&gt;- Sony.&lt;/li&gt;\r\n	&lt;li&gt;- Xiaomi.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n'),
(2, 'Smartphone', 'assets/img/kategori_layanan/06a153484be07a4ac8c4c22f6c64db482dbce634.jpg', '&lt;p&gt;Layanan perbaikan serta penggantian sparepart untuk jenis perangkat Smartphone masa kini dengan dukungan dari berbagai merk seperti :&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;- Apple&lt;/li&gt;\r\n	&lt;li&gt;- Asus.&lt;/li&gt;\r\n	&lt;li&gt;- Google Nexus.&lt;/li&gt;\r\n	&lt;li&gt;- Meizu.&lt;/li&gt;\r\n	&lt;li&gt;- Oppo.&lt;/li&gt;\r\n	&lt;li&gt;- Samsung.&lt;/li&gt;\r\n	&lt;li&gt;- Sony.&lt;/li&gt;\r\n	&lt;li&gt;- Vivo.&lt;/li&gt;\r\n	&lt;li&gt;- Xiaomi.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n'),
(3, 'Handphone', 'assets/img/kategori_layanan/39ae5db5d39cd530fdafd3c7c894867d259e4632.jpg', '&lt;p&gt;Layanan perbaikan serta penggantian sparepart untuk jenis perangkat Handphone dengan dukungan dari berbagai merk seperti :&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;- Nokia.&lt;/li&gt;\r\n	&lt;li&gt;- Samsung.&lt;/li&gt;\r\n	&lt;li&gt;- Motorola.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n'),
(4, 'Laptop / Notebook', 'assets/img/kategori_layanan/5d0a2c2e964c6f80c0f6d39ab4ee3fb79b6fc09b.jpg', '&lt;p&gt;Laptop / Notebook :&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;- Acer&lt;/li&gt;\r\n	&lt;li&gt;- Apple&lt;/li&gt;\r\n	&lt;li&gt;- Asus&lt;/li&gt;\r\n	&lt;li&gt;- Compaq&lt;/li&gt;\r\n	&lt;li&gt;- Dell&lt;/li&gt;\r\n	&lt;li&gt;- Hewlett Packard (HP)&lt;/li&gt;\r\n	&lt;li&gt;- Sony Vaio&lt;/li&gt;\r\n&lt;/ul&gt;\r\n'),
(5, 'Personal Computer (PC)', 'assets/img/kategori_layanan/bf0b7d97b5697c5130a9739653df0f943f5465a2.jpg', '&lt;p&gt;Personal Computer (PC) :&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;- Acer&lt;/li&gt;\r\n	&lt;li&gt;- Apple&lt;/li&gt;\r\n	&lt;li&gt;- Asus&lt;/li&gt;\r\n	&lt;li&gt;- Compaq&lt;/li&gt;\r\n	&lt;li&gt;- Dell -&amp;gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `data_notifikasi`
--

CREATE TABLE `data_notifikasi` (
  `id_notifikasi` bigint(11) NOT NULL,
  `tipe_notifikasi` varchar(50) NOT NULL,
  `info_notifikasi` varchar(50) NOT NULL,
  `isi_notifikasi` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tujuan` enum('semua','administrator','teknisi','pelanggan','not_administrator','not_teknisi','not_pelanggan') NOT NULL,
  `status_show` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `status_baca` enum('belum','sudah') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_notifikasi`
--

INSERT INTO `data_notifikasi` (`id_notifikasi`, `tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tanggal`, `tujuan`, `status_show`, `status_baca`) VALUES
(1, 'error', 'Gagal', 'Gagal bro..!', '2019-08-07 18:49:51', 'administrator', 'sudah', 'sudah'),
(2, 'error', 'Perhatian', 'Coba 1...', '2019-08-08 09:13:15', 'administrator', 'sudah', 'sudah'),
(3, 'info', 'Informasi', 'Coba 1...', '2019-08-08 09:13:15', 'administrator', 'sudah', 'sudah'),
(4, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-08-09 06:40:16', 'administrator', 'sudah', 'sudah'),
(5, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-08-09 07:19:41', 'teknisi', 'sudah', 'sudah'),
(6, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-08-09 14:10:05', 'administrator', 'sudah', 'sudah'),
(7, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-08-09 14:12:28', 'teknisi', 'sudah', 'sudah'),
(8, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-11-03 09:26:05', 'administrator', 'sudah', 'sudah'),
(9, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-11-05 16:12:03', 'administrator', 'belum', 'belum'),
(10, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-11-05 16:24:45', 'teknisi', 'belum', 'belum'),
(11, 'info', 'Pengerjaan disetujui!', 'Pengerjaan baru telah disetujui..!', '2019-11-06 05:55:17', 'teknisi', 'belum', 'belum'),
(12, 'warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!', '2019-11-06 05:55:51', 'administrator', 'belum', 'belum'),
(13, 'warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!', '2019-11-06 05:55:51', 'teknisi', 'belum', 'belum'),
(14, 'success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', '2019-11-06 06:04:16', 'administrator', 'belum', 'belum'),
(15, 'success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', '2019-11-06 06:04:16', 'teknisi', 'belum', 'belum'),
(16, 'info', 'Pengerjaan disetujui!', 'Pengerjaan baru telah disetujui..!', '2019-11-06 13:21:23', 'teknisi', 'belum', 'belum'),
(17, 'info', 'Pengerjaan disetujui!', 'Pengerjaan baru telah disetujui..!', '2019-11-06 13:24:29', 'teknisi', 'belum', 'belum'),
(18, 'success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', '2019-11-06 13:26:50', 'administrator', 'belum', 'belum'),
(19, 'success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', '2019-11-06 13:26:50', 'teknisi', 'belum', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `data_notifikasi_administrator`
--

CREATE TABLE `data_notifikasi_administrator` (
  `id_notifikasi` bigint(11) NOT NULL,
  `tipe_notifikasi` varchar(50) NOT NULL,
  `info_notifikasi` varchar(50) NOT NULL,
  `isi_notifikasi` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_show` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `status_baca` enum('belum','sudah') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_notifikasi_administrator`
--

INSERT INTO `data_notifikasi_administrator` (`id_notifikasi`, `tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tanggal`, `status_show`, `status_baca`) VALUES
(1, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-11-05 16:18:30', 'sudah', 'sudah'),
(2, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-11-06 05:51:34', 'sudah', 'sudah'),
(3, 'warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!', '2019-11-06 06:02:24', 'sudah', 'sudah'),
(4, 'info', 'Baru!', 'Pemesanan baru telah masuk..!', '2019-11-06 13:18:00', 'sudah', 'sudah'),
(5, 'warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!', '2019-11-06 13:22:07', 'sudah', 'sudah'),
(6, 'warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!', '2019-11-06 13:25:45', 'sudah', 'sudah');

-- --------------------------------------------------------

--
-- Table structure for table `data_notifikasi_teknisi`
--

CREATE TABLE `data_notifikasi_teknisi` (
  `id_notifikasi` bigint(11) NOT NULL,
  `tipe_notifikasi` varchar(50) NOT NULL,
  `info_notifikasi` varchar(50) NOT NULL,
  `isi_notifikasi` text NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_teknisi` int(11) NOT NULL,
  `status_show` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `status_baca` enum('belum','sudah') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `data_notifikasi_teknisi`
--

INSERT INTO `data_notifikasi_teknisi` (`id_notifikasi`, `tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tanggal`, `id_teknisi`, `status_show`, `status_baca`) VALUES
(1, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-11-05 16:30:59', 3, 'sudah', 'sudah'),
(2, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-11-05 16:36:47', 3, 'sudah', 'sudah'),
(3, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-11-06 05:52:50', 3, 'sudah', 'sudah'),
(4, 'warning', 'Baru!', 'Pembayaran panjar untuk Transaksi dengan no PM-20191106065038 telah dilakukan..!', '2019-11-06 06:01:02', 3, 'sudah', 'sudah'),
(5, 'warning', 'Pengerjaan Selesai!', 'Pengerjaan telah selesai..!', '2019-11-06 06:01:51', 3, 'sudah', 'sudah'),
(6, 'warning', 'Baru!', 'Pembayaran lunas untuk Transaksi dengan no PM-20191106065038 telah dilakukan..!', '2019-11-06 06:03:55', 3, 'belum', 'sudah'),
(7, 'warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '2019-11-06 13:18:53', 1, 'sudah', 'sudah'),
(8, 'warning', 'Baru!', 'Pembayaran panjar untuk Transaksi dengan no PM-20191106141717 telah dilakukan..!', '2019-11-06 13:22:49', 1, 'sudah', 'belum'),
(9, 'warning', 'Baru!', 'Pembayaran lunas untuk Transaksi dengan no PM-20191106141717 telah dilakukan..!', '2019-11-06 13:26:13', 1, 'sudah', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `data_pelanggan`
--

CREATE TABLE `data_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `status_akun` enum('aktif','blokir') NOT NULL DEFAULT 'aktif',
  `tgl_daftar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_token` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pelanggan`
--

INSERT INTO `data_pelanggan` (`id_pelanggan`, `nama_lengkap`, `no_hp`, `email`, `alamat`, `username`, `password`, `url_foto`, `status_akun`, `tgl_daftar`, `user_token`) VALUES
(3, 'Ibnu Tuharea', '082193035842', 'ibent95tuny@gmail.com', 'Jl. Daeng Tata 1. BTN. Tabaria Blok G8 No. 6', 'ibent95', '1b8703bf3395138ead0245d5da376a5c', 'assets/img/pelanggan/fd7a1dde8a665fc704ea02888b2c603cd4d71e53.png', 'aktif', '2019-07-28 17:29:25', 'p5u7mldknj06sazyrqceov4x3'),
(6, 'Muhammad Rajab', '085343601019', 'ranhiar26@gmail.com', 'Jl. Goa Ria Laikang no 64 Makassar', '', '81e1603a7382d45254b8d72115f17649', NULL, 'aktif', '2018-12-22 21:15:06', '_mv2tjfbow0sarguh9xln8dzk');

-- --------------------------------------------------------

--
-- Table structure for table `data_pemesanan`
--

CREATE TABLE `data_pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `no_pemesanan` varchar(25) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `tanggal_pesan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_telp` varchar(13) NOT NULL,
  `datang_ke_lokasi` enum('ya','tidak') NOT NULL DEFAULT 'tidak',
  `tanggal_kerja` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `longlat` varchar(255) DEFAULT NULL,
  `keluhan` text NOT NULL,
  `total_harga` int(11) DEFAULT '0',
  `id_teknisi` int(11) DEFAULT '0',
  `nama_teknisi` varchar(100) DEFAULT NULL,
  `status_pemesanan` enum('tunggu','proses','batal','selesai') NOT NULL DEFAULT 'tunggu',
  `teknisi_check` enum('belum','sudah','selesai') NOT NULL DEFAULT 'belum',
  `pengerjaan_ke` int(11) NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL,
  `ulasan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pemesanan`
--

INSERT INTO `data_pemesanan` (`id_pemesanan`, `no_pemesanan`, `id_kategori`, `tanggal_pesan`, `id_pelanggan`, `nama_pelanggan`, `no_telp`, `datang_ke_lokasi`, `tanggal_kerja`, `alamat`, `longlat`, `keluhan`, `total_harga`, `id_teknisi`, `nama_teknisi`, `status_pemesanan`, `teknisi_check`, `pengerjaan_ke`, `rating`, `ulasan`) VALUES
(1, 'PM-20190807145331', 2, '2019-08-07 14:53:31', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-08-08', 'Lapangan BTN Tabaria, Jalan Dg Tata 1, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.4285711,-5.18354530144065', '&lt;p&gt;jlkno;lpo;&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'selesai', 'selesai', 2, 4, 'hosanhcfinjewdi'),
(2, 'PM-20190807151714', 2, '2019-08-07 15:17:14', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-08-08', 'Lapangan BTN Tabaria, Jalan Dg Tata 1, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '', '', 0, 3, 'Teknisi 3', 'proses', 'selesai', 1, 0, NULL),
(3, 'PM-20190809073928', 1, '2019-08-09 07:39:28', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-08-10', 'BTN Tamarunang Indah 2, Paccinongang, Kabupaten Gowa, Sulawesi Selatan, Indonesia', '', '&lt;p&gt;fcewfcewds&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'tunggu', 'belum', 0, 0, NULL),
(4, 'PM-20190809150946', 1, '2019-08-09 15:09:46', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-08-10', 'BTN Tamarunang Indah 2, Paccinongang, Kabupaten Gowa, Sulawesi Selatan, Indonesia', '', '&lt;p&gt;khjhjkh&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'tunggu', 'belum', 0, 0, NULL),
(5, 'PM-20191103102532', 2, '2019-11-03 10:25:32', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-11-04', 'Puskesmas BTN TABARIA, Jl. Dg. Tata Raya, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '', '&lt;p&gt;cdscdscsdcsd&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'tunggu', 'belum', 0, 0, NULL),
(6, 'PM-20191105171137', 2, '2019-11-05 17:11:37', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-11-06', 'BTN TABARIA, Permata V, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '', '&lt;p&gt;cdscsdverd&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'tunggu', 'belum', 0, 0, NULL),
(7, 'PM-20191105171719', 2, '2019-11-05 17:17:19', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-11-06', 'Btn tamarunang indah 2, Paccinongang, Gowa Regency, South Sulawesi, Indonesia', '119.47253969999997,-5.204175651446365', '&lt;p&gt;cfesdcfeswdcf&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'tunggu', 'belum', 0, 0, NULL),
(8, 'PM-20191106065038', 1, '2019-11-06 06:50:38', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-11-07', 'Puskesmas BTN TABARIA, Jl. Dg. Tata Raya, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.42868490000001,-5.1831583014404945', '&lt;p&gt;ncdjcnjsdn&lt;/p&gt;\r\n', 0, 3, 'Teknisi 3', 'selesai', 'selesai', 1, 4, ''),
(9, 'PM-20191106141717', 2, '2019-11-06 14:17:17', 3, 'Ibnu Tuharea', '082193035842', 'ya', '2019-11-07', 'BTN TABARIA, Permata V, Parang Tambung, Makassar City, South Sulawesi, Indonesia', '119.42002564999996,-5.181238851439977', '&lt;p&gt;jnsjfnsdnif&lt;/p&gt;\r\n', 0, 1, 'Teknisi 1', 'selesai', 'selesai', 2, 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `data_pemesanan_detail`
--

CREATE TABLE `data_pemesanan_detail` (
  `id_pemesanan_detail` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `jenis_pengerjaan` enum('software','hardware','sparepart','biaya_tambahan') NOT NULL,
  `id_jenis_layanan_sparepart` int(11) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT '0',
  `pengerjaan_ke` int(11) NOT NULL DEFAULT '0',
  `persetujuan_pelanggan` enum('belum','ya','tidak') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pemesanan_detail`
--

INSERT INTO `data_pemesanan_detail` (`id_pemesanan_detail`, `id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES
(1, 1, 'biaya_tambahan', 1, 20000, 1, 'ya'),
(2, 1, 'software', 13, 50000, 1, 'ya'),
(3, 1, 'software', 14, 10000, 1, 'ya'),
(4, 1, 'software', 15, 10000, 2, 'ya'),
(5, 2, 'biaya_tambahan', 2, 20000, 1, 'ya'),
(6, 2, 'software', 13, 50000, 1, 'ya'),
(7, 2, 'software', 14, 10000, 1, 'ya'),
(8, 8, 'biaya_tambahan', 3, 20000, 1, 'ya'),
(9, 8, 'software', 7, 25000, 1, 'ya'),
(10, 8, 'software', 8, 25000, 1, 'ya'),
(11, 9, 'biaya_tambahan', 4, 20000, 1, 'ya'),
(12, 9, 'software', 13, 50000, 1, 'ya'),
(13, 9, 'software', 14, 10000, 1, 'ya'),
(14, 9, 'hardware', 12, 10000, 2, 'ya');

-- --------------------------------------------------------

--
-- Table structure for table `data_pengguna`
--

CREATE TABLE `data_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `jenis_akun` enum('admin','teknisi','pimpinan','pelanggan') NOT NULL,
  `url_foto` varchar(100) DEFAULT NULL,
  `status_akun` enum('aktif','non-aktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_pengguna`
--

INSERT INTO `data_pengguna` (`id_pengguna`, `nama_lengkap`, `email`, `no_hp`, `alamat`, `username`, `password`, `jenis_akun`, `url_foto`, `status_akun`) VALUES
(1, 'Admin', 'admin@gmail.com', '08100000', 'Jl. Tidak Tahu', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'assets/img/pengguna/ef3e0bad1c7c6ab1436edff6dc585305d2729007.png', 'aktif'),
(2, 'Pimpinan', 'pimpinan@gmail.com', '081xxx', 'Jl. kakakakaka', 'pimpinan', '90973652b88fe07d05a4304f0a945de8', 'pimpinan', 'http://localhost/service-panggil/assets/img/pengguna/6b896777123c4f0f2cf480774b40884e5942a7a3.png', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `data_riwayat_pembayaran`
--

CREATE TABLE `data_riwayat_pembayaran` (
  `id_riwayat_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL DEFAULT '0',
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `bukti_pembayaran` varchar(255) NOT NULL,
  `info_pembayaran` enum('panjar','lunas') NOT NULL DEFAULT 'panjar',
  `tgl_pembayaran` date NOT NULL DEFAULT '0000-00-00',
  `konfirmasi_admin` enum('belum','ya','tidak') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_riwayat_pembayaran`
--

INSERT INTO `data_riwayat_pembayaran` (`id_riwayat_pembayaran`, `id_pemesanan`, `jumlah`, `bukti_pembayaran`, `info_pembayaran`, `tgl_pembayaran`, `konfirmasi_admin`) VALUES
(1, 1, 20000, 'assets/img/bukti_pembayaran/8c86d5ab48d3e14a2e7c67ca912510b41dd776f2.png', 'panjar', '2019-08-07', 'ya'),
(2, 1, 70000, 'assets/img/bukti_pembayaran/3f8634912429ea70a657d913ea77dee47963907e.png', 'lunas', '2019-08-07', 'ya'),
(3, 2, 20000, 'assets/img/bukti_pembayaran/8c86d5ab48d3e14a2e7c67ca912510b41dd776f2.png', 'panjar', '2019-08-07', 'ya'),
(4, 2, 60000, 'assets/img/bukti_pembayaran/fcede253c85734ac40b3e1b8ec4db2fafd79c10e.png', 'lunas', '2019-08-07', 'ya'),
(5, 8, 20000, 'assets/img/bukti_pembayaran/1cbca2edc3e8a8d15255e74614b1ba583e35fef8.png', 'panjar', '2019-11-06', 'ya'),
(6, 8, 50000, 'assets/img/bukti_pembayaran/f0f128389377d7e901fee9815f8e0d521d6724e7.png', 'lunas', '2019-11-06', 'ya'),
(7, 9, 20000, 'assets/img/bukti_pembayaran/1cbca2edc3e8a8d15255e74614b1ba583e35fef8.png', 'panjar', '2019-11-06', 'ya'),
(8, 9, 70000, 'assets/img/bukti_pembayaran/f0f128389377d7e901fee9815f8e0d521d6724e7.png', 'lunas', '2019-11-06', 'ya');

-- --------------------------------------------------------

--
-- Table structure for table `data_sparepart`
--

CREATE TABLE `data_sparepart` (
  `id_sparepart` int(11) NOT NULL,
  `nama_sparepart` varchar(150) NOT NULL,
  `harga` int(11) NOT NULL,
  `persediaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_sparepart`
--

INSERT INTO `data_sparepart` (`id_sparepart`, `nama_sparepart`, `harga`, `persediaan`) VALUES
(1, 'Port Carger', 350000, 12),
(2, 'Baterai', 500000, 24),
(3, 'LCD', 600000, 33);

-- --------------------------------------------------------

--
-- Table structure for table `data_teknisi`
--

CREATE TABLE `data_teknisi` (
  `id_teknisi` int(11) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `status_akun` enum('aktif','blokir') NOT NULL,
  `tgl_daftar` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_tersedia` enum('ya','tidak') NOT NULL DEFAULT 'ya'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_teknisi`
--

INSERT INTO `data_teknisi` (`id_teknisi`, `nama_lengkap`, `no_hp`, `email`, `alamat`, `username`, `password`, `url_foto`, `status_akun`, `tgl_daftar`, `status_tersedia`) VALUES
(1, 'Teknisi 1', '085243102673', 'teknisi1@servicemakassar.com', 'Jl. Dg', 'teknisi1', '491b4c7ab9757487389b0fbea6a1d2ea', 'assets/img/img/teknisi/fea2ffe7dc9d947f5a3016d06adc1bb16cd2ba37.png', 'aktif', '2018-12-22 20:20:47', 'ya'),
(2, 'Teknisi 2', '081xxxxxxxxx', 'teknisi2@gmail.com', 'Jl. Bla bla bla', 'teknisi2', '3a4bd8b8554827fe98db41e5ac1950b6', 'assets/img/img/teknisi/fea2ffe7dc9d947f5a3016d06adc1bb16cd2ba37.png', 'aktif', '2018-12-22 20:20:47', 'tidak'),
(3, 'Teknisi 3', '081xxxxxxxxx', 'tuny95ibent@gmail.com', 'Jl. Tidak tahu.', 'teknisi3', '4dc2645f60bd19ac6a922581439740db', 'assets/img/img/teknisi/fea2ffe7dc9d947f5a3016d06adc1bb16cd2ba37.png', 'aktif', '2018-12-22 20:20:47', 'tidak');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_biaya_tambahan`
--
ALTER TABLE `data_biaya_tambahan`
  ADD PRIMARY KEY (`id_biaya_tambahan`);

--
-- Indexes for table `data_foto_kerusakan`
--
ALTER TABLE `data_foto_kerusakan`
  ADD PRIMARY KEY (`id_foto_kerusakan`);

--
-- Indexes for table `data_konfigurasi_menu_admin`
--
ALTER TABLE `data_konfigurasi_menu_admin`
  ADD PRIMARY KEY (`id_konfigurasi_menu_admin`);

--
-- Indexes for table `data_konfigurasi_menu_pelanggan`
--
ALTER TABLE `data_konfigurasi_menu_pelanggan`
  ADD PRIMARY KEY (`id_konfigurasi_menu_pelanggan`);

--
-- Indexes for table `data_konfigurasi_menu_teknisi`
--
ALTER TABLE `data_konfigurasi_menu_teknisi`
  ADD PRIMARY KEY (`id_konfigurasi_menu_teknisi`);

--
-- Indexes for table `data_konfigurasi_syarat_ketentuan`
--
ALTER TABLE `data_konfigurasi_syarat_ketentuan`
  ADD PRIMARY KEY (`id_konfigurasi_syarat_ketentuan`);

--
-- Indexes for table `data_konfigurasi_umum`
--
ALTER TABLE `data_konfigurasi_umum`
  ADD PRIMARY KEY (`id_konfigurasi_umum`);

--
-- Indexes for table `data_layanan_jenis`
--
ALTER TABLE `data_layanan_jenis`
  ADD PRIMARY KEY (`id_layanan_jenis`);

--
-- Indexes for table `data_layanan_kategori`
--
ALTER TABLE `data_layanan_kategori`
  ADD PRIMARY KEY (`id_layanan_kategori`);

--
-- Indexes for table `data_notifikasi`
--
ALTER TABLE `data_notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `data_notifikasi_administrator`
--
ALTER TABLE `data_notifikasi_administrator`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `data_notifikasi_teknisi`
--
ALTER TABLE `data_notifikasi_teknisi`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `data_pemesanan`
--
ALTER TABLE `data_pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`);

--
-- Indexes for table `data_pemesanan_detail`
--
ALTER TABLE `data_pemesanan_detail`
  ADD PRIMARY KEY (`id_pemesanan_detail`);

--
-- Indexes for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `data_riwayat_pembayaran`
--
ALTER TABLE `data_riwayat_pembayaran`
  ADD PRIMARY KEY (`id_riwayat_pembayaran`);

--
-- Indexes for table `data_sparepart`
--
ALTER TABLE `data_sparepart`
  ADD PRIMARY KEY (`id_sparepart`);

--
-- Indexes for table `data_teknisi`
--
ALTER TABLE `data_teknisi`
  ADD PRIMARY KEY (`id_teknisi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_biaya_tambahan`
--
ALTER TABLE `data_biaya_tambahan`
  MODIFY `id_biaya_tambahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `data_foto_kerusakan`
--
ALTER TABLE `data_foto_kerusakan`
  MODIFY `id_foto_kerusakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `data_konfigurasi_menu_admin`
--
ALTER TABLE `data_konfigurasi_menu_admin`
  MODIFY `id_konfigurasi_menu_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_konfigurasi_menu_pelanggan`
--
ALTER TABLE `data_konfigurasi_menu_pelanggan`
  MODIFY `id_konfigurasi_menu_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `data_konfigurasi_menu_teknisi`
--
ALTER TABLE `data_konfigurasi_menu_teknisi`
  MODIFY `id_konfigurasi_menu_teknisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_konfigurasi_syarat_ketentuan`
--
ALTER TABLE `data_konfigurasi_syarat_ketentuan`
  MODIFY `id_konfigurasi_syarat_ketentuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_konfigurasi_umum`
--
ALTER TABLE `data_konfigurasi_umum`
  MODIFY `id_konfigurasi_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_layanan_jenis`
--
ALTER TABLE `data_layanan_jenis`
  MODIFY `id_layanan_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `data_layanan_kategori`
--
ALTER TABLE `data_layanan_kategori`
  MODIFY `id_layanan_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `data_notifikasi`
--
ALTER TABLE `data_notifikasi`
  MODIFY `id_notifikasi` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `data_notifikasi_administrator`
--
ALTER TABLE `data_notifikasi_administrator`
  MODIFY `id_notifikasi` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_notifikasi_teknisi`
--
ALTER TABLE `data_notifikasi_teknisi`
  MODIFY `id_notifikasi` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `data_pelanggan`
--
ALTER TABLE `data_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `data_pemesanan`
--
ALTER TABLE `data_pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `data_pemesanan_detail`
--
ALTER TABLE `data_pemesanan_detail`
  MODIFY `id_pemesanan_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `data_pengguna`
--
ALTER TABLE `data_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `data_riwayat_pembayaran`
--
ALTER TABLE `data_riwayat_pembayaran`
  MODIFY `id_riwayat_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_sparepart`
--
ALTER TABLE `data_sparepart`
  MODIFY `id_sparepart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `data_teknisi`
--
ALTER TABLE `data_teknisi`
  MODIFY `id_teknisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
