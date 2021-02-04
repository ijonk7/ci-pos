<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengeluaran extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Pengeluaran';
        $data['source_code_top'] = 'pengeluaran/source-code-top';
        $data['content'] = 'pengeluaran/content';
        $data['source_code_bottom'] = 'pengeluaran/source-code-bottom';
        $data['pengeluaran'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = (object) $this->Pengeluaran_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->Pengeluaran_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        }

        if ($this->Pengeluaran_model->tambahPengeluaran($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pengeluaran');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pengeluaran');
    }

	public function update()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('pengeluaran');
        }        

        if (!$this->Pengeluaran_model->validateUpdate($input)) {    
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('pengeluaran');
        }

        if ($this->Pengeluaran_model->simpanPengeluaran($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pengeluaran');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pengeluaran');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('pengeluaran');
        }        

        if (!$this->Pengeluaran_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('pengeluaran');
        }

        if ($this->Pengeluaran_model->deletePengeluaran($input)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            redirect('pengeluaran');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('pengeluaran');
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');
        $data = $this->db->where('id', $q)->get('tbl_pengeluaran')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_pengeluaran';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'jenis_pengeluaran',  
                   'dt' => 1,
                   'formatter' => function( $jenis_pengeluaran ) { 
                        return '<span style="white-space: nowrap;">' . $jenis_pengeluaran . '</span>';
                    }    
                ),
            array( 'db' => 'nominal',  
                   'dt' => 2,
                   'formatter' => function( $nominal ) { 
                        $format_nominal = number_format($nominal,0,",",".");
                        return $format_nominal;
                    }    
                ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-pengeluaran"><i class="fa fa-pencil"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pengeluaran"><i class="fa fa-trash"></i></button></div>';
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
