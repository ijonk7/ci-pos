<?php

class Supplier_model extends MY_Model
{
    protected $table = 'tbl_supplier';
    protected $table_notif = 'tbl_notifikasi';

    public function getDefaultValues()
    {
        return [
            'nama' => '',
            'alamat' => '',
            'telepon' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama Supplier',
                'rules' => 'trim|required|max_length[100]|is_unique[tbl_supplier.nama]'
            ],
            [
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'Telepon',
                'rules' => 'trim|required|numeric|max_length[20]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate($input)
    {
        $nilai_awal = $this->db->select('nama')->where('id', $input->edit_id_supplier)->get('tbl_supplier')->row();

        if($input->edit_nama != $nilai_awal->nama) {
            $unik_nama =  '|is_unique[tbl_supplier.nama]';
         } else {
            $unik_nama =  '';
         }

        $validationRules = [
            [
                'field' => 'edit_nama',
                'label' => 'Nama Supplier',
                'rules' => 'trim|required|max_length[100]'.$unik_nama
            ],
            [
                'field' => 'edit_alamat',
                'label' => 'Alamat',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'edit_telepon',
                'label' => 'Telepon',
                'rules' => 'trim|required|numeric|max_length[20]'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_supplier',
                'label' => 'ID Supplier',
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

    public function tambahSupplier($input)
    {
        $data = array(
            'nama' => $input->nama,
            'alamat' => $input->alamat,
            'telepon' => $input->telepon,
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan supplier',
            'objek' => ucwords($input->nama),
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

    public function simpanSupplier($input)
    {
        $data = array(
            'nama' => $input->edit_nama,
            'alamat' => $input->edit_alamat,
            'telepon' => $input->edit_telepon,
            'updated_at' => $this->waktu_sekarang
        );
        $supplier_lama = $this->ambil_data_lama($input->edit_id_supplier);

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'update supplier ',
            'objek' => ucwords($supplier_lama->nama),
            'update' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->update($this->table, $data, array('id' => $input->edit_id_supplier));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteSupplier($input)
    {
        $supplier_lama = $this->ambil_data_lama($input->hapus_id_supplier);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus supplier',
            'objek' => ucwords($supplier_lama->nama),
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->delete($this->table, array('id' => $input->hapus_id_supplier));
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
        $data = $this->db->select('nama')->where('id', $id)->get($this->table)->row();
        return $data;
    }
}