<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Kategori';
        $data['source_code_top'] = 'kategori/source-code-top';
        $data['content'] = 'kategori/content';
        $data['source_code_bottom'] = 'kategori/source-code-bottom';
        $data['kategori'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = (object) $this->Kategori_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->Kategori_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        }

        if ($this->Kategori_model->tambahKategori($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('kategori');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('kategori');
    }

	public function update()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('kategori');
        }        

        if (!$this->Kategori_model->validateUpdate($input)) {    
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('kategori');
        }

        if ($this->Kategori_model->simpanKategori($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('kategori');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('kategori');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('kategori');
        }        

        if (!$this->Kategori_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('kategori');
        }

        if ($this->Kategori_model->deleteKategori($input)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            redirect('kategori');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('kategori');
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');
        $data = $this->db->where('id', $q)->get('tbl_kategori')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_kategori';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'nama_kategori',  
                   'dt' => 1,
                   'formatter' => function( $nama_kategori ) { 
                        return '<span style="white-space: nowrap;">' . $nama_kategori . '</span>';
                    }    
                ),
            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-kategori"><i class="fa fa-pencil"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-kategori"><i class="fa fa-trash"></i></button></div>';
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
