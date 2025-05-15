<?= $this->include('template/admin_header'); ?>
<div class="admin-form">
    <h2><?= $title; ?></h2>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul">Judul</label>
            <!-- Jika mengedit, tampilkan value judul yang sudah ada -->
            <input type="text" name="judul" id="judul" value="<?= isset($artikel) ? $artikel['judul'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <!-- Jika mengedit, tampilkan isi yang sudah ada -->
        <textarea name="isi" id="isi" cols="50" rows="10"><?= isset($artikel) ? $artikel['isi'] : ''; ?></textarea>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" required>
            <?php foreach ($kategori as $k): ?>
                <!-- Jika mengedit, set kategori yang dipilih sesuai dengan id_kategori yang ada -->
                <option value="<?= $k['id_kategori']; ?>" <?= isset($artikel) && $artikel['id_kategori'] == $k['id_kategori'] ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="gambar">Gambar</label>
        <div class="file-input">
            <input type="file" name="gambar" id="gambar">
        </div>
    </div>

    <div class="form-submit">
        <input type="submit" value="<?= isset($artikel) ? 'Update' : 'Kirim'; ?>" class="btn">
    </div>
</form>
</div>

<?= $this->include('template/admin_footer'); ?>