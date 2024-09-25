-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Sep 2024 pada 06.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_galeriukk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `admin_telp` varchar(20) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `admin_address` text NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `admin_name`, `username`, `password`, `admin_telp`, `admin_email`, `admin_address`, `reset_token`, `reset_token_expiration`) VALUES
(12, 'XII RPL 1', 'admin', '$2y$10$2y/x.EJ0tbLkQfbCrAHgmeQMQ5t6DKvBP8F1JjFHMc4LNC1nfySn.', '034193913', 'okesiap@gmail.com', 'Jl. Priksan1', NULL, NULL),
(13, 'Rpl', 'rpl', '$2y$10$0bEYNVgSgK4BNGhFv1zOkub1Vw9jJFELChjZmpbFxG1TuAzUm6aEC', '31321', 'adadak@gmail.com', 'DADAD', NULL, NULL),
(14, 'Zaky', 'Zaky', '$2y$10$Jnkdm1fdp6VEPbAgv9JmpuAim8XzdRiA1K5fCy/Tvm67KshcClzMi', '', 'admin@gmail.com', 'Jl', NULL, NULL),
(15, 'Zaky', 'aku', '$2y$10$MzdR/e6Rsn1RJyyfhjoC4.iadyJU69YGFjJo99dq9DBHz7qGYGWN6', '', 'sada@gmail.com', 'Dada', NULL, NULL),
(16, 'Zaky', 'zaky', '$2y$10$UJ8myAOrHLZXgoiomjapIulAYbf8.lAHdIvX8vgueMcsjhmRh0yOK', '', 'dada@gmail.com', 'Dada', NULL, NULL),
(17, 'Zaky', 'zaky', '$2y$10$l7e0XhxI5Sv7Yfv/9U5WkOl1PaS2S1o06vT4tpoxoouU2Cy.VUraS', '', 'dad@gmail.com', 'Dad', NULL, NULL),
(18, 'Zaky', 'aku', '$2y$10$LjipPKTa8VHsFSPLjOuSSOHTXNX9UE/OOkj1GrFkIlcAR3FYGOPOe', '', 'dada@gmail.com', 'Asdas', NULL, NULL),
(19, 'Zaky', 'hebat', '$2y$10$miPpqcIXC8CF8sOtFwEWEOZ7nKuFtnfa39OyYL4hIWuDlWipmsosK', '08391931931', 'dada@gmail.comd', 'Ada', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_album`
--

CREATE TABLE `tb_album` (
  `album_id` int(11) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_album`
--

INSERT INTO `tb_album` (`album_id`, `album_name`, `admin_id`, `date_created`) VALUES
(10, 'Zaky', 13, '2024-09-25 02:32:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(1, 'Fashion'),
(2, 'Event'),
(3, 'Olahraga'),
(4, 'Dokumenter'),
(5, 'Semua');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_comments`
--

CREATE TABLE `tb_comments` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_image`
--

CREATE TABLE `tb_image` (
  `image_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `image_description` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `image_status` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `tb_image`
--

INSERT INTO `tb_image` (`image_id`, `category_id`, `category_name`, `admin_id`, `admin_name`, `image_name`, `image_description`, `image`, `image_status`, `date_created`) VALUES
(59, 1, '', 13, 'Rpl', 'dad', 'asdas', 'foto1727236429.png', 1, '2024-09-25 03:53:49'),
(62, 1, '', 13, 'Rpl', 'dadas', 'dasd', 'foto1727237146.png', 1, '2024-09-25 04:05:46'),
(63, 2, '', 13, 'Rpl', 'dsada', 'da', 'foto1727237163.jpeg', 1, '2024-09-25 04:06:03'),
(64, 4, '', 13, 'Rpl', 'dad', 'adas', 'foto1727237541.jpg', 1, '2024-09-25 04:12:21'),
(65, 2, '', 13, 'Rpl', 'dadasd', 'asda', 'foto1727237550.jpg', 1, '2024-09-25 04:12:30'),
(66, 2, '', 13, 'Rpl', 'dad', 'asdas', 'foto1727237630.jpg', 1, '2024-09-25 04:13:50'),
(67, 2, '', 13, 'Rpl', 'dadsa', 'dsadas', 'foto1727237646.jpeg', 1, '2024-09-25 04:14:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_image_album`
--

CREATE TABLE `tb_image_album` (
  `id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_likes`
--

CREATE TABLE `tb_likes` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `liked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_likes`
--

INSERT INTO `tb_likes` (`id`, `admin_id`, `image_id`, `liked`) VALUES
(34, 13, 59, 1),
(35, 13, 62, 1),
(36, 13, 63, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `tb_album`
--
ALTER TABLE `tb_album`
  ADD PRIMARY KEY (`album_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `tb_comments`
--
ALTER TABLE `tb_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indeks untuk tabel `tb_image`
--
ALTER TABLE `tb_image`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indeks untuk tabel `tb_image_album`
--
ALTER TABLE `tb_image_album`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`),
  ADD KEY `image_id` (`image_id`);

--
-- Indeks untuk tabel `tb_likes`
--
ALTER TABLE `tb_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `image_id` (`image_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_album`
--
ALTER TABLE `tb_album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_comments`
--
ALTER TABLE `tb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `tb_image`
--
ALTER TABLE `tb_image`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT untuk tabel `tb_image_album`
--
ALTER TABLE `tb_image_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `tb_likes`
--
ALTER TABLE `tb_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_album`
--
ALTER TABLE `tb_album`
  ADD CONSTRAINT `tb_album_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`admin_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_comments`
--
ALTER TABLE `tb_comments`
  ADD CONSTRAINT `tb_comments_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`admin_id`),
  ADD CONSTRAINT `tb_comments_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `tb_image` (`image_id`);

--
-- Ketidakleluasaan untuk tabel `tb_image`
--
ALTER TABLE `tb_image`
  ADD CONSTRAINT `tb_image_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`admin_id`),
  ADD CONSTRAINT `tb_image_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`category_id`);

--
-- Ketidakleluasaan untuk tabel `tb_image_album`
--
ALTER TABLE `tb_image_album`
  ADD CONSTRAINT `tb_image_album_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `tb_album` (`album_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_image_album_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `tb_image` (`image_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_likes`
--
ALTER TABLE `tb_likes`
  ADD CONSTRAINT `tb_likes_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `tb_admin` (`admin_id`),
  ADD CONSTRAINT `tb_likes_ibfk_2` FOREIGN KEY (`image_id`) REFERENCES `tb_image` (`image_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
