<?php

class Kategori_model extends MY_Model
{
    protected $table = 'tbl_kategori';
    protected $table_notif = 'tbl_notifikasi';   

    public function getDefaultValues()
    {
        return [
            'nama_kategori' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama_kategori',
                'label' => 'Nama Kategori',
                'rules' => 'trim|required|max_length[100]|is_unique[tbl_kategori.nama_kategori]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate($input)
    {
        $nilai_awal = $this->db->select('nama_kategori')->where('id', $input->edit_id_kategori)->get('tbl_kategori')->row();

        if($input->edit_nama_kategori != $nilai_awal->nama_kategori) {
            $unik_nama_kategori =  '|is_unique[tbl_kategori.nama_kategori]';
         } else {
            $unik_nama_kategori =  '';
         }

        $validationRules = [
            [
                'field' => 'edit_nama_kategori',
                'label' => 'Nama Kategori',
                'rules' => 'trim|required|max_length[100]'.$unik_nama_kategori
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_kategori',
                'label' => 'ID Kategori',
                'rules' => 'trim|required|numeric'
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

    public function tambahKategori($input)
    {
        $data = array(
            'nama_kategori' => ucwords($input->nama_kategori),
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan kategori',
            'objek' => ucwords($input->nama_kategori),
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

    public function simpanKategori($input)
    {
        $data = array(
            'nama_kategori' => ucwords($input->edit_nama_kategori),
            'updated_at' => $this->waktu_sekarang
        );
        $kategori_lama = $this->ambilDataLama($input->edit_id_kategori);

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'update kategori ' . ucwords($kategori_lama->nama_kategori) . ' menjadi',
            'objek' => ucwords($input->edit_nama_kategori),
            'update' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->update($this->table, $data, array('id' => $input->edit_id_kategori));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteKategori($input)
    {
        $kategori_lama = $this->ambilDataLama($input->hapus_id_kategori);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus kategori',
            'objek' => strtolower($kategori_lama->nama_kategori),
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->delete($this->table, array('id' => $input->hapus_id_kategori));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function ambilDataLama($id)
    {
        $data = $this->db->select('nama_kategori')->where('id', $id)->get($this->table)->row();
        return $data;
    }
}