<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Notifikasi';
        $data['source_code_top'] = 'notifikasi/source-code-top';
        $data['content'] = 'notifikasi/content';
        $data['source_code_bottom'] = 'notifikasi/source-code-bottom';
        $data['notifikasi'] = 'active';
        $alert = $this->alert_array;

        $this->load->view('template', compact('data', 'alert'));
        return;
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_notifikasi_view';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'created_at',  
                   'dt' => 1,
                   'formatter' => function( $created_at ) {                       
                        $this->load->helper('tanggal');
                        $format_tanggal = formatTanggalLengkap($created_at);
                        return '<span style="white-space: nowrap;">' . $format_tanggal . '</span>';
                    }    
                ),
            array( 'db' => 'pesan',  
                   'dt' => 2,
                   'formatter' => function( $created_by ) { 
                        return '<span style="white-space: nowrap;">' . $created_by . '</span>';
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
