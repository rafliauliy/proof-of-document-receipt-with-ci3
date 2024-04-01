-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Mar 2024 pada 09.41
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_barang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_vendor` char(7) NOT NULL,
  `nama_vendor` varchar(255) NOT NULL,
  `no_invoice` varchar(50) NOT NULL,
  `nilai_invoice` varchar(50) NOT NULL,
  `tgl_invoice` varchar(50) NOT NULL,
  `no_spk` varchar(50) NOT NULL,
  `no_lhp` varchar(50) NOT NULL,
  `no_faktur_pajak` varchar(50) NOT NULL,
  `tgl_faktur_pajak` varchar(50) NOT NULL,
  `tgl_diterima` varchar(50) NOT NULL,
  `keterangan_invoice` varchar(50) NOT NULL,
  `pdf_invoice` varchar(255) NOT NULL,
  `pdf_faktur_pajak` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `catatan` varchar(50) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_vendor`, `nama_vendor`, `no_invoice`, `nilai_invoice`, `tgl_invoice`, `no_spk`, `no_lhp`, `no_faktur_pajak`, `tgl_faktur_pajak`, `tgl_diterima`, `keterangan_invoice`, `pdf_invoice`, `pdf_faktur_pajak`, `status`, `catatan`, `id_user`) VALUES
('00001', 'PT.Krakatau Jasa Logistics', '891', 'Rp.2000.000', '2024-03-20', '8912', '88', '868.261-62.61212221', '2024-03-20', '2024-03-20', 'Barang', 'SURAT_IJIN_KELUAR_MASUK_PERANGKAT_IT_PT_KAL_(1).pdf', 'Mahasiswa.pdf', 'pending', 'OK', 29),
('00002', 'PT Krakatau Jasa Logistics', '221', 'Rp.12.0000', '2024-03-08', '31', '212', '', '2024-03-08', '2024-03-21', 'OK', 'BTTD_Online_KAL_BTTD_Online_(3).pdf', 'SURAT_IJIN_KELUAR_MASUK_PERANGKAT_IT_PT_KAL_(1)1.pdf', 'complete', 'OK', 33),
('00003', 'PT. Jasa Raharja', '32', '431', '2024-03-19', '43', '23', '431.310-99.21821212', '2024-03-22', '2024-03-22', 'Coil', 'SURAT_IJIN_KELUAR_MASUK_PERANGKAT_IT_PT_KAL_(1)3.pdf', 'BTTD_Online_KAL_BTTD_Online_(3)2.pdf', 'complete', 'OK', 34);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `no_wa` varchar(50) NOT NULL,
  `role` enum('vendor','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `foto` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_perusahaan`, `nama`, `alamat`, `username`, `email`, `no_telp`, `no_wa`, `role`, `password`, `created_at`, `foto`, `is_active`) VALUES
(1, 'PT Krakatau Argo Logistics', 'Muhamad Rafli Auliya', 'Cilegon', 'rafli', 'rafliauliya1@gmail.com', '081808685989', '0818099721211', 'admin', '$2y$10$eUxKL7T.faviiux1cXxwne1DPlL1R4ky0ZTITgQmEIddCn/m0kOru', 1705391070, '846029fb9a96ff6c09b8bfb92b19060f.jpg', 1),
(29, 'PT Krakatau Argo Logistics', 'gawang setyawan', 'Cilegon', 'gawang', 'gawang@gmail.com', '081902123121', '0891221312122', 'vendor', '$2y$10$CeEBq.yi09iKBZhvsWVnYeXbXPs5civAh0pdXn1eVwGHj9Jyw0I4C', 1707463656, '0399106e0985254fba2edc78f7efe54f.jpg', 1),
(33, 'PT Krakatau Jasa Logistics', 'faisal', 'Anyer', 'krakatau', 'argologistics@gmail.com', '0812312123', '0818099721211', 'vendor', '$2y$10$Tj6.PGR.0Hx2tcvBLIx0Vux/aJoEAKCXoUpR2MkMhiFAScFxaOAU2', 1710988568, '35ba93950ee48141f31e8d429a33fb90.jpg', 1),
(34, '', 'Andre', '', 'andre', 'andre@gmail.com', '083129219212121', '', 'vendor', '$2y$10$3Ev6.aAMF6FCireZfncRSev2TgAsUzMnPnx6ItnfoWZKw9QUaV95e', 1711077655, 'user.png', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_vendor`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
