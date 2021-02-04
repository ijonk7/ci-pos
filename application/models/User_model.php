<?php

class User_model extends MY_Model
{
    protected $table = 'tbl_users';
    protected $table_notif = 'tbl_notifikasi';

    public function getDefaultValues()
    {
        return [
            'nama' => '',
            'username' => '',
            'email' => '',
            'password_baru' => '',
            'konfirmasi_password_baru' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required|is_unique[tbl_users.username]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
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
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate()
    {
        $validationRules = [
            [
                'field' => 'edit_nama',
                'label' => 'Nama',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'edit_username',
                'label' => 'Username',
                'rules' => 'trim|required|callback_cekUsernameUnik'
            ],
            [
                'field' => 'edit_email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email'
            ],
            [
                'field' => 'edit_password_baru',
                'label' => 'Password Baru',
                'rules' => 'trim'
            ],
            [
                'field' => 'edit_konfirmasi_password_baru',
                'label' => 'Konfirmasi Password Baru',
                'rules' => 'trim|matches[edit_password_baru]'
            ],
            [
                'field' => 'edit_level',
                'label' => 'Level',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_user',
                'label' => 'ID user',
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

    public function validateUpdate()
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRulesUpdate();
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

    public function tambahUser($input)
    {
        $options = [
        'cost' => 12,
        ];

        $password = password_hash($input->password_baru, PASSWORD_BCRYPT, $options);

        $data = array(
            'nama' => $input->nama,
            'username' => $input->username,
            'email' => $input->email,
            'foto' => 'user_default.png',
            'klik_pesan' => $this->waktu_sekarang,
            'klik_notifikasi' => $this->waktu_sekarang,
            'password' => $password,
            'level' => $input->level,
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan user',
            'objek' => $input->username,
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

    public function simpanUser($input)
    {
        if (!empty($input->edit_password_baru)) {
            $options = [
            'cost' => 12,
            ];
    
            $password = password_hash($input->edit_password_baru, PASSWORD_BCRYPT, $options);

            $data = array(
                'nama' => $input->edit_nama,
                'username' => $input->edit_username,
                'email' => $input->edit_email,
                'password' => $password,
                'level' => $input->edit_level,
                'updated_at' => $this->waktu_sekarang
            );
        } else {
            $data = array(
                'nama' => $input->edit_nama,
                'username' => $input->edit_username,
                'email' => $input->edit_email,
                'level' => $input->edit_level,
                'updated_at' => $this->waktu_sekarang
            );
        }

        $user_lama = $this->ambil_data_lama($input->edit_id_user);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'update user ',
            'objek' => $user_lama->username,
            'update' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->update($this->table, $data, array('id' => $input->edit_id_user));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deleteUser($input)
    {
        $user_lama = $this->ambil_data_lama($input->hapus_id_user);
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus user',
            'objek' => $user_lama->username,
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->delete($this->table, array('id' => $input->hapus_id_user));
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
        $data = $this->db->select('username')->where('id', $id)->get($this->table)->row();
        return $data;
    }

    public function ambil_username_unik($str)
    {
        $input = $this->input->post('edit_id_user', true);
        $data = $this->db->select('id')->where('id <>', $input)->where('username', $str)->get($this->table)->result_array();
        return $data;
    }
}