<?php

class Pesan_model extends MY_Model
{
    protected $table = 'tbl_pesan';  

    public function getDefaultValues()
    {
        return [
            'judul_pesan' => '',
            'isi_pesan' => ''
        ];
    }

    public function getValidationRules($input)
    {
        $validationRules = [
            [
                'field' => 'no_pesan',
                'label' => 'No Pesan',
                'rules' => 'trim|required|callback_isCekNoPesan'
            ],
            [
                'field' => 'user_penerima',
                'label' => 'User Penerima',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'judul_pesan',
                'label' => 'Judul Pesan',
                'rules' => 'trim|required|max_length[256]'
            ],
            [
                'field' => 'isi_pesan',
                'label' => 'Isi Pesan',
                'rules' => 'trim|required'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesUpdate()
    {
        $validationRules = [
            [
                'field' => 'reply_no_pesan',
                'label' => 'No Pesan 2',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'reply_user_penerima',
                'label' => 'User Penerima',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'reply_judul_pesan',
                'label' => 'Judul Pesan',
                'rules' => 'trim|required|max_length[256]'
            ],
            [
                'field' => 'reply_isi_pesan',
                'label' => 'Isi Pesan',
                'rules' => 'trim|required'
            ]
        ];

        return $validationRules;
    }

    public function validate($input)
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRules($input);
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function validateReplyPesan()
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRulesUpdate();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function list_user()
    {
        $data = $this->db->select('username')->get('tbl_users')->result_array();
        return $data;
    }

    public function no_pesan()
    {
        $data = $this->db->select('no_pesan')->order_by('no_pesan', 'DESC')->get('tbl_pesan')->row_array();
        return $data;
    }

    public function tambahPesan($input)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data_pesan = array(
            'no_pesan' => $input->no_pesan,
            'judul_pesan' => $input->judul_pesan,
            'isi_pesan' => $input->isi_pesan,
            'user_pengirim' => $this->session->userdata('username'),
            'user_penerima' => $input->user_penerima,
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert($this->table, $data_pesan);

        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function replyPesan($input)
    {
        date_default_timezone_set('Asia/Jakarta');

        $data_pesan = array(
            'no_pesan' => ltrim($input->reply_no_pesan,"#"),
            'judul_pesan' => $input->reply_judul_pesan,
            'isi_pesan' => $input->reply_isi_pesan,
            'user_pengirim' => $this->session->userdata('username'),
            'user_penerima' => $input->reply_user_penerima,
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert($this->table, $data_pesan);

        return ($this->db->affected_rows() != 1) ? false : true;
    }
}