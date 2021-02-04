<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends MY_Controller 
{
	public function __construct()
	{
        parent::__construct();

        $this->load->library('Pdf');
        $this->load->helper('date');
    }

	public function index()
	{
        if ($_GET) {
            $data_waktu = $this->input->get(NULL, TRUE);

            $data['title'] = 'Laporan';
            $data['source_code_top'] = 'laporan/source-code-top';
            $data['content'] = 'laporan/content';
            $data['source_code_bottom'] = 'laporan/source-code-bottom';
            $data['laporan'] = 'active';
            $alert = $this->alert_array;

            $tanggal_awal = $data_waktu['tahun'].'-'.$data_waktu['bulan'].'-01';
            $tanggal_akhir = $data_waktu['tahun'].'-'.$data_waktu['bulan'].'-'.$data_waktu['total_hari'];
            $range = date_range($tanggal_awal, $tanggal_akhir);

            $penjualan = $this->Laporan_model->dataPenjualan($tanggal_awal, $tanggal_akhir);
            $total_penjualan = count($penjualan);
            $pembelian = $this->Laporan_model->dataPembelian($tanggal_awal, $tanggal_akhir);
            $total_pembelian = count($pembelian);
            $pengeluaran = $this->Laporan_model->dataPengeluaran($tanggal_awal, $tanggal_akhir);
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

            $this->load->view('template', compact('data', 'laporan_umum', 'alert', 'range'));
            return;
        }
    }

	public function filter()
	{
        if ($_POST) {        
            $input = $this->input->post(null, true);
            
            $data['title'] = 'Laporan';
            $data['source_code_top'] = 'laporan/source-code-top';
            $data['content'] = 'laporan/content';
            $data['source_code_bottom'] = 'laporan/source-code-bottom';
            $data['laporan'] = 'active';
            $alert = $this->alert_array;
            
            $format_tanggal_awal = date_create($input['tanggal_awal']);
            $tanggal_awal = date_format($format_tanggal_awal,"Y-m-d");
            $format_tanggal_akhir = date_create($input['tanggal_akhir']);
            $tanggal_akhir = date_format($format_tanggal_akhir,"Y-m-d");
            $range = date_range($tanggal_awal, $tanggal_akhir);

            $penjualan = $this->Laporan_model->dataPenjualan($tanggal_awal, $tanggal_akhir);
            $total_penjualan = count($penjualan);
            $pembelian = $this->Laporan_model->dataPembelian($tanggal_awal, $tanggal_akhir);
            $total_pembelian = count($pembelian);
            $pengeluaran = $this->Laporan_model->dataPengeluaran($tanggal_awal, $tanggal_akhir);
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

            $this->load->view('template', compact('data', 'laporan_umum', 'range', 'input', 'alert'));
            return;
        }
    }

	public function pdf()
	{    
        if ($_POST) {
            $this->load->library('pdf');
            $data = $this->input->post('data_pdf');
            $tanggal_awal = $this->input->post('tanggal_awal_pdf');
            $tanggal_akhir = $this->input->post('tanggal_akhir_pdf');
            
            $this->pdf->setPaper('A4', 'potrait');
            $this->pdf->filename = "Laporan-POS.pdf";
            $this->pdf->load_view('laporan/laporan_pdf', compact('data', 'tanggal_awal', 'tanggal_akhir'));
            return;
        }
    }
}
