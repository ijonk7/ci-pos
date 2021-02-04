<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller 
{
	public function index()
	{
        $data['title'] = 'Produk';
        $data['source_code_top'] = 'produk/source-code-top';
        $data['content'] = 'produk/content';
        $data['source_code_bottom'] = 'produk/source-code-bottom';
        $data['produk'] = 'active';
        $alert = $this->alert_array;

        $list_menu = $this->Produk_model->ambilKategori();

        if (!$_POST) {
            $input = (object) $this->Produk_model->getDefaultValues();
            $this->load->view('template', compact('data', 'input', 'list_menu', 'alert'));
            return;
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->Produk_model->validate()) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            $this->load->view('template', compact('data', 'input', 'list_menu', 'alert'));
            return;
        }

        if ($this->Produk_model->tambahProduk($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('produk');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('produk');
    }
    
    public function pdfBarcode()
    {   
        $mpdf = new mPDF();
        $input = $this->input->post(null, true);
        $array_list_barcode = $this->barcode($input);

        $html = $this->load->view('produk/cetak_barcode', compact('array_list_barcode'),true);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function barcode($input)
    {
        //load library
        $this->load->library('zend');
        //load in folder Zend
        $this->zend->load('Zend/Barcode');

        $list_array_barcode = explode(",",$input['cetak_barcode']);
        $list_barcode = (array_filter($list_array_barcode, function($value) { return $value !== ''; }));

        $list_kode_produk = $this->db->select('kode_produk, nama_produk, harga_jual')->where_in('id', $list_barcode)->get('tbl_produk')->result_array();

        $total_kode_produk = count($list_kode_produk);

        for ($x = 0; $x < $total_kode_produk; $x++) {
            //generate barcode
            $file = Zend_Barcode::draw('code128', 'image', array('text'=>$list_kode_produk[$x]['kode_produk'], 'barHeight' => 25, 'factor'=>1.98), array());
    
            $nama_barcode = time().$list_kode_produk[$x]['kode_produk'];
            $store_image = imagepng($file,"assets/dist/img/barcode/{$nama_barcode}.png");
            $list_kode_produk[$x]['nama_gambar'] = $nama_barcode.'.png';
        }
        return $list_kode_produk;
    }

	public function update()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('produk');
        }        

        if (!$this->Produk_model->validateUpdate($input)) {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
            $this->session->set_flashdata('error_field', validation_errors());
            redirect('produk');
        }

        if ($this->Produk_model->simpanProduk($input)) {
            $this->session->set_flashdata('success', 'Data berhasil disimpan.');
            redirect('produk');
        } else {
            $this->session->set_flashdata('error', 'Data gagal disimpan.');
        }

        redirect('produk');
    }

	public function delete()
	{
        if ($_POST) {
            $input = (object) $this->input->post(null, true);
        } else {
            redirect('produk');
        }        

        if (!$this->Produk_model->validateDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('produk');
        }

        if ($this->Produk_model->deleteProduk($input)) {
            $this->session->set_flashdata('success', '1 Data berhasil dihapus.');
            redirect('produk');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('produk');
    }

	public function deleteMultiple()
	{
        if ($_POST) {
            $input = $this->input->post(null, true);
        } else {
            redirect('produk');
        }

        if (!$this->Produk_model->validateMultipleDelete()) {    
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
            redirect('produk');
        }
        
        $data = explode(",",$input['hapus_multiple_id_produk'], -1);

        if ($this->Produk_model->deleteMultipleProduk($data)) {
            $jumlah_data = count($data);
            $this->session->set_flashdata('success', $jumlah_data . ' Data berhasil dihapus.');
            redirect('produk');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus.');
        }

        redirect('produk');
    }

    // Proses ambil ID oleh Ajax
	public function ambilData()
	{
        $q = $this->input->post('id');
        $data = $this->db->where('id', $q)->get('tbl_produk')->row_array();
        
        echo json_encode($data);
    }

    // Proses ambil data oleh Datatables
	public function serverside_processing()
	{
        // DB table to use
        $table = 'tbl_produk';
 
        // Table's primary key
        $primaryKey = 'id';
 
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        $columns = array(
            array( 'db' => 'id',
                   'dt' => 0,
                   'formatter' => function( $id ) {
                        return '<input type="checkbox" value="'.$id.'" name="checked_delete[]" id="checked_delete">';
                }
            ),
            array( 'db' => 'id', 'dt' => 1 ),
            array( 'db' => 'kode_produk',  'dt' => 2 ),
            array( 'db' => 'nama_produk',  
                   'dt' => 3,
                   'formatter' => function( $nama_produk ) { 
                        return '<span style="white-space: nowrap;">' . $nama_produk . '</span>';
                    }                
                ),
            array( 'db' => 'id_kategori',  
                   'dt' => 4,            
                   'formatter' => function( $id ) {       
                        if (is_null($id)) {
                            return '<span style="white-space: nowrap;"></span>';
                        } else {
                            $query = $this->db->select('nama_kategori')->where('id', $id)->get('tbl_kategori')->result();
                            $nama_kategori = array();
                            foreach ($query as $row)
                            {
                                $nama_kategori = $row->nama_kategori;
                            }
                            return '<span style="white-space: nowrap;">' . $nama_kategori . '</span>';
                        }
                                        
                    }
                ),
            array( 'db' => 'merk',  
                   'dt' => 5,
                   'formatter' => function( $merk ) { 
                        return '<span style="white-space: nowrap;">' . $merk . '</span>';
                    }
                ),
            array( 'db' => 'harga_beli',
                   'dt' => 6,
                   'formatter' => function( $harga_beli ) { 
                        $format_harga_beli = number_format($harga_beli,0,",",".");
                        return 'Rp '.$format_harga_beli;
                    }
                ),
            array( 'db' => 'harga_jual',  
                   'dt' => 7,
                   'formatter' => function( $harga_jual ) { 
                        $format_harga_jual = number_format($harga_jual,0,",",".");
                        return 'Rp '.$format_harga_jual;
                    }
                ),
            array( 'db' => 'diskon',  
                   'dt' => 8,
                   'formatter' => function( $diskon ) {                        
                        return $diskon.'%';
                    }
                ),
            array( 'db' => 'stok',  'dt' => 9 ),
            array( 'db' => 'id',
                   'dt' => 10,
                   'formatter' => function( $id ) {
                       return '<div class="btn-group" style="white-space: nowrap;">
                       <button style="float: none; display: inline-block;" type="button" value="'.$id.'" onclick="ambilData(this.value)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#edit-produk"><i class="fa fa-pencil"></i></button>
                       <button style="float: none; display: inline-block;" type="button" value="'.$id.'" onclick="hapusData(this.value)"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-produk"><i class="fa fa-trash"></i></button></div>';
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
