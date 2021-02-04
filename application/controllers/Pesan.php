<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Pesan';
        $data['source_code_top'] = 'pesan/source-code-top';
        $data['content'] = 'pesan/content';
        $data['source_code_bottom'] = 'pesan/source-code-bottom';
        $data['pesan'] = 'active';
        $alert = $this->alert_array;
        $list_user = $this->Pesan_model->list_user();
        $no_pesan = $this->Pesan_model->no_pesan();

        if (!$_POST) {
            $input = (object) $this->Pesan_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'list_user', 'no_pesan', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post();
            $input->no_pesan = ltrim($input->no_pesan,"#");
        }

        if (!$this->Pesan_model->validate($input)) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'list_user', 'no_pesan', 'alert'));
            return;
        }

        if ($this->Pesan_model->tambahPesan($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pesan');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pesan');
    }

	public function replyPesan()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('pesan');
        }        

        if (!$this->Pesan_model->validateReplyPesan()) {    
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('pesan');
        }

        if ($this->Pesan_model->replyPesan($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pesan');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pesan');
    }

	public function isCekNoPesan($str)
	{
        $result = $this->db->query("SELECT DISTINCT no_pesan FROM tbl_pesan")->result_array(); 
        $no_pesan = ltrim($str,"#");

        $list_no_pesan = array();
        foreach ($result as $value) {
            array_push($list_no_pesan,$value['no_pesan']);
        }

        if (in_array($no_pesan, $list_no_pesan)) {
            $this->form_validation->set_message('isCekNoPesan', 'No. Pesan telah digunakan. Silahkan refresh kembali halaman Anda.');
            return false;
        }

        return true;        
    }

    // Proses ambil ID oleh Ajax
	public function lihatPesan()
	{
        $q = $this->input->post('no_pesannya');
        $data = $this->db->where('no_pesan', $q)->order_by('created_at', 'ASC')->get('tbl_pesan')->result_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_pesan_view';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'no_pesan',  
                   'dt' => 1,
                   'formatter' => function( $no_pesan ) { 
                        return '<span style="white-space: nowrap;">#' . $no_pesan . '</span>';
                    }    
                ),
            array( 'db' => 'user_pengirim',  
                   'dt' => 2,
                   'formatter' => function( $user_pengirim ) { 
                        return '<span style="white-space: nowrap;">' . $user_pengirim . '</span>';
                    }    
                ),
            array( 'db' => 'judul_pesan',  
                   'dt' => 3,
                   'formatter' => function( $judul_pesan ) { 
                        return '<span style="white-space: nowrap;">' . $judul_pesan . '</span>';
                    }    
                ),
            array( 'db' => 'created_at',  
                   'dt' => 4,
                   'formatter' => function( $created_at ) {                       
                        $this->load->helper('tanggal');
                        $format_tanggal = formatTanggalWaktu($created_at);
                        return '<span style="white-space: nowrap;">' . $format_tanggal . '</span>';
                    }
                ),
            array(
                'db' => 'no_pesan',
                'dt' => 5,
                'formatter' => function( $no_pesan ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$no_pesan.'" onclick="lihatPesan(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-pesan"><i class="fa fa-eye"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$no_pesan.'" onclick="balasPesan(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pesan"><i class="fa fa-mail-reply"></i></button></div>';
                }
            )
        );
 
        // SQL server connection information
        $sql_details = array(
            'user' => 'root',
            'pass' => '',
            'db'   => 'dbd_pos',
            'host' => 'localhost'
        ); 
 
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */
 
        require('ssp.class.php');
 
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }
}
