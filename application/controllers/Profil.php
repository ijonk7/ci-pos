<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Profil';
        $data['source_code_top'] = 'profil/source-code-top';
        $data['content'] = 'profil/content';
        $data['source_code_bottom'] = 'profil/source-code-bottom';
        $data['profil'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = $this->Profil_model->ambilFoto();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = $this->input->post(null, true);
        }
        
        $config['upload_path']          = './assets/images/foto-profil/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 215;
        $config['max_height']           = 215;

        $this->load->library('upload', $config);

        if (!empty($input['password_lama']) or !empty($input['password_baru']) or !empty($input['konfirmasi_password_baru'])) {
            if (!$this->Profil_model->validateUpdate()) {
                // Memeriksa apakah ada file tertentu yang sudah diupload
                if ($_FILES['foto_profil']['error'] !== 4) {
                    if (!$this->upload->do_upload('foto_profil'))
                    {
                        $gagal_upload = array('error' => $this->upload->display_errors());
                    }
                }

                $input = $this->Profil_model->ambilFoto();
                $error_validasi = 'Data gagal disimpan.';
                $this->load->view('template', compact('data', 'input', 'gagal_upload', 'error_validasi', 'alert'));
                return;
            }
        }
        
        $data_upload='';

        // Memeriksa apakah ada file tertentu yang sudah diupload
        if ($_FILES['foto_profil']['error'] !== 4) {
            if (!$this->upload->do_upload('foto_profil')){
                $input = $this->Profil_model->ambilFoto();
                $gagal_upload = array('error' => $this->upload->display_errors());
                $error_validasi = 'Data gagal disimpan.';
                $this->load->view('template', compact('data', 'input', 'gagal_upload', 'error_validasi', 'alert'));
                return;
            } else {
                $data_upload = array('foto' => $this->upload->data());
            }
        }

        if ($this->Profil_model->simpanProfil($input, $data_upload)) {
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
            $this->session->set_flashdata('success', 'Data berhasil disimpan. Silahkan login kembali.');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('profil');
    }

	public function cekPasswordLama($str)
	{
        $password_lama = $this->Profil_model->ambilpassword();

        if (password_verify($str, $password_lama['password'])) {
            return true;
        } else {
            $this->form_validation->set_message('cekPasswordLama', 'Password lama tidak sesuai.');
            return false;
        }
    }
}
