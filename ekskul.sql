-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 04:38 AM
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
-- Database: `ekskul`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` bigint(20) UNSIGNED NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `kehadiran` enum('hadir','izin','sakit','alpa') NOT NULL,
  `status` enum('terverifikasi','belum terverifikasi') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ekskul`
--

CREATE TABLE `ekskul` (
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `nama_ekskul` varchar(30) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `jml_anggota` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ekskul`
--

INSERT INTO `ekskul` (`id_ekskul`, `nama_ekskul`, `slug`, `jml_anggota`, `deskripsi`, `gambar`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Basket', 'basket', 0, 'Ekstrakurikuler Basket', 'pp_ekskul/VmxnbbwGnCUi0U9kWhkWZRW2e9uMhvjG8Qbt1CzO.jpg', 0, NULL, NULL),
(2, 'Paskibra', 'paskibra', 0, 'Ekstrakurikuler ', 'pp_ekskul/Osf5jstKX8niY7kltQUvMuv4oB3wSjza9vxBMjIX.png', 0, NULL, NULL),
(3, 'Futsal', 'futsal', 0, 'Ekstrakurikuler Futsal', 'pp_ekskul/Osf5jstKX8niY7kltQUvMuv4oB3wSjza9vxBMjIX.png', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ekskul_user`
--

CREATE TABLE `ekskul_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ekskul_id` bigint(20) UNSIGNED NOT NULL,
  `jabatan` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ekskul_user`
--

INSERT INTO `ekskul_user` (`id`, `user_id`, `ekskul_id`, `jabatan`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(2, 3, 1, 2, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(3, 4, 1, 3, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(4, 5, 1, 4, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(5, 6, 1, NULL, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(6, 7, 2, 1, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(7, 8, 2, 2, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(8, 9, 2, 3, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(9, 10, 2, 4, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(10, 1, 2, NULL, '2025-04-22 06:32:13', '2025-04-22 06:32:13'),
(11, 11, 3, 2, '2025-04-22 06:32:13', '2025-04-22 06:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambar_ekskul`
--

CREATE TABLE `gambar_ekskul` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ekskul_id` bigint(20) UNSIGNED NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_kuis`
--

CREATE TABLE `hasil_kuis` (
  `id_hasil` bigint(20) UNSIGNED NOT NULL,
  `id_kuis` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `skor` varchar(255) NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` enum('pending','diterima','ditolak') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_kuis`
--

INSERT INTO `hasil_kuis` (`id_hasil`, `id_kuis`, `id_user`, `id_ekskul`, `skor`, `bukti`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '100', 'bukti_kuis/j554YzLkIQcmhvgEKkSUYyT9VNc1zSY7gcPBs20T.jpg', 'ditolak', '2025-04-22 00:59:37', '2025-04-22 01:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` bigint(20) UNSIGNED NOT NULL,
  `nama_jabatan` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `nama_jabatan`, `slug`) VALUES
(1, 'Pembina', 'pembina'),
(2, 'Ketua', 'ketua'),
(3, 'Sekertaris', 'sekertaris'),
(4, 'Bendahara', 'bendahara');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` bigint(20) UNSIGNED NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `hari` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_berakhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` bigint(20) UNSIGNED NOT NULL,
  `kelas` enum('10','11','12') NOT NULL,
  `jurusan` enum('PPLG','DKV','AKT','ANM','BDP') NOT NULL,
  `nomor_kelas` enum('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`, `jurusan`, `nomor_kelas`) VALUES
(1, '10', 'PPLG', '1'),
(2, '10', 'DKV', '2'),
(3, '11', 'AKT', '1'),
(4, '12', 'ANM', '3'),
(5, '12', 'BDP', '2');

-- --------------------------------------------------------

--
-- Table structure for table `kuis`
--

CREATE TABLE `kuis` (
  `id_kuis` bigint(20) UNSIGNED NOT NULL,
  `nama_kuis` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi_kuis` varchar(255) NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kuis`
--

INSERT INTO `kuis` (`id_kuis`, `nama_kuis`, `slug`, `isi_kuis`, `id_ekskul`, `created_at`, `updated_at`) VALUES
(1, 'kuis 1', 'kuis-1-2025-22-Apr-075628', 'https://youtube.com', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` bigint(20) UNSIGNED NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `isi_materi` text NOT NULL,
  `lampiran_materi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_25_025343_create_ekskul_table', 1),
(5, '2025_01_31_152010_create_jabatan_table', 1),
(6, '2025_01_31_152029_create_materi_table', 1),
(7, '2025_01_31_152045_create_kuis_table', 1),
(8, '2025_01_31_152107_create_hasil_kuis_table', 1),
(9, '2025_01_31_152118_create_absensi_table', 1),
(10, '2025_02_13_050940_create_ekskul_user_table', 1),
(11, '2025_02_24_093520_create_pengajuan_ekskuls_table', 1),
(12, '2025_02_26_030055_create_kegiatan_table', 1),
(13, '2025_02_26_044706_create_pendaftaran_table', 1),
(14, '2025_03_08_015057_create_notifikasi_table', 1),
(15, '2025_03_11_024650_create_gambar_ekskuls_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('materi','pendaftaran','kuis','kegiatan','diterima','ditolak','dikeluarkan','keluar','lainya') NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `title`, `category`, `id_ekskul`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Kuis Baru', 'kuis', 1, 'Kuis baru telah ditambahkan', '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(2, 'Hasil Kuis Ditolak', 'kuis', 1, 'Hasil kuis yang anda kirim telah ditolak', '2025-04-22 01:00:10', '2025-04-22 01:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_target`
--

CREATE TABLE `notifikasi_target` (
  `id_target` bigint(20) UNSIGNED NOT NULL,
  `id_notifikasi` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasi_target`
--

INSERT INTO `notifikasi_target` (`id_target`, `id_notifikasi`, `id_user`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 0, '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(2, 1, 3, 0, '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(3, 1, 4, 0, '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(4, 1, 5, 0, '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(5, 1, 6, 0, '2025-04-22 00:56:28', '2025-04-22 00:56:28'),
(6, 2, 1, 0, '2025-04-22 01:00:10', '2025-04-22 01:00:10');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_ekskul` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','diterima','ditolak','keluar','dikeluarkan') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_user`, `id_ekskul`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'diterima', NULL, NULL),
(2, 3, 1, 'diterima', NULL, NULL),
(3, 4, 1, 'diterima', NULL, NULL),
(4, 5, 1, 'diterima', NULL, NULL),
(5, 6, 1, 'diterima', NULL, NULL),
(6, 7, 2, 'diterima', NULL, NULL),
(7, 8, 2, 'diterima', NULL, NULL),
(8, 9, 2, 'diterima', NULL, NULL),
(9, 10, 2, 'diterima', NULL, NULL),
(10, 1, 2, 'diterima', NULL, NULL),
(11, 11, 3, 'diterima', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_ekskul`
--

CREATE TABLE `pengajuan_ekskul` (
  `id_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ekskul_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gywWPAsogHG5JmiAUmiXFxpSyxztCareGvMSszvh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib3gyQUx0c2V3ejQ3VzhhTFJ1ZGZBQlhMRkVZeDd3WUVLaXlWcWJWWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1745313771),
('HJKXYqk0ql13o4VtIZy359ZPWIOxFZq8r8uisXhc', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoib0dWMDFZdHI4WTRDNFJJZXc0ZlpTVWRCUkxIQlFuNUs5cmdNODVpZSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Vrc2t1bC9hYnNlbnNpL2Jhc2tldCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1745304249),
('jqYhgkwlGejeDS4ltv4KOWznAVfFgkHyZvngIJLo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRWdLb2VHV2hvSWdsalpTWEJGR0VDWEwyZWhUV0NicEJEV3R5MTZiMiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1745313607);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `id_kelas` bigint(20) UNSIGNED DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `nama`, `id_kelas`, `foto`, `role`, `deleted`) VALUES
(1, '2223607653', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'Admin User', 3, 'pp_akun/qXJHQuPhetIFd1LwZJV5b5QQRVuWuHpqijkO3LPI.jpg', 'admin', 0),
(2, '2223607641', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User One', 1, NULL, 'user', 0),
(3, '2223607083', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Two', 4, NULL, 'user', 0),
(4, '2223607902', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Three', 2, NULL, 'user', 0),
(5, '2223607618', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Four', 5, NULL, 'user', 0),
(6, '2223607106', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Five', 5, NULL, 'user', 0),
(7, '2223607457', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Six', 1, NULL, 'user', 0),
(8, '2223607934', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Seven', 2, NULL, 'user', 0),
(9, '2223607993', '$2y$12$7ueCKGRw1ooWKL.tWgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Eight', 3, NULL, 'user', 0),
(10, '2223607795', '$2y$12$7ueCKGRw1ooWKL.tgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'User Nine', 2, NULL, 'user', 0),
(11, '123456', '$2y$12$7ueCKGRw1ooWKL.tgCm8Ow.1vKkQHItSp7yIX0csnHk3frmkQQme', 'Rizla', 2, NULL, 'user', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_id_ekskul_foreign` (`id_ekskul`),
  ADD KEY `absensi_id_user_foreign` (`id_user`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ekskul`
--
ALTER TABLE `ekskul`
  ADD PRIMARY KEY (`id_ekskul`),
  ADD UNIQUE KEY `ekskul_slug_unique` (`slug`);

--
-- Indexes for table `ekskul_user`
--
ALTER TABLE `ekskul_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ekskul_jabatan` (`ekskul_id`,`jabatan`),
  ADD KEY `ekskul_user_user_id_foreign` (`user_id`),
  ADD KEY `ekskul_user_jabatan_foreign` (`jabatan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gambar_ekskul`
--
ALTER TABLE `gambar_ekskul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gambar_ekskul_ekskul_id_foreign` (`ekskul_id`);

--
-- Indexes for table `hasil_kuis`
--
ALTER TABLE `hasil_kuis`
  ADD PRIMARY KEY (`id_hasil`),
  ADD KEY `hasil_kuis_id_kuis_foreign` (`id_kuis`),
  ADD KEY `hasil_kuis_id_ekskul_foreign` (`id_ekskul`),
  ADD KEY `hasil_kuis_id_user_foreign` (`id_user`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD UNIQUE KEY `jabatan_slug_unique` (`slug`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD KEY `kegiatan_id_ekskul_foreign` (`id_ekskul`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `kuis`
--
ALTER TABLE `kuis`
  ADD PRIMARY KEY (`id_kuis`),
  ADD KEY `kuis_id_ekskul_foreign` (`id_ekskul`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `materi_id_ekskul_foreign` (`id_ekskul`),
  ADD KEY `materi_id_user_foreign` (`id_user`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_id_ekskul_foreign` (`id_ekskul`);

--
-- Indexes for table `notifikasi_target`
--
ALTER TABLE `notifikasi_target`
  ADD PRIMARY KEY (`id_target`),
  ADD KEY `notifikasi_target_id_notifikasi_foreign` (`id_notifikasi`),
  ADD KEY `notifikasi_target_id_user_foreign` (`id_user`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD KEY `pendaftaran_id_ekskul_foreign` (`id_ekskul`),
  ADD KEY `pendaftaran_id_user_foreign` (`id_user`);

--
-- Indexes for table `pengajuan_ekskul`
--
ALTER TABLE `pengajuan_ekskul`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD KEY `pengajuan_ekskul_user_id_foreign` (`user_id`),
  ADD KEY `pengajuan_ekskul_ekskul_id_foreign` (`ekskul_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_nama_unique` (`nama`),
  ADD KEY `users_id_kelas_foreign` (`id_kelas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ekskul`
--
ALTER TABLE `ekskul`
  MODIFY `id_ekskul` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ekskul_user`
--
ALTER TABLE `ekskul_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambar_ekskul`
--
ALTER TABLE `gambar_ekskul`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_kuis`
--
ALTER TABLE `hasil_kuis`
  MODIFY `id_hasil` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kuis`
--
ALTER TABLE `kuis`
  MODIFY `id_kuis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifikasi_target`
--
ALTER TABLE `notifikasi_target`
  MODIFY `id_target` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengajuan_ekskul`
--
ALTER TABLE `pengajuan_ekskul`
  MODIFY `id_pengajuan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `ekskul_user`
--
ALTER TABLE `ekskul_user`
  ADD CONSTRAINT `ekskul_user_ekskul_id_foreign` FOREIGN KEY (`ekskul_id`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE,
  ADD CONSTRAINT `ekskul_user_jabatan_foreign` FOREIGN KEY (`jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON DELETE CASCADE,
  ADD CONSTRAINT `ekskul_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `gambar_ekskul`
--
ALTER TABLE `gambar_ekskul`
  ADD CONSTRAINT `gambar_ekskul_ekskul_id_foreign` FOREIGN KEY (`ekskul_id`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_kuis`
--
ALTER TABLE `hasil_kuis`
  ADD CONSTRAINT `hasil_kuis_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`),
  ADD CONSTRAINT `hasil_kuis_id_kuis_foreign` FOREIGN KEY (`id_kuis`) REFERENCES `kuis` (`id_kuis`),
  ADD CONSTRAINT `hasil_kuis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE;

--
-- Constraints for table `kuis`
--
ALTER TABLE `kuis`
  ADD CONSTRAINT `kuis_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`);

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `materi_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE,
  ADD CONSTRAINT `materi_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`);

--
-- Constraints for table `notifikasi_target`
--
ALTER TABLE `notifikasi_target`
  ADD CONSTRAINT `notifikasi_target_id_notifikasi_foreign` FOREIGN KEY (`id_notifikasi`) REFERENCES `notifikasi` (`id_notifikasi`),
  ADD CONSTRAINT `notifikasi_target_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_id_ekskul_foreign` FOREIGN KEY (`id_ekskul`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pengajuan_ekskul`
--
ALTER TABLE `pengajuan_ekskul`
  ADD CONSTRAINT `pengajuan_ekskul_ekskul_id_foreign` FOREIGN KEY (`ekskul_id`) REFERENCES `ekskul` (`id_ekskul`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_ekskul_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_id_kelas_foreign` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
