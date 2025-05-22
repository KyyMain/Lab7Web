<?= $this->include('template/admin_header'); ?>

<h2 class="content-title"><?= $title; ?></h2>

<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="form-inline">
            <div class="form-group">
                <input type="text" name="q" id="search-box" value="<?= $q; ?>" placeholder="Cari judul artikel"
                    class="form-control mr-2">
            </div>

            <div class="form-group">
                <select name="kategori_id" id="category-filter" class="form-control mr-2">
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

<div id="article-container"></div>
<div id="pagination-container"></div>

<div class="action-area my-3">
    <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-success add-btn">Tambah Artikel Baru</a>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const articleContainer = $('#article-container');
        const paginationContainer = $('#pagination-container');
        const searchForm = $('#search-form');
        const searchBox = $('#search-box');
        const categoryFilter = $('#category-filter');

        let currentSort = 'id';
        let currentOrder = 'desc';

        const getSortIcon = (column) => {
            if (column === currentSort) {
                return currentOrder === 'asc' ? '↑' : '↓';
            }
            return '';
        };

        const fetchData = (url) => {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function (data) {
                    renderArticles(data.artikel);
                    renderPagination(data.pager, data.q, data.kategori_id);
                },
                error: function () {
                    articleContainer.html('<div class="alert alert-danger">Gagal memuat data artikel.</div>');
                    paginationContainer.empty();
                }
            });
        };

        const renderArticles = (articles) => {
            let html = '<div class="table-responsive"><table class="table">';
            html += `
        <thead>
            <tr>
                <th><a href="#" class="sort-link" data-sort="id">ID ${getSortIcon('id')}</a></th>
                <th><a href="#" class="sort-link" data-sort="judul">Judul ${getSortIcon('judul')}</a></th>
                <th><a href="#" class="sort-link" data-sort="nama_kategori">Kategori ${getSortIcon('nama_kategori')}</a></th>
                <th><a href="#" class="sort-link" data-sort="status">Status ${getSortIcon('status')}</a></th>
                <th>Aksi</th>
            </tr>
        </thead><tbody>`;

        if (articles.length > 0) {
            articles.forEach(article => {
                html += `
                <tr>
                    <td>${article.id}</td>
                    <td><b>${article.judul}</b><p><small>${article.isi.substring(0, 50)}...</small></p></td>
                    <td>${article.nama_kategori}</td>
                    <td>${article.status}</td>
                    <td>
                        <a class="btn btn-sm btn-info" href="/admin/artikel/edit/${article.id}">Ubah</a>
                        <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="/admin/artikel/delete/${article.id}">Hapus</a>
                    </td>
                </tr>`;
            });
        } else {
            html += '<tr><td colspan="5" class="text-center">Tidak ada data.</td></tr>';
        }

        html += '</tbody></table></div>';
        articleContainer.html(html);
    };

    const renderPagination = (pager, q, kategori_id) => {
        let html = '<div class="pagination-container"><nav><ul class="pagination">';
        pager.links.forEach(link => {
            const url = link.url ? `${link.url}&q=${q}&kategori_id=${kategori_id}&sort=${currentSort}&order=${currentOrder}` : '#';
            html += `<li class="page-item ${link.active ? 'active' : ''}"><a class="page-link" href="${url}">${link.title}</a></li>`;
        });
        html += '</ul></nav></div>';
        paginationContainer.html(html);
    };

    searchForm.on('submit', function (e) {
        e.preventDefault();
        const q = searchBox.val();
        const kategori_id = categoryFilter.val();
        fetchData(`/admin/artikel?q=${q}&kategori_id=${kategori_id}&sort=${currentSort}&order=${currentOrder}`);
    });

    categoryFilter.on('change', function () {
        searchForm.trigger('submit');
    });

    paginationContainer.on('click', 'a.page-link', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            fetchData(url);
        }
    });

    articleContainer.on('click', '.sort-link', function (e) {
        e.preventDefault();
        const newSort = $(this).data('sort');
        if (currentSort === newSort) {
            currentOrder = (currentOrder === 'asc') ? 'desc' : 'asc';
        } else {
            currentSort = newSort;
            currentOrder = 'asc';
        }
        searchForm.trigger('submit');
    });

    fetchData(`/admin/artikel?sort=${currentSort}&order=${currentOrder}`);
});
</script>



<?= $this->include('template/admin_footer'); ?>
