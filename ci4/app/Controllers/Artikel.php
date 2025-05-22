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
        $kategoriModel = new KategoriModel();

        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1;
        $sort = $this->request->getVar('sort') ?? 'id';
        $order = $this->request->getVar('order') ?? 'desc';

        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $builder->orderBy($sort, $order);

        $artikel = $builder->paginate(3, 'default', $page);
        $pager = $model->pager;

        if ($this->request->isAJAX()) {
            // Pagination links parsing
            $links = $pager->only(['q', 'kategori_id'])->links();
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($links);
            $xpath = new \DOMXPath($dom);
            $linkNodes = $xpath->query("//a | //span");

            $parsedLinks = [];
            foreach ($linkNodes as $node) {
                $tag = $node->nodeName;
                $title = $node->nodeValue;
                $active = $node->parentNode->getAttribute('class') === 'active';
                $url = $tag === 'a' ? $node->getAttribute('href') : null;

                $parsedLinks[] = [
                    'title' => $title,
                    'url' => $url,
                    'active' => $active
                ];
            }

            return $this->response->setJSON([
                'artikel' => $artikel,
                'pager' => ['links' => $parsedLinks],
                'q' => $q,
                'kategori_id' => $kategori_id,
                'sort' => $sort,
                'order' => $order
            ]);
        } else {
            return view('artikel/admin_index', [
                'title' => $title,
                'q' => $q,
                'kategori_id' => $kategori_id,
                'artikel' => $artikel,
                'pager' => $pager,
                'kategori' => $kategoriModel->findAll(),
                'sort' => $sort,
                'order' => $order
            ]);
        }
    }


    public function add()
    {
        // Validation...
        $validation = \Config\Services::validation();
        $validation->setRules(['judul' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();
        if (
            $isDataValid &&
            $this->request->getMethod() == 'POST' && $this->validate([
                'judul' => 'required',
                        'id_kategori' => 'required|integer' // Ensure id_kategori is required and an integer
            ])
        ) {
            $file = $this->request->getFile('gambar');
            $file->move(ROOTPATH . 'public/gambar');
            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $file->getName(),
            ]);

            return redirect()->to('/admin/artikel');
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll(); // Fetch categories for the form
            $data['title'] = "Tambah Artikel";

            return view('artikel/form_add', $data);
        }
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        if (
            $this->request->getMethod() == 'POST' && $this->validate([
                'judul' => 'required',
                'id_kategori' => 'required|integer'
            ])
        ) {
            $file = $this->request->getFile('gambar');
            $file->move(ROOTPATH . 'public/gambar');
            $model->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $file->getName(),
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

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        $db = \Config\Database::connect();
        $db->query("ALTER TABLE artikel AUTO_INCREMENT = 1");

        return redirect()->to('/admin/artikel');
    }

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