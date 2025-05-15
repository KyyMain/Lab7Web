<?= $this->include('template/admin_header'); ?>

<h2 class="content-title"><?= $title; ?></h2>

<div class="row mb-3">
    <div class="col-md-6">
        <!-- Form Pencarian dan Filter -->
        <form method="get" class="form-inline">
            <div class="form-group">
                <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari judul artikel"
                    class="form-control mr-2">
            </div>

            <div class="form-group">
                <select name="kategori_id" class="form-control mr-2">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= $k['id_kategori']; ?>" <?= ($kategori_id == $k['id_kategori']) ? 'selected' : ''; ?>>
                            <?= $k['nama_kategori']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <input type="submit" value="Cari" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<!-- Tabel Daftar Artikel -->
<div class="table-responsive">
    <table class="table data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($artikel) > 0): ?>
                <?php foreach ($artikel as $row): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td>
                            <b><?= $row['judul']; ?></b>
                            <p><small><?= substr($row['isi'], 0, 50); ?>...</small></p>
                            </td>
                        <td><?= $row['nama_kategori']; ?></td>
                        <td><?= $row['status']; ?></td>
                        <td class="action-buttons">
                            <a class="btn btn-sm btn-info" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                            <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');"
                                href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                        </td>
                        </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
            <?php endif; ?>
                    </tbody>
                    </table>
                    </div>

<!-- Pagination -->
<div class="pagination-container">
    <?= $pager->only(['q', 'kategori_id'])->links(); ?>
</div>

<!-- Tombol Tambah Artikel Baru -->
<div class="action-area">
    <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-success add-btn">Tambah Artikel Baru</a>
</div>

<?= $this->include('template/admin_footer'); ?>