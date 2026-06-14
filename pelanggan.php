<?php 
include 'header.php'; 

if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    mysqli_query($koneksi, "INSERT INTO pelanggan (nama, no_telp, alamat) VALUES ('$nama', '$no_telp', '$alamat')");
    echo "<script>window.location='pelanggan.php';</script>";
}

if(isset($_POST['edit'])){
    $id = $_POST['id_pelanggan'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    mysqli_query($koneksi, "UPDATE pelanggan SET nama='$nama', no_telp='$no_telp', alamat='$alamat' WHERE id_pelanggan='$id'");
    echo "<script>window.location='pelanggan.php';</script>";
}

if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    echo "<script>window.location='pelanggan.php';</script>";
}
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0 text-secondary fw-bold">Data Pelanggan</h3>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="fa fa-plus"></i> Tambah Pelanggan</button>
</div>

<div class="card border-0 shadow-sm p-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
                while($row = mysqli_fetch_assoc($query)):
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><strong><?= $row['nama']; ?></strong></td>
                    <td><?= $row['no_telp'] ?: '-'; ?></td>
                    <td><?= $row['alamat'] ?: '-'; ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id_pelanggan']; ?>"><i class="fa fa-edit"></i></button>
                        <a href="pelanggan.php?hapus=<?= $row['id_pelanggan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pelanggan ini?')"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>

                <div class="modal fade" id="modalEdit<?= $row['id_pelanggan']; ?>">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="" method="POST">
                                <div class="modal-header"><h5>Edit Pelanggan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body">
                                    <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan']; ?>">
                                    <div class="mb-3"><label class="form-label">Nama</label><input type="text" name="nama" class="form-control" value="<?= $row['nama']; ?>" required></div>
                                    <div class="mb-3"><label class="form-label">No. Telp</label><input type="text" name="no_telp" class="form-control" value="<?= $row['no_telp']; ?>"></div>
                                    <div class="mb-3"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control"><?= $row['alamat']; ?></textarea></div>
                                </div>
                                <div class="modal-footer"><button type="submit" name="edit" class="btn btn-primary">Simpan</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header"><h5>Tambah Pelanggan</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">Nama Pelanggan</label><input type="text" name="nama" class="form-control" required autocomplete="off"></div>
                    <div class="mb-3"><label class="form-label">No. Telp</label><input type="text" name="no_telp" class="form-control"></div>
                    <div class="mb-3"><label class="form-label">Alamat</label><textarea name="alamat" class="form-control"></textarea></div>
                </div>
                <div class="modal-footer"><button type="submit" name="tambah" class="btn btn-success">Simpan</button></div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>