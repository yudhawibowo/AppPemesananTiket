-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Feb 2023 pada 13.56
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_app_pemesanan_tiket`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nomor` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `nama`, `jenis`, `nomor`, `created_at`, `updated_at`) VALUES
(2, 'Mersedes', 'Sedan', 'BK 123 KB', '2023-02-09 17:08:56', '2023-02-11 02:29:57'),
(3, 'Kijang', 'Box', 'B 555 TL', '2023-02-11 02:30:16', '2023-02-11 02:30:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `metode_bayar` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `total_qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `qr_code` text NOT NULL,
  `bukti` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemesanan`
--

INSERT INTO `pemesanan` (`id`, `id_user`, `metode_bayar`, `status`, `total_qty`, `total_harga`, `qr_code`, `bukti`, `created_at`, `updated_at`) VALUES
(10, 51, 'BRI - 7643-5973-4823-43', 1, 9, 231000, '20230213103805.png', '1020230213103823.jpg', '2023-02-13 22:38:05', '2023-02-13 22:39:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemesanan_detail`
--

CREATE TABLE `pemesanan_detail` (
  `id` int(11) NOT NULL,
  `id_pemesanan` bigint(1) UNSIGNED NOT NULL,
  `id_tiket` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemesanan_detail`
--

INSERT INTO `pemesanan_detail` (`id`, `id_pemesanan`, `id_tiket`, `qty`, `created_at`, `updated_at`) VALUES
(8, 10, 1, 6, '2023-02-13 22:38:05', '2023-02-13 22:38:05'),
(9, 10, 2, 3, '2023-02-13 22:38:05', '2023-02-13 22:38:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `role`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', '2022-12-06 10:37:09', '0000-00-00 00:00:00'),
(2, 2, 'User', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tiket`
--

CREATE TABLE `tiket` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tiket`
--

INSERT INTO `tiket` (`id`, `kode`, `jenis`, `harga`, `created_at`, `updated_at`) VALUES
(1, 'TIKET MASUK', 'TIKET MASUK', 6000, '2023-02-13 19:39:19', '2023-02-13 22:35:51'),
(2, 'TIKSDA-BUS', 'BUS', 65000, '2023-02-09 23:53:05', '2023-02-09 23:53:05'),
(3, 'TKES-MOBSD', 'Pribadi', 45000, '2023-02-11 02:30:56', '2023-02-11 02:30:56'),
(4, 'TRUK-TRS', 'TRUK', 125000, '2023-02-11 02:31:11', '2023-02-11 02:31:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.png',
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `nomor_hp`, `password`, `photo`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '0812345123', '$2y$10$kDCnttm7daKfqrMRUybSSeJQNOTxBcMoTMkeP83pQLaeN4jeAuNjO', 'admin.png', 1, 'VsqlG74BdWqdrzKlXPHcycFrO1gC9Cipf7HQ2xjoocPWiImOtd94Y9XM898P', NULL, '2023-02-09 05:12:36'),
(51, 'evan', 'evan@gmail.com', '0823542345345', '$2y$10$N0Uc31r8uxodnqijfBvdhO4Y0vDkwev3XhzXuiTncD55U1FqW3aS2', 'default.png', 2, NULL, '2023-02-13 15:36:46', '2023-02-13 15:36:46'),
(52, 'rita', 'rita@gmail.com', '0823423423', '$2y$10$rbifbaRL4D18EFG9srCP/OfDTK88X25n10krByFBFtMNpf35HkV52', '20230213104315.jpg', 2, NULL, '2023-02-13 15:43:15', '2023-02-13 15:43:15');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pemesanan_detail`
--
ALTER TABLE `pemesanan_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tiket`
--
ALTER TABLE `tiket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pemesanan_detail`
--
ALTER TABLE `pemesanan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tiket`
--
ALTER TABLE `tiket`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pemesanan_detail`
--
ALTER TABLE `pemesanan_detail`
  ADD CONSTRAINT `pemesanan_detail_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
