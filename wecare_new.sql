-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Nov 2025 pada 15.59
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wecare_new`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokters`
--

CREATE TABLE `dokters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `spesialisasi` varchar(255) DEFAULT NULL,
  `riwayat_pendidikan` text DEFAULT NULL,
  `no_str` varchar(255) DEFAULT NULL,
  `biaya` decimal(10,2) DEFAULT NULL,
  `jadwal` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`jadwal`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pendidikan` varchar(255) DEFAULT NULL,
  `tarif_per_jam` int(11) DEFAULT NULL,
  `jadwal_praktik` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dokters`
--

INSERT INTO `dokters` (`id`, `id_dokter`, `user_id`, `jenis_kelamin`, `spesialisasi`, `riwayat_pendidikan`, `no_str`, `biaya`, `jadwal`, `created_at`, `updated_at`, `pendidikan`, `tarif_per_jam`, `jadwal_praktik`) VALUES
(1, 'D001', 2, 'Laki-laki', 'Dokter Umum', 'S1 FK Universitas Brawijaya', 'STR001', '100000.00', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'D002', 3, 'Perempuan', 'Dokter Gigi', 'S1 FKG Universitas Airlangga', 'STR002', '150000.00', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `jadwal_konsultasis`
--

CREATE TABLE `jadwal_konsultasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` bigint(20) UNSIGNED NOT NULL,
  `jadwal` datetime NOT NULL,
  `status` enum('konfirmasi','cancel','selesai') NOT NULL DEFAULT 'konfirmasi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_konsultasis`
--

