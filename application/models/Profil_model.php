<?php

class Profil_model extends MY_Model
{
    protected $table = 'tbl_users';

    public function getValidationRulesUpdate()
    {
        $validationRules = [
            [
                'field' => 'password_lama',
                'label' => 'Password Lama',
                'rules' => 'trim|callback_cekPasswordLama'
            ],
            [
                'field' => 'password_baru',
                'label' => 'Password Baru',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'konfirmasi_password_baru',
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'trim|required|matches[password_baru]'
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

    public function ambilFoto()
    {
        $data = $this->db->select('foto')->where('id', $this->session->userdata('id_user'))->get($this->table)->row_array();
        return $data;
    }

    public function ambilPassword()
    {
        $data = $this->db->select('password')->get($this->table)->row_array();
        return $data;
    }

    public function simpanProfil($input, $data_upload)
    {
        if (!empty($input['password_lama']) or !empty($input['password_baru']) or !empty($input['konfirmasi_password_baru'])) {
            // Memeriksa apakah ada file tertentu yang sudah diupload
            if ($_FILES['foto_profil']['error'] !== 4) {
                $options = [
                'cost' => 12,
                ];
        
                $password = password_hash($input['password_baru'], PASSWORD_BCRYPT, $options);

                $data = array(
                    'password' => $password,
                    'foto' => $data_upload['foto']['file_name'],
                    'updated_at' => $this->waktu_sekarang
                );
            } else {
                $options = [
                'cost' => 12,
                ];
        
                $password = password_hash($input['password_baru'], PASSWORD_BCRYPT, $options);

                $data = array(
                    'password' => $password,
                    'updated_at' => $this->waktu_sekarang
                );
            }
        } else {
            // Memeriksa apakah ada file tertentu yang sudah diupload
            if ($_FILES['foto_profil']['error'] !== 4) {
                $data = array(
                    'foto' => $data_upload['foto']['file_name'],
                    'updated_at' => $this->waktu_sekarang
                );
            } else {
                redirect('profil');
            }
        }
    
        // Update seperti ini untuk menghindari return false saat meng-update data yang sama
        $this->db->trans_start();
        $this->db->where('id', $input['id_user']);
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