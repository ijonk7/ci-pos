<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends Admin_Controller 
{
	public function __construct()
	{
        parent::__construct();
        
        $level = $this->session->userdata('level'); 
        if ($level !== 'admin') 
        {
            redirect(base_url());
            return;
        }
    }
    
	public function index()
	{
        $data['title'] = 'Pengaturan';
        $data['source_code_top'] = 'pengaturan/source-code-top';
        $data['content'] = 'pengaturan/content';
        $data['source_code_bottom'] = 'pengaturan/source-code-bottom';
        $data['pengaturan'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = $this->Pengaturan_model->ambilData();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = $this->input->post(null, true);
        }
        
        $config['upload_path']          = './assets/images/logo/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 200;
        $config['max_height']           = 82;

        $this->load->library('upload', $config);

        if (!$this->Pengaturan_model->validateUpdate()) {
            // Memeriksa apakah ada file tertentu yang sudah diupload
            if ($_FILES['logo_perusahaan']['error'] !== 4) {
                if (!$this->upload->do_upload('logo_perusahaan'))
                {
                    $gagal_upload = array('error' => $this->upload->display_errors());
                }
            }

            $input['logo'] = $this->Pengaturan_model->ambilLogo();
            $error_validasi = 'Data gagal disimpan.';
            $this->load->view('template', compact('data', 'input', 'gagal_upload', 'error_validasi', 'alert'));
            return;
        }
        
        // Memeriksa apakah ada file tertentu yang sudah diupload
        if ($_FILES['logo_perusahaan']['error'] !== 4) {
            if (!$this->upload->do_upload('logo_perusahaan')){
                $input['logo'] = $this->Pengaturan_model->ambilLogo();
                $gagal_upload = array('error' => $this->upload->display_errors());
                $error_validasi = 'Data gagal disimpan.';
                $this->load->view('template', compact('data', 'input', 'gagal_upload', 'error_validasi', 'alert'));
                return;
            } else {
                $data_upload = array('logo' => $this->upload->data());
            }
        }

        if ($this->Pengaturan_model->simpanPengaturan($input, $data_upload)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pengaturan');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pengaturan');
    }
}