INSERT INTO `jadwal_konsultasis` (`id`, `id_dokter`, `id_pasien`, `jadwal`, `status`, `created_at`, `updated_at`) VALUES
(235, 1, 1, '2025-11-10 09:00:00', 'selesai', NULL, NULL),
(236, 1, 2, '2025-11-10 09:00:00', 'selesai', NULL, NULL),
(237, 1, 3, '2025-11-10 09:00:00', 'selesai', NULL, NULL),
(238, 1, 4, '2025-11-10 09:00:00', 'selesai', NULL, NULL),
(239, 1, 5, '2025-11-10 09:00:00', 'selesai', NULL, NULL),
(301, 1, 4, '2025-11-17 09:00:00', 'selesai', NULL, NULL),
(302, 1, 5, '2025-11-17 10:00:00', 'selesai', NULL, NULL),
(303, 1, 6, '2025-11-18 09:30:00', 'selesai', NULL, NULL),
(304, 1, 4, '2025-11-19 08:00:00', 'selesai', NULL, NULL),
(305, 1, 5, '2025-11-19 11:00:00', 'selesai', NULL, NULL),
(306, 1, 6, '2025-11-20 13:00:00', 'selesai', NULL, NULL),
(307, 1, 4, '2025-11-21 14:00:00', 'selesai', NULL, NULL),
(308, 1, 5, '2025-11-22 09:00:00', 'selesai', NULL, NULL),
(309, 1, 6, '2025-11-23 10:00:00', 'selesai', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `komentars`
--

CREATE TABLE `komentars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `komentar` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komentars`
--

INSERT INTO `komentars` (`id`, `id_pasien`, `id_dokter`, `komentar`, `rating`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Dokter sangat ramah dan penjelasannya mudah dipahami. Terima kasih banyak atas pelayanannya!', 5, '2025-11-10 03:30:00', '2025-11-10 03:30:00'),
(2, 2, 1, 'Pelayanan cepat dan dokternya profesional. Sangat memuaskan!', 5, '2025-11-10 07:15:00', '2025-11-10 07:15:00'),
(3, 3, 1, 'Dokter sangat sabar dalam menjelaskan kondisi kesehatan saya. Recommended!', 5, '2025-11-11 02:20:00', '2025-11-11 02:20:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar_balasans`
--

CREATE TABLE `komentar_balasans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_komentar` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `balasan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `komentar_balasans`
--

INSERT INTO `komentar_balasans` (`id`, `id_komentar`, `id_admin`, `balasan`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Terima kasih atas feedback positifnya! Kami akan terus meningkatkan pelayanan untuk Anda.', '2025-11-10 04:00:00', '2025-11-10 04:00:00'),
(2, 3, 1, 'Senang mendengar Anda puas dengan pelayanan kami. Semoga lekas sembuh!', '2025-11-11 03:00:00', '2025-11-11 03:00:00'),
(3, 5, 1, 'Mohon maaf atas ketidaknyamanan waktu tunggu. Kami akan berusaha memperbaiki sistem antrian kami.', '2025-11-11 09:00:00', '2025-11-11 09:00:00'),
(4, 9, 1, 'Terima kasih atas masukannya. Kami akan segera melakukan perbaikan ruang praktek untuk kenyamanan pasien.', '2025-11-13 03:00:00', '2025-11-13 03:00:00'),
(5, 17, 1, 'Terima kasih atas feedbacknya. Kami akan review kembali struktur biaya konsultasi kami.', '2025-11-15 03:00:00', '2025-11-15 03:00:00'),
(6, 24, 3, 'Terima kasih telah mempercayai WeCare sebagai klinik kesehatan anda. Semoga anda puas dengan pelayanan kami. Semoga cepat sembuh. Salam sehat', '2025-11-15 22:10:54', '2025-11-15 22:10:54'),
(7, 2, 3, 'Terima kasih telah mempercayai We Care sebagai klinik tujuan Anda. Semoga lekas sembuh', '2025-11-22 21:17:15', '2025-11-22 21:17:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_18_031450_create_dokters_table', 1),
(5, '2025_11_18_031501_create_pasiens_table', 1),
(6, '2025_11_18_032630_create_jadwal_konsultasis_table', 1),
(7, '2025_11_18_032637_create_komentars_table', 1),
(8, '2025_11_18_034001_create_komentar_balasans_table', 1),
(9, '2025_11_18_034008_create_pembayarans_table', 1),
(10, '2025_11_18_034610_create_riwayats_table', 1),
(11, '2025_11_18_034616_create_reseps_table', 1),
(12, '2025_11_18_034622_create_transaksis_table', 1),
(13, '2025_11_18_034627_create_notifikasis_table', 1),
(14, '2025_11_18_113755_add_profile_details_to_users_table', 1),
(15, '2025_11_18_175528_add_foreign_key_to_pasiens_table', 1),
(16, '2025_11_19_000827_update_dokters_profile_fields', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `recipient_user_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, '🔔 Ada 5 komentar baru dari pasien yang perlu ditanggapi', 0, '2025-11-15 22:36:38', '2025-11-15 22:36:38'),
(2, 1, '💰 Pemasukan hari ini mencapai Rp 1.500.000', 0, '2025-11-15 20:36:38', '2025-11-15 20:36:38'),
(3, 1, '📅 Ada 3 jadwal konsultasi baru untuk besok', 0, '2025-11-15 18:36:38', '2025-11-15 18:36:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasiens`
--

CREATE TABLE `pasiens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pasien` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pasiens`
--

INSERT INTO `pasiens` (`id`, `id_pasien`, `user_id`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `created_at`, `updated_at`) VALUES
(1, 'P001', 4, '2019-05-12', 'Laki-laki', 'Jl. Contoh No. 45, Malang', NULL, NULL),
(2, 'P002', 5, '2001-01-26', 'Laki-laki', 'Jl. Contoh No. 31, Malang', NULL, NULL),
(3, 'P003', 6, '2016-05-17', 'Laki-laki', 'Jl. Contoh No. 17, Malang', NULL, NULL),
(4, 'P004', 4, '1999-01-01', 'Laki-laki', 'Malang', NULL, NULL),
(5, 'P005', 5, '2000-02-02', 'Perempuan', 'Surabaya', NULL, NULL),
(6, 'P006', 3, '1998-03-03', 'Laki-laki', 'Kediri', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_konsultasi` bigint(20) UNSIGNED NOT NULL,
  `id_dokter` bigint(20) UNSIGNED NOT NULL,
  `nominal` decimal(10,2) DEFAULT NULL,
  `metode` enum('transfer','cash','ewallet') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `id_jadwal_konsultasi`, `id_dokter`, `nominal`, `metode`, `created_at`, `updated_at`) VALUES
(1, 235, 1, '100000.00', 'cash', NULL, NULL),
(2, 236, 1, '100000.00', 'transfer', NULL, NULL),
(3, 237, 1, '100000.00', 'ewallet', NULL, NULL),
(4, 238, 1, '100000.00', 'ewallet', NULL, NULL),
(5, 239, 1, '100000.00', 'transfer', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `reseps`
--

CREATE TABLE `reseps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_riwayat` bigint(20) UNSIGNED NOT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `dosis` varchar(255) DEFAULT NULL,
  `instruksi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `reseps`
--

INSERT INTO `reseps` (`id`, `id_riwayat`, `nama_obat`, `dosis`, `instruksi`, `created_at`, `updated_at`) VALUES
(1, 1, 'Amlodipine', '5mg', 'Diminum 1 tablet setiap pagi setelah sarapan', '2025-11-10 03:30:00', '2025-11-10 03:30:00'),
(2, 1, 'Captopril', '25mg', 'Diminum 2x sehari (pagi dan sore) sebelum makan', '2025-11-10 03:30:00', '2025-11-10 03:30:00'),
(3, 2, 'Metformin', '500mg', 'Diminum 2 tablet sehari setelah makan (pagi dan malam)', '2025-11-10 04:00:00', '2025-11-10 04:00:00'),
(4, 2, 'Glimepiride', '1mg', 'Diminum 1 tablet setiap pagi sebelum sarapan', '2025-11-10 04:00:00', '2025-11-10 04:00:00'),
(5, 3, 'Amoxicillin', '500mg', 'Diminum 3x sehari selama 5 hari sampai habis', '2025-11-10 07:15:00', '2025-11-10 07:15:00'),
(6, 3, 'Paracetamol', '500mg', 'Diminum bila demam, maksimal 3x sehari', '2025-11-10 07:15:00', '2025-11-10 07:15:00'),
(7, 3, 'OBH Sirup', '15ml', 'Diminum 3x sehari 1 sendok makan bila batuk', '2025-11-10 07:15:00', '2025-11-10 07:15:00'),
(8, 4, 'Omeprazole', '20mg', 'Diminum 2x sehari sebelum makan (pagi dan malam)', '2025-11-10 08:45:00', '2025-11-10 08:45:00'),
(9, 4, 'Antasida Sirup', '15ml', 'Diminum 3x sehari setelah makan, 1 sendok makan', '2025-11-10 08:45:00', '2025-11-10 08:45:00'),
(10, 4, 'Sucralfat Syrup', '10ml', 'Diminum 3x sehari sebelum makan', '2025-11-10 08:45:00', '2025-11-10 08:45:00'),
(11, 5, 'Paracetamol', '500mg', 'Diminum bila sakit kepala muncul, max 3x/hari', '2025-11-10 09:20:00', '2025-11-10 09:20:00'),
(12, 5, 'Flunarizine', '5mg', 'Diminum 1 tablet setiap malam sebagai pencegahan', '2025-11-10 09:20:00', '2025-11-10 09:20:00'),
(13, 6, 'Amlodipine', '10mg', 'Diminum 1 tablet setiap pagi setelah sarapan', '2025-11-17 03:00:00', '2025-11-17 03:00:00'),
(14, 6, 'Simvastatin', '20mg', 'Diminum 1 tablet setiap malam sebelum tidur', '2025-11-17 03:00:00', '2025-11-17 03:00:00'),
(15, 6, 'Vitamin B Complex', '1 tablet', 'Diminum 1x sehari setelah sarapan', '2025-11-17 03:00:00', '2025-11-17 03:00:00'),
(16, 7, 'Salbutamol Inhaler', '2 puff', 'Hirup 2x bila sesak napas, tunggu 5 menit antar puff', '2025-11-17 04:30:00', '2025-11-17 04:30:00'),
(17, 7, 'Methylprednisolone', '4mg', 'Diminum 3x sehari selama 3 hari', '2025-11-17 04:30:00', '2025-11-17 04:30:00'),
(18, 7, 'Ambroxol', '30mg', 'Diminum 3x sehari setelah makan untuk mengencerkan dahak', '2025-11-17 04:30:00', '2025-11-17 04:30:00'),
(19, 8, 'Hydrocortisone Cream 1%', 'Oles tipis', 'Oleskan 2x sehari pada area kulit yang gatal', '2025-11-18 03:45:00', '2025-11-18 03:45:00'),
(20, 8, 'Cetirizine', '10mg', 'Diminum 1 tablet setiap malam sebelum tidur', '2025-11-18 03:45:00', '2025-11-18 03:45:00'),
(21, 8, 'Calamine Lotion', 'Oles tipis', 'Oleskan 3x sehari untuk mengurangi gatal', '2025-11-18 03:45:00', '2025-11-18 03:45:00'),
(22, 9, 'Betahistine', '8mg', 'Diminum 3x sehari setelah makan', '2025-11-19 02:15:00', '2025-11-19 02:15:00'),
(23, 9, 'Dimenhydrinate', '50mg', 'Diminum bila pusing, maksimal 3x sehari', '2025-11-19 02:15:00', '2025-11-19 02:15:00'),
(24, 9, 'Vitamin B6', '10mg', 'Diminum 2x sehari untuk pemulihan saraf', '2025-11-19 02:15:00', '2025-11-19 02:15:00'),
(25, 10, 'Lansoprazole', '30mg', 'Diminum 1x sehari sebelum sarapan', '2025-11-19 05:00:00', '2025-11-19 05:00:00'),
(26, 10, 'Domperidone', '10mg', 'Diminum 3x sehari 30 menit sebelum makan', '2025-11-19 05:00:00', '2025-11-19 05:00:00'),
(27, 10, 'Probiotik (Lactobacillus)', '1 sachet', 'Diminum 1x sehari untuk kesehatan pencernaan', '2025-11-19 05:00:00', '2025-11-19 05:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayats`
--

CREATE TABLE `riwayats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal_konsultasi` bigint(20) UNSIGNED NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `resep` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `riwayats`
--

INSERT INTO `riwayats` (`id`, `id_jadwal_konsultasi`, `diagnosis`, `resep`, `created_at`, `updated_at`) VALUES
(1, 235, 'Hipertensi Grade 1 (Tekanan Darah 140/90 mmHg)', 'Amlodipine 5mg - 1x1 sehari setelah makan pagi, Captopril 25mg - 2x1 sehari (pagi dan sore)', '2025-11-10 03:30:00', '2025-11-10 03:30:00'),
(2, 236, 'Diabetes Mellitus Tipe 2 (Gula Darah Puasa 180 mg/dL)', 'Metformin 500mg - 2x1 tablet setelah makan, Glimepiride 1mg - 1x1 pagi hari', '2025-11-10 04:00:00', '2025-11-10 04:00:00'),
(3, 237, 'ISPA (Infeksi Saluran Pernapasan Atas) + Demam', 'Amoxicillin 500mg - 3x1 kapsul selama 5 hari, Paracetamol 500mg - 3x1 bila demam', '2025-11-10 07:15:00', '2025-11-10 07:15:00'),
(4, 238, 'Gastritis Akut (Maag)', 'Omeprazole 20mg - 2x1 sebelum makan (pagi dan malam), Antasida Sirup - 3x1 sendok makan sesudah makan', '2025-11-10 08:45:00', '2025-11-10 08:45:00'),
(5, 239, 'Migrain dengan Aura', 'Paracetamol 500mg - 3x1 bila sakit kepala, Flunarizine 5mg - 1x1 malam hari (pencegahan)', '2025-11-10 09:20:00', '2025-11-10 09:20:00'),
(6, 301, 'Hipertensi + Kolesterol Tinggi', 'Amlodipine 10mg - 1x1 pagi, Simvastatin 20mg - 1x1 malam sebelum tidur', '2025-11-17 03:00:00', '2025-11-17 03:00:00'),
(7, 302, 'Asma Bronkial (Eksaserbasi Ringan)', 'Salbutamol Inhaler - 2 puff bila sesak, Methylprednisolone 4mg - 3x1 tablet selama 3 hari', '2025-11-17 04:30:00', '2025-11-17 04:30:00'),
(8, 303, 'Dermatitis Atopik (Eksim)', 'Hydrocortisone Cream 1% - oles 2x sehari di area kulit yang gatal, Cetirizine 10mg - 1x1 malam hari', '2025-11-18 03:45:00', '2025-11-18 03:45:00'),
(9, 304, 'Vertigo Perifer (BPPV)', 'Betahistine 8mg - 3x1 tablet, Dimenhydrinate 50mg - 3x1 bila pusing', '2025-11-19 02:15:00', '2025-11-19 02:15:00'),
(10, 305, 'Dispepsia (Gangguan Pencernaan)', 'Lansoprazole 30mg - 1x1 sebelum sarapan, Domperidone 10mg - 3x1 sebelum makan', '2025-11-19 05:00:00', '2025-11-19 05:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('hSMThYU5n5Aia8UeZ59njTfdOoiPVg1xRLRQizVa', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoic0owT2tYNFdlRW9kQnZrNlNIaE44YXFGTng5U3BORFlSQVJhQXRMbCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM4OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vbm90aWZpa2FzaSI7czo1OiJyb3V0ZSI7czoyMToiYWRtaW4ubm90aWZpa2FzaS5saXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1763996354);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` enum('masuk','keluar') DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `nominal` decimal(12,2) DEFAULT NULL,
  `bank_tujuan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id`, `tanggal`, `jenis`, `keterangan`, `nominal`, `bank_tujuan`, `created_at`, `updated_at`) VALUES
(3, '2025-11-15 22:00:00', 'keluar', 'Pembelian Obat', '2000000.00', 'BRI', '2025-11-15 15:00:00', '2025-11-15 15:00:00'),
(38, '2025-11-01 14:00:00', 'keluar', 'Pembelian Obat-obatan', '2000000.00', 'BRI', '2025-11-01 07:00:00', '2025-11-01 07:00:00'),
(39, '2025-11-02 10:30:00', 'keluar', 'Bayar Listrik Klinik', '850000.00', 'BCA', '2025-11-02 03:30:00', '2025-11-02 03:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','dokter','pasien') NOT NULL,
  `no_telp` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `no_telp`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `created_at`, `updated_at`, `birth_date`, `gender`, `address`, `phone_number`) VALUES
(1, 'james', 'namanyajames@gmail.com', '$2y$12$N1vEuBcBzoEDtPcYPM.Q5.rDAN8k.ZV3IoXxuzjIYLkauIB9Tkai2', 'admin', '08155628275', '2000-11-10', 'Laki-laki', 'Jln Idjen, no 123, Kec Klojen Kota Malang', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Dr. Budi Santoso', 'budi@wecare.com', '$2y$12$rAr3Lkwmt1vzgX0UYwdneelW54jMdMsZmEElSahudYVjwcXXwiBTK', 'dokter', '081234567890', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'James', 'adminwecare@gmail.com', '$2y$12$RCFj.XL9/J5hotB/7LZlseA9/yhtUhUeJP5ZRcFfyUBFknnS8TJhq', 'admin', '082345678901', '2004-09-28', 'Laki-laki', 'Jl Bali No 99B Malang', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Pasien 1', 'pasien1@gmail.com', '$2y$12$PdjerKmMcypIWHgcwpJPNObNuFDftmuWTlIL8Xz9hj6H17KSepObG', 'pasien', '08111111111', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Pasien 2', 'pasien2@gmail.com', '$2y$12$vUfB7XnMhd9h/VLJxe3IDORJg/o8pbJ3s5OuGExuCubK./UTEfvb6', 'pasien', '08111111112', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `dokters`
--
ALTER TABLE `dokters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dokters_id_dokter_unique` (`id_dokter`),
  ADD KEY `dokters_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jadwal_konsultasis`
--
ALTER TABLE `jadwal_konsultasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_konsultasis_id_dokter_foreign` (`id_dokter`),
  ADD KEY `jadwal_konsultasis_id_pasien_foreign` (`id_pasien`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `komentars`
--
ALTER TABLE `komentars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentars_id_pasien_foreign` (`id_pasien`),
  ADD KEY `komentars_id_dokter_foreign` (`id_dokter`);

--
-- Indeks untuk tabel `komentar_balasans`
--
ALTER TABLE `komentar_balasans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `komentar_balasans_id_komentar_foreign` (`id_komentar`),
  ADD KEY `komentar_balasans_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_recipient_user_id_foreign` (`recipient_user_id`);

--
-- Indeks untuk tabel `pasiens`
--
ALTER TABLE `pasiens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pasiens_id_pasien_unique` (`id_pasien`),
  ADD KEY `pasiens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_id_jadwal_konsultasi_foreign` (`id_jadwal_konsultasi`),
  ADD KEY `pembayarans_id_dokter_foreign` (`id_dokter`);

--
-- Indeks untuk tabel `reseps`
--
ALTER TABLE `reseps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reseps_id_riwayat_foreign` (`id_riwayat`);

--
-- Indeks untuk tabel `riwayats`
--
ALTER TABLE `riwayats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayats_id_jadwal_konsultasi_foreign` (`id_jadwal_konsultasi`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokters`
--
ALTER TABLE `dokters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_konsultasis`
--
ALTER TABLE `jadwal_konsultasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `komentars`
--
ALTER TABLE `komentars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `komentar_balasans`
--
ALTER TABLE `komentar_balasans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pasiens`
--
ALTER TABLE `pasiens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `reseps`
--
ALTER TABLE `reseps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `riwayats`
--
ALTER TABLE `riwayats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokters`
--
ALTER TABLE `dokters`
  ADD CONSTRAINT `dokters_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_konsultasis`
--
ALTER TABLE `jadwal_konsultasis`
  ADD CONSTRAINT `jadwal_konsultasis_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jadwal_konsultasis_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasiens` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentars`
--
ALTER TABLE `komentars`
  ADD CONSTRAINT `komentars_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentars_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `pasiens` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `komentar_balasans`
--
ALTER TABLE `komentar_balasans`
  ADD CONSTRAINT `komentar_balasans_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_balasans_id_komentar_foreign` FOREIGN KEY (`id_komentar`) REFERENCES `komentars` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_recipient_user_id_foreign` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pasiens`
--
ALTER TABLE `pasiens`
  ADD CONSTRAINT `pasiens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `dokters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayarans_id_jadwal_konsultasi_foreign` FOREIGN KEY (`id_jadwal_konsultasi`) REFERENCES `jadwal_konsultasis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reseps`
--
ALTER TABLE `reseps`
  ADD CONSTRAINT `reseps_id_riwayat_foreign` FOREIGN KEY (`id_riwayat`) REFERENCES `riwayats` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `riwayats`
--
ALTER TABLE `riwayats`
  ADD CONSTRAINT `riwayats_id_jadwal_konsultasi_foreign` FOREIGN KEY (`id_jadwal_konsultasi`) REFERENCES `jadwal_konsultasis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
