<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public $nama_controller;
    public $nama_model;
    public $alert_array;
    public $waktu_sekarang;

	public function __construct()
	{
        parent::__construct();

        $is_login = $this->session->userdata('sudah_login');
        if (!$is_login) 
        {
            redirect(base_url());
            return;
        }

        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('tanggal');

        $this->nama_model = ucfirst(get_class($this));
        if (file_exists(APPPATH . 'models/' . $this->nama_model . '_model.php')) 
        {
            $this->load->model($this->nama_model . '_model', '', true);
        }
        
        $this->nama_controller = strtolower(get_class($this));
        $this->waktu_sekarang = date('Y-m-d H:i:s');

        $this->alert_array['list_pesan'] = $this->{$this->nama_model.'_model'}->list_pesan();
        $this->alert_array['total_pesan'] = count($this->alert_array['list_pesan']);
        if ($this->alert_array['total_pesan'] > 0) 
        {          
            $this->session->set_userdata('total_pesan', $this->alert_array['total_pesan']);
        }

        $this->alert_array['list_notifikasi'] = $this->{$this->nama_model.'_model'}->list_notifikasi();
        $this->alert_array['total_notifikasi'] = count($this->alert_array['list_notifikasi']);        
        if ($this->alert_array['total_notifikasi'] > 0) 
        {
            $this->session->set_userdata('total_notifikasi', $this->alert_array['total_notifikasi']);
        }
    }

    public function kosongkan_pesan()
	{
        $this->session->unset_userdata('total_pesan');        
        $this->db->update('tbl_users', array('klik_pesan' => $this->waktu_sekarang), array('id' => $this->session->userdata('id_user')));
        return true;
    }

	public function kosongkan_notifikasi()
	{
        $this->session->unset_userdata('total_notifikasi');        
        $this->db->update('tbl_users', array('klik_notifikasi' => $this->waktu_sekarang), array('id' => $this->session->userdata('id_user')));
        return true;
    }
}
