-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2022 at 12:46 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sporadik`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_pendaftaran_permohonan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_identitas_alamat_penerima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanda_tangan_penerima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis_kegiatan_id` bigint UNSIGNED DEFAULT NULL,
  `verifikasi` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `user_id`, `tanggal`, `nomor_pendaftaran_permohonan`, `nama_identitas_alamat_penerima`, `tanda_tangan_penerima`, `keterangan`, `created_at`, `updated_at`, `jenis_kegiatan_id`, `verifikasi`) VALUES
(5, 1, '01/11/2022', '26038', 'Abu', 'public/user/data/asd.webp', 'Dewi', '2022-11-01 03:51:15', '2022-11-01 12:02:13', 1, 1),
(6, 1, '01/11/2022', '23123', 'Dadi', 'public/user/data/23123.webp', 'Bomi', '2022-11-01 12:06:09', '2022-11-01 12:06:09', 1, 1),
(7, 1, '02/11/2022', '231312', 'Ahmad', 'public/user/data/231312.webp', 'Mulai', '2022-11-01 22:34:04', '2022-11-01 22:34:53', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hasil_pekerjaan`
--

CREATE TABLE `hasil_pekerjaan` (
  `id` bigint UNSIGNED NOT NULL,
  `data_id` bigint UNSIGNED NOT NULL,
  `hasil_pekerjaan_yang_diterima` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_pekerjaan`
--

INSERT INTO `hasil_pekerjaan` (`id`, `data_id`, `hasil_pekerjaan_yang_diterima`, `created_at`, `updated_at`) VALUES
(7, 5, 'HM.123/Jelutung', '2022-11-01 03:51:15', '2022-11-01 03:51:15'),
(8, 5, 'HM.124/Jelutung', '2022-11-01 03:51:15', '2022-11-01 03:51:15'),
(13, 6, 'HM.123/Jelotong', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(14, 6, 'HM.124/Jelotong', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(15, 6, 'HM.125/Jelotong', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(16, 7, 'HM.123/Jelo', '2022-11-01 22:34:04', '2022-11-01 22:34:04'),
(17, 7, 'HM.124/Jelo', '2022-11-01 22:34:04', '2022-11-01 22:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kegiatan`
--

CREATE TABLE `jenis_kegiatan` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_kegiatan`
--

INSERT INTO `jenis_kegiatan` (`id`, `user_id`, `nama_kegiatan`, `created_at`, `updated_at`) VALUES
(1, 1, 'Budi', '2022-10-27 11:02:09', '2022-10-27 11:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2022_10_08_031244_create_data_table', 1),
(15, '2022_10_26_120249_create_jenis_kegiatan_table', 2),
(16, '2022_10_26_171246_delete_jenis_kegiatan_on_data_table', 2),
(17, '2022_10_26_171337_add_jenis_kegiatan_on_data_table', 2),
(21, '2022_10_27_042748_create_hasil_pekerjaan_table', 3),
(22, '2022_10_27_050024_delete_2_column_on_data_table', 3),
(23, '2022_10_27_050243_create_sertipikat_table', 3),
(24, '2022_11_01_131131_add_verifikasi_on_data_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sertipikat`
--

CREATE TABLE `sertipikat` (
  `id` bigint UNSIGNED NOT NULL,
  `data_id` bigint UNSIGNED NOT NULL,
  `no_seri_sertipikat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sertipikat`
--

INSERT INTO `sertipikat` (`id`, `data_id`, `no_seri_sertipikat`, `created_at`, `updated_at`) VALUES
(7, 5, 'OC3953640', '2022-11-01 03:51:15', '2022-11-01 03:51:15'),
(8, 5, 'OC3953641', '2022-11-01 03:51:15', '2022-11-01 03:51:15'),
(13, 6, 'NO1282400', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(14, 6, 'NO1282401', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(15, 6, 'NO1282402', '2022-11-01 20:37:52', '2022-11-01 20:37:52'),
(16, 7, 'DL6081712', '2022-11-01 22:34:04', '2022-11-01 22:34:04'),
(17, 7, 'DL6081713', '2022-11-01 22:34:04', '2022-11-01 22:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `avatar`, `name`, `email`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Administrator', 'admin@gmail.com', '$2y$10$jIe807fYAOuU1zpO1gUYL.Z9TyHAcJPzFMXCeNCF6keGBCWCdj/tm', 1, '2022-10-26 10:14:48', '2022-10-26 10:14:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_user_id_foreign` (`user_id`),
  ADD KEY `data_jenis_kegiatan_id_foreign` (`jenis_kegiatan_id`);

--
-- Indexes for table `hasil_pekerjaan`
--
ALTER TABLE `hasil_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hasil_pekerjaan_data_id_foreign` (`data_id`);

--
-- Indexes for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_kegiatan_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sertipikat`
--
ALTER TABLE `sertipikat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sertipikat_data_id_foreign` (`data_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hasil_pekerjaan`
--
ALTER TABLE `hasil_pekerjaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sertipikat`
--
ALTER TABLE `sertipikat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_jenis_kegiatan_id_foreign` FOREIGN KEY (`jenis_kegiatan_id`) REFERENCES `jenis_kegiatan` (`id`),
  ADD CONSTRAINT `data_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `hasil_pekerjaan`
--
ALTER TABLE `hasil_pekerjaan`
  ADD CONSTRAINT `hasil_pekerjaan_data_id_foreign` FOREIGN KEY (`data_id`) REFERENCES `data` (`id`);

--
-- Constraints for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD CONSTRAINT `jenis_kegiatan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sertipikat`
--
ALTER TABLE `sertipikat`
  ADD CONSTRAINT `sertipikat_data_id_foreign` FOREIGN KEY (`data_id`) REFERENCES `data` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
