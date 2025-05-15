<?= $this->include('template/admin_header'); ?>
<div class="admin-form">
    <h2><?= $title; ?></h2>
<?php if (isset($validation)): ?>
    <div class="alert alert-danger">
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="judul">Judul</label>
        <input type="text" name="judul" id="judul" placeholder="Masukkan Judul" value="<?= old('judul'); ?>" required>
    </div>

    <div class="form-group">
        <label for="isi">Isi</label>
        <textarea name="isi" id="isi" cols="50" rows="10"
            placeholder="Masukkan Isi Artikel"><?= old('isi'); ?></textarea>
    </div>

    <div class="form-group">
        <label for="id_kategori">Kategori</label>
        <select name="id_kategori" id="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id_kategori']; ?>" <?= old('id_kategori') == $k['id_kategori'] ? 'selected' : ''; ?>>
                    <?= $k['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="gambar">Gambar</label>
        <input type="file" name="gambar" id="gambar">
        <small>Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 1MB</small>
    </div>

    <div class="form-submit">
        <input type="submit" value="Kirim" class="btn btn-large">
    </div>
</form>
</div>
<?= $this->include('template/admin_footer'); ?>