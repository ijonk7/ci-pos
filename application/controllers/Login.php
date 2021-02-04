<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model('Login_model');
    }

	public function index()
	{

        if (!$_POST) {
            $input = (object) $this->Login_model->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->Login_model->validate()) {
            $logo = $this->Login_model->ambilLogo();
            $this->load->view('login/login', compact('input', 'logo'));
            return;
        }

        if ($this->Login_model->run($input)) {
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah, atau akun anda sedang diblokir.');
        }

        redirect(base_url());
	}

	public function logout()
	{
        $data = [
            'id_user' => null,
            'username' => null,
            'sudah_login' => null,
            'nama' => null,
            'jabatan' => null,
            'foto' => null,
            'level' => null,
            'created_at' => null,
            'total_pesan' => null,
            'total_notifikasi' => null
        ];
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect(base_url());
	}
}
