<?php

class Produk_model extends MY_Model
{
    protected $table = 'tbl_produk';
    protected $table_notif = 'tbl_notifikasi'; 

    public function getDefaultValues()
    {
        return [
            'nama_produk' => '',
            'kode_produk' => '',
            'kategori_produk' => '',
            'merk' => '',
            'harga_beli' => '',
            'diskon' => '0',
            'harga_jual' => '',
            'stok' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'kode_produk',
                'label' => 'Kode Produk',
                'rules' => 'trim|required|max_length[50]|is_unique[tbl_produk.kode_produk]'
            ],
            [
                'field' => 'nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'trim|required|max_length[100]|is_unique[tbl_produk.nama_produk]'
            ],
            [
                'field' => 'kategori_produk',
                'label' => 'Kategori Produk',
                'rules' => 'trim|required|numeric|max_length[10]'
            ],
            [
                'field' => 'merk',
                'label' => 'Merk',
                'rules' => 'trim|max_length[50]|max_length[50]'
            ],
            [
                'field' => 'harga_beli',
                'label' => 'Harga Beli',
                'rules' => 'trim|required|max_length[20]'
            ],
            [
                'field' => 'diskon',
                'label' => 'Diskon',
                'rules' => 'trim|required|numeric|max_length[10]'
            ],
            [
                'field' => 'harga_jual',
                'label' => 'Harga Jual',
                'rules' => 'trim|required|max_length[20]'
            ],
            [
                'field' => 'stok',
                'label' => 'Stok',
                'rules' => 'trim|required|numeric|max_length[10]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate($input)
    {
        $nilai_awal = $this->db->select('kode_produk, nama_produk')->where('id', $input->edit_id_produk)->get('tbl_produk')->row();
        
        if($input->edit_nama_produk != $nilai_awal->nama_produk) {
            $unik_nama_produk =  '|is_unique[tbl_produk.nama_produk]';
         } else {
            $unik_nama_produk =  '';
         }

        $validationRules = [
            [
                'field' => 'edit_id_produk',
                'label' => 'ID Produk',
                'rules' => 'trim|required|numeric|max_length[10]'
            ],
            [
                'field' => 'edit_kode_produk',
                'label' => 'Kode Produk',
                'rules' => 'trim|max_length[50]'
            ],
            [
                'field' => 'edit_nama_produk',
                'label' => 'Nama Produk',
                'rules' => 'trim|required|max_length[100]'.$unik_nama_produk
            ],
            [
                'field' => 'edit_kategori_produk',
                'label' => 'Kategori Produk',
                'rules' => 'trim|required|numeric|max_length[10]'
            ],
            [
                'field' => 'edit_merk',
                'label' => 'Merk',
                'rules' => 'trim|max_length[50]|max_length[50]'
            ],
            [
                'field' => 'edit_harga_beli',
                'label' => 'Harga Beli',
                'rules' => 'trim|required|max_length[20]'
            ],
            [
                'field' => 'edit_diskon',
                'label' => 'Diskon',
                'rules' => 'trim|required|numeric|max_length[10]'
            ],
            [
                'field' => 'edit_harga_jual',
                'label' => 'Harga Jual',
                'rules' => 'trim|required|max_length[20]'
            ],
            [
                'field' => 'edit_stok',
                'label' => 'Stok',
                'rules' => 'trim|required|numeric|max_length[10]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_produk',
                'label' => 'ID Produk',
                'rules' => 'trim|required|numeric'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesMultipleDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_multiple_id_produk',
                'label' => 'ID Produk',
                'rules' => 'trim|required'
            ]
        ];

        return $validationRules;
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function validateUpdate($input)
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRulesUpdate($input);
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function validateDelete()
    {
        $this->form_validation->set_error_delimiters('<p style="color:Tomato;">', '</p>');
        $validationRules = $this->getValidationRulesDelete();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function validateMultipleDelete()
    {
        $this->form_validation->set_error_delimiters('<p style="color:Tomato;">', '</p>');
        $validationRules = $this->getValidationRulesMultipleDelete();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function tambahProduk($input)
    {
        $data = array(
            'kode_produk' => $input->kode_produk,
            'nama_produk' => ucwords($input->nama_produk),
            'id_kategori' => $input->kategori_produk,
            'merk' => $input->merk,
            'harga_beli' => str_replace(".", "", $input->harga_beli),
            'diskon' => $input->diskon,
            'harga_jual' => str_replace(".", "", $input->harga_jual),
            'stok' => $input->stok,
            'nama_produk' => $input->nama_produk,
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan produk',
            'objek' => ucwords($input->nama_produk) . ' (' . $input->kode_produk . ')',
            'create' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->insert($this->table, $data);
        $this->db->insert($this->table_notif, $notifikasi);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function simpanProduk($input)
    {
        $data = array(
            'nama_produk' => ucwords($input->edit_nama_produk),
            'id_kategori' => $input->edit_kategori_produk,
            'merk' => $input->edit_merk,
            'harga_beli' => str_replace(".", "", $input->edit_harga_beli),
            'diskon' => $input->edit_diskon,
            'harga_jual' => str_replace(".", "", $input->edit_harga_jual),
            'stok' => $input->edit_stok,
            'nama_produk' => $input->edit_nama_produk,
            'updated_at' => $this->waktu_sekarang
        );
        $produk_lama = $this->ambil_data_lama($input->edit_id_produk);

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'update produk ',
            'objek' => ucwords($produk_lama->nama_produk),
            'update' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->update($this->table, $data, array('id' => $input->edit_id_produk));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteProduk($input)
    {
        $produk_lama = $this->ambil_data_lama($input->hapus_id_produk);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus produk',
            'objek' => ucwords($produk_lama->nama_produk),
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->delete($this->table, array('id' => $input->hapus_id_produk));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteMultipleProduk($data)
    {        
		for ($i=0; $i < count($data) ; $i++) { 
			$this->db->where('id', $data[$i]);
            $this->db->delete($this->table);
        }

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function ambil_data_lama($id)
    {
        $data = $this->db->select('nama_produk')->where('id', $id)->get($this->table)->row();
        return $data;
    }

    public function ambilKategori()
    {
        $list_kategori = $this->db->order_by('nama_kategori', 'ASC')->get('tbl_kategori')->result();
        
        $data = array();
        foreach ($list_kategori as $value) {
            $data[$value->id] = $value->nama_kategori;
        }
        
        $data = array('' => '') + $data;

        return $data;
    }
}