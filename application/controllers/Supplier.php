<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Supplier';
        $data['source_code_top'] = 'supplier/source-code-top';
        $data['content'] = 'supplier/content';
        $data['source_code_bottom'] = 'supplier/source-code-bottom';
        $data['supplier'] = 'active';
        $alert = $this->alert_array;

        if (!$_POST) {
            $input = (object) $this->Supplier_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->Supplier_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        }

        if ($this->Supplier_model->tambahSupplier($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('supplier');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('supplier');
    }

	public function update()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('supplier');
        }        

        if (!$this->Supplier_model->validateUpdate($input)) {    
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('supplier');
        }

        if ($this->Supplier_model->simpanSupplier($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('supplier');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('supplier');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('supplier');
        }        

        if (!$this->Supplier_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('supplier');
        }

        if ($this->Supplier_model->deleteSupplier($input)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            redirect('supplier');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('supplier');
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');
        $data = $this->db->where('id', $q)->get('tbl_supplier')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_supplier';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'nama',  
                   'dt' => 1,
                   'formatter' => function( $nama ) { 
                        return '<span style="white-space: nowrap;">' . $nama . '</span>';
                    }    
                ),
            array( 'db' => 'alamat',  
                   'dt' => 2,
                   'formatter' => function( $alamat ) { 
                        return '<span style="white-space: nowrap;">' . $alamat . '</span>';
                    }    
                ),
            array( 'db' => 'telepon',  
                   'dt' => 3,
                   'formatter' => function( $telepon ) { 
                        return '<span style="white-space: nowrap;">' . $telepon . '</span>';
                    }    
                ),
            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-supplier"><i class="fa fa-pencil"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-supplier"><i class="fa fa-trash"></i></button></div>';
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
