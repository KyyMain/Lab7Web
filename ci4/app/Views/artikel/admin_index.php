<?= $this->include('template/admin_header'); ?>

<div class="admin-content">
    <h2>Data Artikel</h2>
    <a class="btn btn-primary" href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($artikel):
                    foreach ($artikel as $row): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td>
                                <b><?= $row['judul']; ?></b>
                                <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
                            </td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <a class="btn btn-primary" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                                <a class="btn btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="4">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->include('template/admin_footer'); ?>