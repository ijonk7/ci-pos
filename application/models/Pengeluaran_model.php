<?php

class Pengeluaran_model extends MY_Model
{
    protected $table = 'tbl_pengeluaran';
    protected $table_notif = 'tbl_notifikasi';

    public function getDefaultValues()
    {
        return [
            'jenis_pengeluaran' => '',
            'nominal' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'jenis_pengeluaran',
                'label' => 'Jenis Pengeluaran',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'nominal',
                'label' => 'Nominal',
                'rules' => 'trim|required|max_length[20]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate($input)
    {
        $validationRules = [
            [
                'field' => 'edit_jenis_pengeluaran',
                'label' => 'Jenis Pengeluaran',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'edit_nominal',
                'label' => 'Nominal',
                'rules' => 'trim|required|max_length[20]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_pengeluaran',
                'label' => 'ID Pengeluaran',
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

    public function tambahPengeluaran($input)
    {
        $data = array(
            'jenis_pengeluaran' => $input->jenis_pengeluaran,
            'nominal' => str_replace(".", "", $input->nominal),
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan pengeluaran',
            'objek' => ucwords($input->jenis_pengeluaran),
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

    public function simpanPengeluaran($input)
    {
        $data = array(
            'jenis_pengeluaran' => $input->edit_jenis_pengeluaran,
            'nominal' => str_replace(".", "", $input->edit_nominal),
            'updated_at' => $this->waktu_sekarang
        );
        $pengeluaran_lama = $this->ambil_data_lama($input->edit_id_pengeluaran);

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'update pengeluaran ',
            'objek' => ucwords($pengeluaran_lama->jenis_pengeluaran),
            'update' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->update($this->table, $data, array('id' => $input->edit_id_pengeluaran));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deletePengeluaran($input)
    {
        $pengeluaran_lama = $this->ambil_data_lama($input->hapus_id_pengeluaran);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus pengeluaran',
            'objek' => ucwords($pengeluaran_lama->jenis_pengeluaran),
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->delete($this->table, array('id' => $input->hapus_id_pengeluaran));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function ambil_data_lama($id)
    {
        $data = $this->db->select('jenis_pengeluaran')->where('id', $id)->get($this->table)->row();
        return $data;
    }
}