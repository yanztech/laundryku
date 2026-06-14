<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem LaundryKu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar { background: #2c3e50; min-height: 100vh; color: white; }
        .sidebar .nav-link { color: #a9b7c6; font-weight: 500; padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #1a252f; color: #fff; }
        .navbar-custom { background-color: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-0 position-fixed">
            <div class="p-3 text-center border-bottom border-secondary">
                <h4 class="m-0 text-white fw-bold"><i class="fa-solid fa-shirt"></i> LaundryKu</h4>
                <small class="text-warning">[<?= $_SESSION['level']; ?>]</small>
            </div>
            <div class="pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fa-solid fa-gauge me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pelanggan.php"><i class="fa-solid fa-users me-2"></i> Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="paket.php"><i class="fa-solid fa-box me-2"></i> Paket Laundry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="transaksi.php"><i class="fa-solid fa-file-invoice-dollar me-2"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pembayaran.php"><i class="fa-solid fa-cash-register me-2"></i> Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="laporan.php"><i class="fa-solid fa-chart-line me-2"></i> Laporan</a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="logout.php" onclick="return confirm('Yakin ingin keluar?')"><i class="fa-solid fa-right-from-bracket me-2"></i> Keluar</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3" style="margin-left: 16.666667%;">
            <div class="navbar-custom p-3 rounded d-flex justify-content-between align-items-center mb-4">
                <span class="fw-bold text-secondary">Sistem Informasi Manajemen Laundry</span>
                <span class="text-dark"><i class="fa-solid fa-user-circle me-1"></i> Halo, <strong><?= $_SESSION['nama']; ?></strong></span>
            </div>