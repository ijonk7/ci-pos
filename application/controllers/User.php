<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller 
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
        $data['title'] = 'User';
        $data['source_code_top'] = 'user/source-code-top';
        $data['content'] = 'user/content';
        $data['source_code_bottom'] = 'user/source-code-bottom';
        $data['user'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = (object) $this->User_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->User_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        }

        if ($this->User_model->tambahUser($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('user');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('user');
    }

	public function update()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('user');
        }        

        if (!$this->User_model->validateUpdate()) {    
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('user');
        }

        if ($this->User_model->simpanUser($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('user');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('user');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('user');
        }        

        if (!$this->User_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('user');
        }

        if ($this->User_model->deleteUser($input)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            redirect('user');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('user');
    }

	public function cekUsernameUnik($str)
	{
        $hasil = $this->User_model->ambil_username_unik($str);
        $total_user = count($hasil);

        if ($total_user === 0) {
            return true;
        } else {
            $this->form_validation->set_message('cekUsernameUnik', 'Username harus unik.');
            return false;
        }
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');
        $data = $this->db->where('id', $q)->get('tbl_users')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_users';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'nama', 'dt' => 1),
            array( 'db' => 'email', 'dt' => 2),
            array( 
                'db' => 'id',
                'dt' => 3,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-user"><i class="fa fa-pencil"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-user"><i class="fa fa-trash"></i></button></div>';
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
