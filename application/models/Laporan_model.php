<?php

class Laporan_model extends MY_Model
{
    public function dataPenjualan($tanggal_awal, $tanggal_akhir)
    {
        $data_penjualan = $this->db->select('created_at, SUM(bayar) as bayar')
                                   ->where('created_at >=', $tanggal_awal . ' 00:00:00')
                                   ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
                                   ->group_by('date(created_at)')
                                   ->order_by('created_at', 'ASC')
                                   ->get('tbl_penjualan')
                                   ->result_array();
        return $data_penjualan;
    }

    public function dataPembelian($tanggal_awal, $tanggal_akhir)
    {
        $data_pembelian = $this->db->select('created_at, SUM(bayar) as bayar')
                                   ->where('created_at >=', $tanggal_awal . ' 00:00:00')
                                   ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
                                   ->group_by('date(created_at)')
                                   ->order_by('created_at', 'ASC')
                                   ->get('tbl_pembelian')
                                   ->result_array();
        return $data_pembelian;
    }

    public function dataPengeluaran($tanggal_awal, $tanggal_akhir)
    {
        $data_pengeluaran = $this->db->select('created_at, SUM(nominal) as nominal')
                                     ->where('created_at >=', $tanggal_awal . ' 00:00:00')
                                     ->where('created_at <=', $tanggal_akhir . ' 23:59:59')
                                     ->group_by('date(created_at)')
                                     ->order_by('created_at', 'ASC')
                                     ->get('tbl_pengeluaran')
                                     ->result_array();
        return $data_pengeluaran;
    }
}