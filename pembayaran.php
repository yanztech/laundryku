<?php 
include 'header.php'; 

if(isset($_POST['bayar'])){
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $cek_t = mysqli_query($koneksi, "SELECT total_bayar FROM transaksi WHERE id_transaksi='$id_transaksi'");
    $data_t = mysqli_fetch_assoc($cek_t);

    if($jumlah_bayar >= $data_t['total_bayar']){
        mysqli_query($koneksi, "INSERT INTO pembayaran (id_transaksi, metode, jumlah_bayar) VALUES ('$id_transaksi', '$metode', '$jumlah_bayar')");
        echo "<script>alert('Pembayaran Berhasil diproses!'); window.location='pembayaran.php';</script>";
    } else {
        echo "<script>alert('Gagal! Uang pembayaran kurang dari total tagihan.'); window.location='pembayaran.php';</script>";
    }
}
?>

<h3 class="mb-3 text-secondary fw-bold">Kasir & Pembayaran</h3>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm p-3">
            <h5 class="border-bottom pb-2">Proses Pembayaran</h5>
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Pilih Nota Belum Lunas</label>
                    <select name="id_transaksi" class="form-select" required>
                        <?php 
                        $notainv = mysqli_query($koneksi, "SELECT id_transaksi, no_nota, total_bayar FROM transaksi WHERE id_transaksi NOT IN (SELECT id_transaksi FROM pembayaran)");
                        if(mysqli_num_rows($notainv) == 0) echo "<option value=''>-- Semua Nota Sudah Lunas --</option>";
                        while($n = mysqli_fetch_assoc($notainv)):
                        ?>
                        <option value="<?= $n['id_transaksi']; ?>"><?= $n['no_nota']; ?> - (Rp <?= number_format($n['total_bayar'],0,',','.'); ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <select name="metode" class="form-select">
                        <option value="Cash">Cash</option>
                        <option value="Transfer">Transfer</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah Uang Dibayar (Rp)</label>
                    <input type="number" name="jumlah_bayar" class="form-control" required>
                </div>
                <button type="submit" name="bayar" class="btn btn-success w-100">Konfirmasi Pembayaran</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-3">
            <h5 class="border-bottom pb-2">Riwayat Pembayaran Masuk</h5>
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>No Nota</th>
                        <th>Waktu Bayar</th>
                        <th>Metode</th>
                        <th>Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $p_query = mysqli_query($koneksi, "SELECT p.*, t.no_nota FROM pembayaran p JOIN transaksi t ON p.id_transaksi=t.id_transaksi ORDER BY p.id_bayar DESC");
                    while($pr = mysqli_fetch_assoc($p_query)):
                    ?>
                    <tr>
                        <td><code><?= $pr['no_nota']; ?></code></td>
                        <td><?= $pr['tanggal_bayar']; ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $pr['metode']; ?></span></td>
                        <td><strong>Rp <?= number_format($pr['jumlah_bayar'],0,',','.'); ?></strong></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>