<?php 
include 'header.php'; 

// Sinkronisasi Data Dashboard via view v_dashboard_harian yang baru
$dash_query = mysqli_query($koneksi, "SELECT * FROM v_dashboard_harian");
$dash_data  = mysqli_fetch_assoc($dash_query);

// Hitung total pelanggan terdaftar secara live
$total_plg = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_pelanggan FROM pelanggan"));

// Hitung transaksi yang BENAR-BENAR masih berstatus 'Antrean'
$total_antrean = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_transaksi FROM transaksi WHERE status='Antrean'"));
?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 border-0 shadow-sm">
            <h6>Orderan Hari Ini</h6>
            <h2 class="fw-bold"><?= isset($dash_data['total_order']) ? $dash_data['total_order'] : 0; ?></h2>
            <small>Transaksi masuk hari ini</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 border-0 shadow-sm">
            <h6>Pendapatan Hari Ini</h6>
            <h2 class="fw-bold">Rp <?= number_format(isset($dash_data['total_pendapatan']) ? $dash_data['total_pendapatan'] : 0, 0, ',', '.'); ?></h2>
            <small>Berdasarkan realisasi kasir</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3 border-0 shadow-sm">
            <h6>Antrean Cucian</h6>
            <h2 class="fw-bold"><?= $total_antrean; ?></h2>
            <small>Menunggu diproses</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white p-3 border-0 shadow-sm">
            <h6>Total Pelanggan</h6>
            <h2 class="fw-bold"><?= $total_plg; ?></h2>
            <small>Terdaftar di database</small>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-4 mb-4">
    <h4>Selamat Datang di Aplikasi LaundryKu 🧺</h4>
    <p class="text-muted m-0">Gunakan menu di samping kiri untuk mengelola data operasional laundry dengan cepat, mudah, dan real-time.</p>
</div>

<?php include 'footer.php'; ?>