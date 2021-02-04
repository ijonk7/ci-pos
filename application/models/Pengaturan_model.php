<?php

class Pengaturan_model extends MY_Model
{
    protected $table = 'tbl_pengaturan';

    public function getValidationRulesUpdate()
    {
        $validationRules = [
            [
                'field' => 'nama_perusahaan',
                'label' => 'Nama Perusahaan',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'Telepon',
                'rules' => 'trim|required|numeric'
            ]
        ];

        return $validationRules;
    }

    public function validateUpdate()
    {
        $this->form_validation->set_error_delimiters('<p style="color:#FF0000;">', '</p>');
        $validationRules = $this->getValidationRulesUpdate();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function ambilData()
    {
        $data = $this->db->get($this->table)->row_array();
        return $data;
    }

    public function ambilLogo()
    {
        $data = $this->db->select('logo')->get($this->table)->row_array();
        return $data['logo'];
    }

    public function simpanPengaturan($input, $data_upload)
    {
        // Memeriksa apakah ada file tertentu yang sudah diupload
        if ($_FILES['logo_perusahaan']['error'] !== 4) {
            $data = array(
                'nama_perusahaan' => $input['nama_perusahaan'],
                'alamat' => $input['alamat'],
                'telepon' => $input['telepon'],
                'logo' => $data_upload['logo']['file_name'],
                'updated_at' => $this->waktu_sekarang
            );
        } else {
            $data = array(
                'nama_perusahaan' => $input['nama_perusahaan'],
                'alamat' => $input['alamat'],
                'telepon' => $input['telepon'],
                'updated_at' => $this->waktu_sekarang
            );
        }

        // Update seperti ini untuk menghindari return false saat meng-update data yang sama
        $this->db->trans_start();
        $this->db->where('id_setting', $input['id_pengaturan']);
        $this->db->update($this->table, $data);
        $this->db->trans_complete();
        
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            // any trans error?
            if ($this->db->trans_status() === false) {
                return false;
            }
            return true;
        }
    }
}