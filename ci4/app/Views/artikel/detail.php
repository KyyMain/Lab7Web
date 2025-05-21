<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= $artikel['judul']; ?>"
        style="max-width: 100%; height: auto;">

    <p><?= $artikel['isi']; ?></p>
</article>

<?= $this->endSection(); ?>