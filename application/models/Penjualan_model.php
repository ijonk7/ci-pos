<?php

class Penjualan_model extends MY_Model
{
    protected $table = 'tbl_penjualan';
    protected $table_detail = 'tbl_penjualan_detail';
    protected $table_notif = 'tbl_notifikasi';

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'value_input_kode_produk',
                'label' => 'Kode Produk',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'value_input_harga_beli',
                'label' => 'Harga Beli',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'value_input_sub_total',
                'label' => 'Sub Total',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'quantity',
                'label' => 'Kuantiti',
                'rules' => 'trim|numeric'
            ],
            [
                'field' => 'diskon',
                'label' => 'Diskon',
                'rules' => 'trim|numeric'
            ]
        ];

        return $validationRules;
    }

    public function getValidationRulesDelete()
    {
        $validationRules = [
            [
                'field' => 'hapus_id_penjualan',
                'label' => 'ID Penjualan',
                'rules' => 'trim|required|numeric'
            ]
        ];

        return $validationRules;
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<p style="color:white;">', '</p>');
        $validationRules = $this->getValidationRules();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function validateDelete()
    {
        $this->form_validation->set_error_delimiters('<p style="color:Tomato;">', '</p>');
        $validationRules = $this->getValidationRulesDelete();
        $this->form_validation->set_rules($validationRules);
        return $this->form_validation->run();
    }

    public function tambahPenjualan($input)
    {
        $data_pembelian_detail = array();
        $jumlah = count($input['value_input_kode_produk']);
        $total_item = 0;

        for ($j=0; $j < $jumlah; $j++) { 
            $total_item += $input["quantity"][$j];
        }
        
        $data_pembelian = array(
            'kode_member' => $input['kode_member'],
            'total_item' => $total_item,
            'total_harga' => preg_replace('/[Rp.]/','',$input['total_harga']),
            'diskon' => $input['diskon'],
            'bayar' => preg_replace('/[Rp.]/','',$input['total_bayar']),
            'diterima' => str_replace(".", "", $input['uang_diterima']),
            'id_user' => $this->session->userdata('id_user'),
            'created_at' => $this->waktu_sekarang,
            'updated_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->insert($this->table, $data_pembelian);
        $insert_id = $this->db->insert_id();

        for ($i=0; $i < $jumlah; $i++) { 
            array_push($data_pembelian_detail, array(
              'id_penjualan'=>$insert_id,
              'kode_produk' => $input["value_input_kode_produk"][$i],
              'harga_jual' => $input["value_input_harga_beli"][$i],  // Ambil dan set data nama sesuai index array dari $i
              'jumlah' => $input["quantity"][$i],  // Ambil dan set data telepon sesuai index array dari $i
              'diskon' => $input['diskon'],
              'sub_total' => $input["value_input_sub_total"][$i] - ($input["value_input_sub_total"][$i] * ($input['diskon'] / 100)),  // Ambil dan set data alamat sesuai index array dari $i
              'created_at' => $this->waktu_sekarang,
              'updated_at' => $this->waktu_sekarang
            ));        
            
            $stok_produk = $this->db->select('stok')->where('kode_produk', $input["value_input_kode_produk"][$i])->get('tbl_produk')->row_array();      
            $stok_produk['stok'] -= $input["quantity"][$i];
            $data = array(
                'stok' => $stok_produk['stok']
            );
            $this->db->where('kode_produk', $input["value_input_kode_produk"][$i]);
            $this->db->update('tbl_produk', $data);  
        }
        $this->db->insert_batch($this->table_detail, $data_pembelian_detail);        

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan penjualan dengan id',
            'objek' => $insert_id,
            'create' => 1,
            'created_at' => $this->waktu_sekarang
        );
        $this->db->insert($this->table_notif, $notifikasi);

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function deletePenjualan($input)
    {
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus penjualan dengan id',
            'objek' => $input->hapus_id_penjualan,
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();

        $detail_penjualan = $this->db->select('kode_produk, jumlah')->where('id_penjualan', $input->hapus_id_penjualan)->get('tbl_penjualan_detail')->result_array();
        $total_detail_penjualan = count($detail_penjualan);
        
        for ($i=0; $i < $total_detail_penjualan; $i++) { 
            $stok_produk = $this->db->select('stok')->where('kode_produk', $detail_penjualan[$i]["kode_produk"])->get('tbl_produk')->row_array();      
            $stok_produk['stok'] += $detail_penjualan[$i]["jumlah"];
            $data = array(
                'stok' => $stok_produk['stok']
            );
            $this->db->where('kode_produk', $detail_penjualan[$i]["kode_produk"]);
            $this->db->update('tbl_produk', $data);
        }

        $this->db->delete($this->table, array('id' => $input->hapus_id_penjualan));
        $this->db->insert($this->table_notif, $notifikasi);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}