<?php

class Pembelian_model extends MY_Model
{
    protected $table = 'tbl_pembelian';
    protected $table_detail = 'tbl_pembelian_detail';
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
                'field' => 'hapus_id_pembelian',
                'label' => 'ID Pembelian',
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

    public function tambahPembelian($input)
    {
        $data_pembelian_detail = array();
        $jumlah = count($input['value_input_kode_produk']);
        $total_item = 0;

        for ($j=0; $j < $jumlah; $j++) { 
            $total_item += $input["quantity"][$j];
        }
        
        $data_pembelian = array(
            'id_supplier' => $input['id_supplier'],
            'total_item' => $total_item,
            'total_harga' => preg_replace('/[Rp.]/','',$input['total_harga']),
            'diskon' => $input['diskon'],
            'bayar' => preg_replace('/[Rp.]/','',$input['total_bayar']),
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();
        $this->db->insert($this->table, $data_pembelian);
        $insert_id = $this->db->insert_id();
        
        for ($i=0; $i < $jumlah; $i++) { 
            array_push($data_pembelian_detail, array(
              'id_pembelian'=>$insert_id,
              'kode_produk' => $input["value_input_kode_produk"][$i],
              'harga_beli' => $input["value_input_harga_beli"][$i],  // Ambil dan set data nama sesuai index array dari $i
              'jumlah' => $input["quantity"][$i],  // Ambil dan set data telepon sesuai index array dari $i
              'sub_total' => $input["value_input_sub_total"][$i],  // Ambil dan set data alamat sesuai index array dari $i
              'created_at' => $this->waktu_sekarang
            ));    
            
            $stok_produk = $this->db->select('stok')->where('kode_produk', $input["value_input_kode_produk"][$i])->get('tbl_produk')->row_array();      
            $stok_produk['stok'] += $input["quantity"][$i];
            $data = array(
                'stok' => $stok_produk['stok']
            );
            $this->db->where('kode_produk', $input["value_input_kode_produk"][$i]);
            $this->db->update('tbl_produk', $data);
        }
        $this->db->insert_batch($this->table_detail, $data_pembelian_detail);        

        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menambahkan pembelian dengan id',
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

    public function deletePembelian($input)
    {
        $notifikasi = array(
            'created_by' => $this->session->userdata('username'),
            'subjek' => 'menghapus pembelian dengan id',
            'objek' => $input->hapus_id_pembelian,
            'delete' => 1,
            'created_at' => $this->waktu_sekarang
        );

        $this->db->trans_begin();

        $detail_pembelian = $this->db->select('kode_produk, jumlah')->where('id_pembelian', $input->hapus_id_pembelian)->get('tbl_pembelian_detail')->result_array();
        $total_detail_pembelian = count($detail_pembelian);
        
        for ($i=0; $i < $total_detail_pembelian; $i++) { 
            $stok_produk = $this->db->select('stok')->where('kode_produk', $detail_pembelian[$i]["kode_produk"])->get('tbl_produk')->row_array();      
            $stok_produk['stok'] -= $detail_pembelian[$i]["jumlah"];
            $data = array(
                'stok' => $stok_produk['stok']
            );
            $this->db->where('kode_produk', $detail_pembelian[$i]["kode_produk"]);
            $this->db->update('tbl_produk', $data);
        }

        $this->db->delete($this->table, array('id' => $input->hapus_id_pembelian));
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