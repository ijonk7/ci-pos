<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller 
{
	public function index()
	{
        $this->load->helper('date');
        
        $data['title'] = 'Dashboard';
        $data['source_code_top'] = 'dashboard/source-code-top';
        $data['content'] = 'dashboard/content';
        $data['source_code_bottom'] = 'dashboard/source-code-bottom';
        $data['dashboard'] = 'active';
        $alert = $this->alert_array;

        $total_permenu['kategori'] = $this->db->select('id')->count_all('tbl_kategori');
        $total_permenu['produk'] = $this->db->select('id')->count_all('tbl_produk');
        $total_permenu['supplier'] = $this->db->select('id')->count_all('tbl_supplier');
        $total_permenu['user'] = $this->db->select('id')->count_all('tbl_users');

        $tahun = date('Y'); //Mengambil tahun saat ini
        $bulan = date('m'); //Mengambil bulan saat ini
        $total_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        $tanggal_awal = $tahun . '-' . $bulan . '-01';
        $tanggal_akhir = $tahun . '-' . $bulan . '-' . $total_hari;
        $range = date_range($tanggal_awal, $tanggal_akhir);        

        $penjualan = $this->Dashboard_model->dataPenjualan($tanggal_awal, $tanggal_akhir);
        $total_penjualan = count($penjualan);
        $pembelian = $this->Dashboard_model->dataPembelian($tanggal_awal, $tanggal_akhir);
        $total_pembelian = count($pembelian);
        $pengeluaran = $this->Dashboard_model->dataPengeluaran($tanggal_awal, $tanggal_akhir);
        $total_pengeluaran = count($pengeluaran);       

        $laporan_umum = array();
        $index_umum = 0;
        $index_penjualan = 0;
        $index_pembelian = 0;
        $index_pengeluaran = 0;

        foreach ($range as $value) {
            $laporan_umum[$index_umum]['tanggal'] = $value;

            if ($index_penjualan < $total_penjualan) { 
                $buat_format = date_create($penjualan[$index_penjualan]['created_at']);
                if ($value == date_format($buat_format, "Y-m-d")) {
                    $laporan_umum[$index_umum]['penjualan'] = $penjualan[$index_penjualan]['bayar'];
                    $index_penjualan++;
                } else {
                    $laporan_umum[$index_umum]['penjualan'] = 0;
                }
            } else {
                $laporan_umum[$index_umum]['penjualan'] = 0;
            }

            if ($index_pembelian < $total_pembelian) { 
                $buat_format = date_create($pembelian[$index_pembelian]['created_at']);
                if ($value == date_format($buat_format, "Y-m-d")) {
                    $laporan_umum[$index_umum]['pembelian'] = $pembelian[$index_pembelian]['bayar'];
                    $index_pembelian++;
                } else {
                    $laporan_umum[$index_umum]['pembelian'] = 0;
                }
            } else {
                $laporan_umum[$index_umum]['pembelian'] = 0;
            }

            if ($index_pengeluaran < $total_pengeluaran) { 
                $buat_format = date_create($pengeluaran[$index_pengeluaran]['created_at']);
                if ($value == date_format($buat_format, "Y-m-d")) {
                    $laporan_umum[$index_umum]['pengeluaran'] = $pengeluaran[$index_pengeluaran]['nominal'];
                    $index_pengeluaran++;
                } else {
                    $laporan_umum[$index_umum]['pengeluaran'] = 0;
                }
            } else {
                $laporan_umum[$index_umum]['pengeluaran'] = 0;
            }

            $index_umum++;
        }

        $this->load->view('template', compact('data', 'alert', 'total_permenu', 'laporan_umum'));
    }
}
