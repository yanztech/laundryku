<?php 
include 'header.php'; 

if(isset($_POST['tambah_transaksi'])){
    $no_nota = "INV-" . time();
    $id_pelanggan = $_POST['id_pelanggan'];
    
    list($id_paket, $tarif) = explode('|', $_POST['id_paket_tarif']);
    
    $qty = $_POST['qty'];
    $total_bayar = $qty * $tarif;
    $tgl_masuk = $_POST['tanggal_masuk'];
    $tgl_keluar = $_POST['tanggal_keluar'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $status = 'Antrean';

    $sql = "INSERT INTO transaksi (no_nota, id_pelanggan, id_paket, qty, harga_satuan, total_bayar, tanggal_masuk, tanggal_keluar, keterangan, status) 
            VALUES ('$no_nota', '$id_pelanggan', '$id_paket', '$qty', '$tarif', '$total_bayar', '$tgl_masuk', '$tgl_keluar', '$keterangan', '$status')";
    
    if(mysqli_query($koneksi, $sql)){
        echo "<script>window.location='transaksi.php';</script>";
    }
}

if(isset($_POST['update_status'])){
    $id_t = $_POST['id_transaksi'];
    $status_baru = $_POST['status'];
    mysqli_query($koneksi, "UPDATE transaksi SET status='$status_baru' WHERE id_transaksi='$id_t'");
    echo "<script>window.location='transaksi.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0 text-secondary fw-bold">Transaksi Laundry</h3>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTransaksi"><i class="fa fa-plus"></i> Buat Transaksi Baru</button>
</div>

<div class="card border-0 shadow-sm p-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No Nota</th>
                <th>Pelanggan</th>
                <th>Masuk / Keluar</th>
                <th>Total Tagihan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = mysqli_query($koneksi, "SELECT t.*, p.nama as pelanggan FROM transaksi t JOIN pelanggan p ON t.id_pelanggan=p.id_pelanggan ORDER BY t.id_transaksi DESC");
            while($r = mysqli_fetch_assoc($query)):
                $badge_color = 'secondary';
                if($r['status']=='Proses') $badge_color = 'warning';
                if($r['status']=='Selesai') $badge_color = 'info';
                if($r['status']=='Diambil') $badge_color = 'success';
            ?>
            <tr>
                <td><code><?= $r['no_nota']; ?></code></td>
                <td><strong><?= $r['pelanggan']; ?></strong></td>
                <td><small><?= $r['tanggal_masuk']; ?> s/d <?= $r['tanggal_keluar']; ?></small></td>
                <td>Rp <?= number_format($r['total_bayar'],0,',','.'); ?></td>
                <td><span class="badge bg-<?= $badge_color; ?>"><?= $r['status']; ?></span></td>
                <td>
                    <button class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modalStatus<?= $r['id_transaksi']; ?>"><i class="fa fa-sync"></i> Status</button>
                </td>
            </tr>

            <div class="modal fade" id="modalStatus<?= $r['id_transaksi']; ?>">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="" method="POST">
                            <input type="hidden" name="id_transaksi" value="<?= $r['id_transaksi']; ?>">
                            <div class="modal-header"><h6>Update Status Cucian</h6></div>
                            <div class="modal-body">
                                <select name="status" class="form-select">
                                    <option value="Antrean" <?= $r['status']=='Antrean'?'selected':''; ?>>Antrean</option>
                                    <option value="Proses" <?= $r['status']=='Proses'?'selected':''; ?>>Proses</option>
                                    <option value="Selesai" <?= $r['status']=='Selesai'?'selected':''; ?>>Selesai</option>
                                    <option value="Diambil" <?= $r['status']=='Diambil'?'selected':''; ?>>Diambil</option>
                                </select>
                            </div>
                            <div class="modal-footer"><button type="submit" name="update_status" class="btn btn-primary btn-sm">Update</button></div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTransaksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header"><h5>Transaksi Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Pelanggan</label>
                        <select name="id_pelanggan" class="form-select" required>
                            <?php $p_q = mysqli_query($koneksi, "SELECT * FROM pelanggan"); while($p_r = mysqli_fetch_assoc($p_q)): ?>
                                <option value="<?= $p_r['id_pelanggan']; ?>"><?= $p_r['nama']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Paket</label>
                        <select name="id_paket_tarif" id="id_paket_tarif" class="form-select" onchange="hitungTotal()" required>
                            <option value="0|0">- Pilih Paket -</option>
                            <?php $pk_q = mysqli_query($koneksi, "SELECT * FROM paket_laundry"); while($pk_r = mysqli_fetch_assoc($pk_q)): ?>
                                <option value="<?= $pk_r['id_paket'].'|'.$pk_r['tarif']; ?>"><?= $pk_r['jenis_layanan'].' - '.$pk_r['nama_paket'].' (Rp. '.$pk_r['tarif'].'/'.$pk_r['satuan'].')'; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Qty)</label>
                        <input type="number" step="0.01" name="qty" id="qty" class="form-control" value="1" oninput="hitungTotal()" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estimasi Total Tagihan (Rp)</label>
                        <input type="text" id="total_estimasi" class="form-control bg-light" value="0" readonly>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label">Tgl Masuk</label><input type="date" name="tanggal_masuk" class="form-control" value="<?= date('Y-m-d'); ?>" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label">Tgl Selesai</label><input type="date" name="tanggal_keluar" class="form-control" value="<?= date('Y-m-d', strtotime('+2 days')); ?>" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label">Keterangan Tambahan</label><textarea name="keterangan" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" name="tambah_transaksi" class="btn btn-success">Simpan Order</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function hitungTotal() {
    var paketSelect = document.getElementById("id_paket_tarif").value;
    var qty = document.getElementById("qty").value;
    var tarif = paketSelect.split("|")[1];
    var total = parseFloat(qty) * parseInt(tarif);
    document.getElementById("total_estimasi").value = !isNaN(total) ? total : 0;
}
</script>

<?php include 'footer.php'; ?>