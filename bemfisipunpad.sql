-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2021 at 07:14 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bemfisipunpad`
--

-- --------------------------------------------------------

--
-- Table structure for table `build_akun_media_sosial`
--

CREATE TABLE `build_akun_media_sosial` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `image` text COLLATE latin1_general_ci DEFAULT NULL,
  `name` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `id_name` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `link` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_akun_pendukung`
--

CREATE TABLE `build_akun_pendukung` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `content` text COLLATE latin1_general_ci DEFAULT NULL,
  `image` text COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_biro_department`
--

CREATE TABLE `build_biro_department` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `name_dept_biro` text COLLATE latin1_general_ci DEFAULT NULL,
  `name_chairman` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `photo_chairman` text COLLATE latin1_general_ci DEFAULT NULL,
  `name_vice` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `photo_vice` text COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `type` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `department` varchar(100) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_configuration`
--

CREATE TABLE `build_configuration` (
  `id` varchar(65) NOT NULL,
  `title_website` varchar(65) NOT NULL,
  `title_cms` varchar(65) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(65) NOT NULL,
  `version` varchar(65) DEFAULT NULL,
  `jumlah_departementbiro` varchar(100) DEFAULT NULL,
  `jumlah_staff` varchar(100) DEFAULT NULL,
  `jumlah_programkerja` varchar(100) DEFAULT NULL,
  `jumlah_aksi` varchar(100) DEFAULT NULL,
  `jumlah_kajian` varchar(100) DEFAULT NULL,
  `jumlah_postinstagram` varchar(100) DEFAULT NULL,
  `link_instagram` varchar(100) DEFAULT NULL,
  `link_line` varchar(100) DEFAULT NULL,
  `link_twitter` varchar(100) DEFAULT NULL,
  `link_youtube` varchar(100) DEFAULT NULL,
  `link_dokumentasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_data_mahasiswa`
--

CREATE TABLE `build_data_mahasiswa` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `angkatan` varchar(255) DEFAULT NULL,
  `alias` varchar(255) NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `file` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `build_data_prestasi`
--

CREATE TABLE `build_data_prestasi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `jurusan_angkatan` varchar(255) DEFAULT NULL,
  `prestasi` text DEFAULT NULL,
  `alias` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `build_faq`
--

CREATE TABLE `build_faq` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `questions` text COLLATE latin1_general_ci DEFAULT NULL,
  `answer` text COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_himpunan_huria_mahasiswa_dan_ukm`
--

CREATE TABLE `build_himpunan_huria_mahasiswa_dan_ukm` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `content` text COLLATE latin1_general_ci DEFAULT NULL,
  `image` text COLLATE latin1_general_ci DEFAULT NULL,
  `link_instagram` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `category` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_kategori_dokumentasi`
--

CREATE TABLE `build_kategori_dokumentasi` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `photo` text COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_list_dokumentasi`
--

CREATE TABLE `build_list_dokumentasi` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `content` text COLLATE latin1_general_ci DEFAULT NULL,
  `photo` text COLLATE latin1_general_ci DEFAULT NULL,
  `category` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_list_position`
--

CREATE TABLE `build_list_position` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `position` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_list_sosial_media`
--

CREATE TABLE `build_list_sosial_media` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `title` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `icon` text COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_page`
--

CREATE TABLE `build_page` (
  `id` varchar(65) NOT NULL,
  `tobe` varchar(65) NOT NULL,
  `category` varchar(65) NOT NULL,
  `name` text NOT NULL,
  `alias` text NOT NULL,
  `setup` varchar(65) NOT NULL,
  `file_name` text NOT NULL,
  `target` varchar(65) NOT NULL,
  `publish` varchar(65) NOT NULL,
  `link` text NOT NULL,
  `reorder` int(11) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_pimpinan_kabinet`
--

CREATE TABLE `build_pimpinan_kabinet` (
  `id` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `alias` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `photo` text COLLATE latin1_general_ci DEFAULT NULL,
  `position` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_privileges`
--

CREATE TABLE `build_privileges` (
  `id` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `icon` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `name` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `alias` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `status` enum('active','inactive') COLLATE latin1_general_ci NOT NULL,
  `reorder` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_privileges_acc`
--

CREATE TABLE `build_privileges_acc` (
  `id` varchar(65) NOT NULL,
  `name` varchar(65) NOT NULL,
  `alias` varchar(65) NOT NULL,
  `reorder` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_privileges_item`
--

CREATE TABLE `build_privileges_item` (
  `id` varchar(65) NOT NULL,
  `name` varchar(65) NOT NULL,
  `alias` varchar(65) NOT NULL,
  `id_priv` varchar(65) NOT NULL,
  `id_priv_acc` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `reorder` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(65) NOT NULL,
  `defaults` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_role`
--

CREATE TABLE `build_role` (
  `id` varchar(65) NOT NULL,
  `name` varchar(65) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_role_detail`
--

CREATE TABLE `build_role_detail` (
  `id` varchar(65) NOT NULL,
  `id_role` varchar(65) DEFAULT NULL,
  `page` varchar(65) DEFAULT NULL,
  `role` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_sosmed_pendukung`
--

CREATE TABLE `build_sosmed_pendukung` (
  `id` varchar(65) COLLATE latin1_general_ci NOT NULL,
  `id_akun_pendukung` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `id_sosmed` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `link` text COLLATE latin1_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `build_user`
--

CREATE TABLE `build_user` (
  `id` varchar(65) NOT NULL,
  `name` varchar(65) NOT NULL,
  `email` varchar(65) NOT NULL,
  `username` varchar(65) NOT NULL,
  `password` text NOT NULL,
  `photo` text NOT NULL,
  `id_role` varchar(65) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(65) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) DEFAULT NULL,
  `reorder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `build_vocab`
--

CREATE TABLE `build_vocab` (
  `id` varchar(65) NOT NULL,
  `name` varchar(65) DEFAULT NULL,
  `alias` varchar(65) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(65) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(65) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `reorder` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `build_akun_media_sosial`
--
ALTER TABLE `build_akun_media_sosial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_akun_pendukung`
--
ALTER TABLE `build_akun_pendukung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_biro_department`
--
ALTER TABLE `build_biro_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_configuration`
--
ALTER TABLE `build_configuration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_data_mahasiswa`
--
ALTER TABLE `build_data_mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_data_prestasi`
--
ALTER TABLE `build_data_prestasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_faq`
--
ALTER TABLE `build_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_himpunan_huria_mahasiswa_dan_ukm`
--
ALTER TABLE `build_himpunan_huria_mahasiswa_dan_ukm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_kategori_dokumentasi`
--
ALTER TABLE `build_kategori_dokumentasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_list_dokumentasi`
--
ALTER TABLE `build_list_dokumentasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_list_position`
--
ALTER TABLE `build_list_position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_list_sosial_media`
--
ALTER TABLE `build_list_sosial_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_page`
--
ALTER TABLE `build_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_pimpinan_kabinet`
--
ALTER TABLE `build_pimpinan_kabinet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_privileges`
--
ALTER TABLE `build_privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_privileges_acc`
--
ALTER TABLE `build_privileges_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_privileges_item`
--
ALTER TABLE `build_privileges_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_role`
--
ALTER TABLE `build_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_role_detail`
--
ALTER TABLE `build_role_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_sosmed_pendukung`
--
ALTER TABLE `build_sosmed_pendukung`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_user`
--
ALTER TABLE `build_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `build_vocab`
--
ALTER TABLE `build_vocab`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `build_data_mahasiswa`
--
ALTER TABLE `build_data_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
