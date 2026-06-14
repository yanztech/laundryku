<?php include 'header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0 text-secondary fw-bold">Laporan Transaksi</h3>
    <button class="btn btn-outline-primary btn-sm" onclick="window.print()"><i class="fa fa-print"></i> Cetak Dokumen</button>
</div>

<div class="card border-0 shadow-sm p-3">
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" style="font-size: 14px;">
            <thead class="table-dark">
                <tr>
                    <th>Nota</th>
                    <th>Pelanggan</th>
                    <th>Telepon</th>
                    <th>Layanan</th>
                    <th>Paket</th>
                    <th>Qty</th>
                    <th>Tarif</th>
                    <th>Total</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $l_query = mysqli_query($koneksi, "SELECT * FROM v_laporan_transaksi ORDER BY id_transaksi DESC");
                while($lr = mysqli_fetch_assoc($l_query)):
                ?>
                <tr>
                    <td><code><?= $lr['no_nota']; ?></code></td>
                    <td><?= $lr['pelanggan']; ?></td>
                    <td><?= $lr['no_telp'] ?: '-'; ?></td>
                    <td><?= $lr['jenis_layanan']; ?></td>
                    <td><?= $lr['nama_paket']; ?></td>
                    <td><?= $lr['qty']; ?> <?= $lr['satuan']; ?></td>
                    <td><?= number_format($lr['harga_satuan'],0,',','.'); ?></td>
                    <td class="fw-bold"><?= number_format($lr['total_bayar'],0,',','.'); ?></td>
                    <td><?= $lr['tanggal_masuk']; ?></td>
                    <td><?= $lr['tanggal_keluar']; ?></td>
                    <td><span class="badge bg-secondary"><?= $lr['status']; ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>