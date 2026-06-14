<?php 
include 'header.php'; 

if(isset($_POST['tambah'])){
    $jenis = $_POST['jenis_layanan'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_paket']);
    $waktu = mysqli_real_escape_string($koneksi, $_POST['waktu_kerja']);
    $tarif = $_POST['tarif'];
    $satuan = $_POST['satuan'];
    mysqli_query($koneksi, "INSERT INTO paket_laundry (jenis_layanan, nama_paket, waktu_kerja, tarif, satuan) VALUES ('$jenis', '$nama', '$waktu', '$tarif', '$satuan')");
    echo "<script>window.location='paket.php';</script>";
}

if(isset($_GET['hapus'])){
    mysqli_query($koneksi, "DELETE FROM paket_laundry WHERE id_paket='".$_GET['hapus']."'");
    echo "<script>window.location='paket.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0 text-secondary fw-bold">Paket Laundry</h3>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalPaket"><i class="fa fa-plus"></i> Tambah Paket</button>
</div>

<div class="card border-0 shadow-sm p-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Jenis Layanan</th>
                <th>Nama Paket</th>
                <th>Waktu Kerja</th>
                <th>Tarif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=1; $q=mysqli_query($koneksi, "SELECT * FROM paket_laundry");
            while($r=mysqli_fetch_assoc($q)):
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><span class="badge bg-secondary"><?= $r['jenis_layanan']; ?></span></td>
                <td><strong><?= $r['nama_paket']; ?></strong></td>
                <td><?= $r['waktu_kerja'] ?: '-'; ?></td>
                <td>Rp <?= number_format($r['tarif'],0,',','.'); ?> / <?= $r['satuan']; ?></td>
                <td>
                    <a href="paket.php?hapus=<?= $r['id_paket']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus paket?')"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalPaket">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header"><h5>Tambah Paket Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Layanan</label>
                        <select name="jenis_layanan" class="form-select" required>
                            <option value="Cuci Komplit">Cuci Komplit</option>
                            <option value="Cuci Satuan">Cuci Satuan</option>
                            <option value="Dry Clean">Dry Clean</option>
                        </select>
                    </div>
                    <div class="mb-3"><label class="form-label">Nama Paket</label><input type="text" name="nama_paket" class="form-control" required></div>
                    <div class="mb-3"><label class="form-label">Waktu Kerja</label><input type="text" name="waktu_kerja" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Tarif (Rp)</label><input type="number" name="tarif" class="form-control" required></div>
                    <div class="mb-3">
                        <label class="form-label">Satuan</label>
                        <select name="satuan" class="form-select">
                            <option value="Kg">Kg</option>
                            <option value="Pcs">Pcs</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer"><button type="submit" name="tambah" class="btn btn-success">Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>