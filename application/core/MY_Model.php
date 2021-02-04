<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model 
{
    public function klik_pesan_teakhir()
    {
        $data = $this->db->select('klik_pesan')->where('id', $this->session->userdata('id_user'))->get('tbl_users')->row_array();
        return $data['klik_pesan'];
    }
    public function klik_notifikasi_teakhir()
    {
        $data = $this->db->select('klik_notifikasi')->where('id', $this->session->userdata('id_user'))->get('tbl_users')->row_array();
        return $data['klik_notifikasi'];
    }

    public function list_pesan()
    {
        $data = $this->db->where('created_at >=', $this->klik_pesan_teakhir())->order_by('created_at', 'DESC')->get('tbl_pesan')->result_array();
        return $data;
    }

    public function list_notifikasi()
    {
        $data = $this->db->where('created_at >=', $this->klik_notifikasi_teakhir())->order_by('created_at', 'DESC')->get('tbl_notifikasi')->result_array();
        return $data;
    }
}
