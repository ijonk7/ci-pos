<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembelian extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Pembelian';
        $data['source_code_top'] = 'pembelian/source-code-top';
        $data['content'] = 'pembelian/content';
        $data['source_code_bottom'] = 'pembelian/source-code-bottom';
        $data['pembelian'] = 'active';
        $data['daftar_supplier'] = $this->db->get('tbl_supplier')->result_array();
        $alert = $this->alert_array;

        if (!$_POST) {
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        redirect('pembelian');
    }

	public function tambah($id = null)
	{
        $data['title'] = 'Pembelian';
        $data['source_code_top'] = 'pembelian/source-code-top';
        $data['content'] = 'pembelian/content-tambah';
        $data['source_code_bottom'] = 'pembelian/source-code-bottom-detail';
        $data['pembelian'] = 'active';
        $data['daftar_supplier'] = $this->db->where('id', $id)->get('tbl_supplier')->result_array();
        $data['daftar_produk'] = $this->db->get('tbl_produk')->result_array();

        if (!$_POST) {
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        } else {
            $input = $this->input->post(null, true);
        }

        if (!$this->Pembelian_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'alert'));
            return;
        }

        if ($this->Pembelian_model->tambahPembelian($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('pembelian');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('pembelian');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('pembelian');
        }        

        if (!$this->Pembelian_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('pembelian');
        }

        if ($this->Pembelian_model->deletePembelian($input)) {
            $this->session->set_flashdata('success', 'Data berhasil dihapus.');
            redirect('pembelian');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('pembelian');
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');

        $sql = "SELECT tbl_penjualan_detail.kode_produk, tbl_produk.nama_produk, tbl_penjualan_detail.harga_jual, tbl_penjualan_detail.jumlah, tbl_penjualan_detail.sub_total
        FROM tbl_penjualan_detail
        LEFT JOIN tbl_produk ON tbl_penjualan_detail.kode_produk = tbl_produk.kode_produk
        WHERE tbl_penjualan_detail.id_penjualan = $q";

        $data = $this->db->query($sql)->result_array();
        
        echo json_encode($data);
    }

    // Proses ambil ID oleh Ajax
	public function ambilDataProduk($id_produk)
	{
        $data = $this->db->where('id', $id_produk)->get('tbl_produk')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil ID oleh Ajax
	public function ambilDataProduk2($inputan_kode_produk)
	{
        $data = $this->db->where('kode_produk', $inputan_kode_produk)->get('tbl_produk')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        // $table = 'tbl_penjualan';

        $table = <<<EOT
 (
    SELECT 
    tbl_pembelian.id, 
    tbl_pembelian.created_at,
    tbl_supplier.nama,
    tbl_pembelian.total_item,
    tbl_pembelian.total_harga,
    tbl_pembelian.diskon,
    tbl_pembelian.bayar
    FROM tbl_pembelian
    LEFT JOIN tbl_supplier ON tbl_pembelian.id_supplier = tbl_supplier.id
 ) temp
EOT;
 
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
            array( 'db' => 'nama', 'dt' => 2),
            array( 'db' => 'total_item', 
                   'dt' => 3,
                   'formatter' => function( $kode_member ) { 
                        $format_kode_member = number_format($kode_member,0,",",".");
                        return $format_kode_member;
                    }
                ),
            array( 'db' => 'total_harga', 
                   'dt' => 4,
                   'formatter' => function( $total_harga ) { 
                        $format_total_harga = number_format($total_harga,0,",",".");
                        return 'Rp '.$format_total_harga;
                    }
                ),
            array( 'db' => 'diskon',  
                   'dt' => 5,
                   'formatter' => function( $diskon ) {                        
                        return $diskon.'%';
                    }
                ),
            array( 'db' => 'bayar', 
                   'dt' => 6,
                   'formatter' => function( $bayar ) { 
                        $format_bayar = number_format($bayar,0,",",".");
                        return 'Rp '.$format_bayar;
                    }
                ),
            array(
                'db' => 'id',
                'dt' => 7,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-pembelian"><i class="fa fa-eye"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pembelian"><i class="fa fa-trash"></i></button></div>';
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

    // Proses ambil data oleh Datatables
	public function dtl_pembelian_serverside($id_pembeliannya)
	{
        // DB table to use
        // $table = 'tbl_pembelian';

        $table = <<<EOT
 (
    SELECT tbl_pembelian_detail.id, tbl_pembelian_detail.kode_produk, tbl_produk.nama_produk, tbl_pembelian_detail.harga_beli, tbl_pembelian_detail.jumlah, tbl_pembelian_detail.sub_total
    FROM tbl_pembelian_detail
    LEFT JOIN tbl_produk ON tbl_pembelian_detail.kode_produk = tbl_produk.kode_produk
    WHERE tbl_pembelian_detail.id_pembelian = $id_pembeliannya
 ) temp
EOT;
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id', 'dt' => 0 ),
            array( 'db' => 'kode_produk', 'dt' => 1),
            array( 'db' => 'nama_produk', 'dt' => 2),
            array( 'db' => 'harga_beli', 
                   'dt' => 3,
                   'formatter' => function( $harga_jual ) { 
                        $format_harga_jual = number_format($harga_jual,0,",",".");
                        return 'Rp '.$format_harga_jual;
                    }
                ),
            array( 'db' => 'jumlah', 'dt' => 4),
            array( 'db' => 'sub_total', 
                   'dt' => 5,
                   'formatter' => function( $sub_total ) { 
                        $format_sub_total = number_format($sub_total,0,",",".");
                        return 'Rp '.$format_sub_total;
                    }
                ),
            array(
                'db' => 'id',
                'dt' => 6,
                'formatter' => function( $id ) {
                    return '<div class="btn-group" style="white-space: nowrap;">
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-pembelian"><i class="fa fa-eye"></i></button>
                    <button type="button" style="float: none; display: inline-block;" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pembelian"><i class="fa fa-trash"></i></button></div>';
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
