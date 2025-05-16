<?php
namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori(); // Use the new method
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();

        // Get search keyword
        $q = $this->request->getVar('q') ?? '';

        // Get category filter
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
        ];

        // Building the query
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        // Apply search filter if keyword is provided
        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        // Apply category filter if category_id is provided
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Apply pagination
        $data['artikel'] = $builder->paginate(10);
        $data['pager'] = $model->pager;

        // Fetch all categories for the filter dropdown
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('artikel/admin_index', $data);
    }

    // Method for adding an article
    public function add()
    {
        // Validasi data
        if (
            $this->request->getMethod() == 'post' &&
            $this->validate([
                'judul' => 'required',
                'id_kategori' => 'required|integer', // Pastikan id_kategori wajib dan berupa integer
                'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]' // Validasi file gambar
            ])
        ) {
            // Mengambil file gambar dari request
            $file = $this->request->getFile('gambar');
            if ($file->isValid() && !$file->hasMoved()) {
                // Mengatur nama file gambar
                $gambarName = $file->getRandomName();
                // Mengupload gambar ke direktori public/gambar
                $file->move(ROOTPATH . 'public/gambar', $gambarName);
            } else {
                // Jika ada kesalahan saat upload gambar, kembalikan ke form dengan pesan error
                return redirect()->back()->with('errors', 'Gagal mengupload gambar');
            }

            // Membuat objek model ArtikelModel
            $model = new ArtikelModel();
            // Menyimpan data artikel ke database
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $gambarName // Simpan nama file gambar yang telah diupload
            ]);

            // Redirect ke halaman daftar artikel
            return redirect()->to('/admin/artikel');
        } else {
            // Jika validasi gagal atau bukan request POST
            // Mengambil data kategori untuk form
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();
            $data['title'] = "Tambah Artikel";
            // Menampilkan form tambah artikel
            return view('artikel/form_add', $data);
        }
    }

    // Method for editing an article
    public function edit($id)
    {
        $model = new ArtikelModel();
        if (
            $this->request->getMethod() == 'post' && $this->validate([
                'judul' => 'required',
                'id_kategori' => 'required|integer'
            ])
        ) {
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $data['artikel'] = $model->find($id);
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll(); // Fetch categories for the form
            $data['title'] = "Edit Artikel";
            return view('artikel/form_edit', $data);
        }
    }

    // Method for deleting an article
    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }

    // Method for viewing an article
    public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->where('slug', $slug)->first();

        if (empty($data['artikel'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }
}
