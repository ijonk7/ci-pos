<?php

class Login_model extends CI_Model
{
    protected $table = 'tbl_users';    

    public function getDefaultValues()
    {
        return [
            'username' => ''
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required'
            ],
        ];

        return $validationRules;
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<p style="color:Tomato;">', '</p>');
        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function run($input)
    {
        $this->load->database();

        $user = $this->db->where('username', $input->username)
                          ->limit(1)
                          ->get($this->table)
                          ->row();

        if (password_verify($input->password, $user->password)) {
            if (count($user)) {
                $this->load->helper('tanggal');
                $data = [
                    'id_user' => $user->id,
                    'username' => $user->username,
                    'sudah_login' => true,
                    'nama' => $user->nama,
                    'jabatan' => $user->jabatan,
                    'foto' => $user->foto,
                    'level' => $user->level,
                    'created_at' => formatTanggal($user->created_at)
                ];
                $this->session->set_userdata($data);
                return true;
            }        
        }
        return false;
    }

    public function ambilLogo()
    {
        $this->load->database();

        $data = $this->db->select('logo')->get('tbl_pengaturan')->row();
        return $data;
    }
}