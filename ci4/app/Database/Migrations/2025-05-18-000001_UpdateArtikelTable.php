<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateArtikelTable extends Migration
{
    public function up()
    {
        // Cek apakah tabel artikel sudah ada
        if (!$this->db->tableExists('artikel')) {
            // Buat tabel artikel baru
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'judul' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'isi' => [
                    'type' => 'TEXT',
                ],
                'gambar' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'status' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'default' => 'published',
                ],
                'slug' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                ],
                'id_kategori' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('id_kategori', 'kategori', 'id_kategori', 'CASCADE', 'CASCADE');
            $this->forge->createTable('artikel');
        } else {
            // Tabel sudah ada, periksa dan tambahkan kolom yang hilang
            $fields = [];

            // Periksa kolom status
            if (!$this->db->fieldExists('status', 'artikel')) {
                $fields['status'] = [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'default' => 'published',
                    'after' => 'gambar',
                ];
            }

            // Periksa kolom created_at
            if (!$this->db->fieldExists('created_at', 'artikel')) {
                $fields['created_at'] = [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'id_kategori',
                ];
            }

            // Periksa kolom updated_at
            if (!$this->db->fieldExists('updated_at', 'artikel')) {
                $fields['updated_at'] = [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at',
                ];
            }

            // Terapkan perubahan jika ada
            if (!empty($fields)) {
                $this->forge->addColumn('artikel', $fields);
            }
        }
    }

    public function down()
    {
        // Tidak melakukan apa-apa pada down migration
        // Kita tidak ingin menghapus tabel artikel
    }
}