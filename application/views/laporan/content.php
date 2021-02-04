  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>        
        Laporan Pendapatan: <?= formatTanggalLengkap($range[0]) ?> s/d <?= formatTanggalLengkap(end($range)) ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Laporan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">

            <?= form_open('laporan/filter', ['onsubmit' => 'return cekPeriodeTanggal()']) ?>
              <!-- Date -->
              <div class="form-group col-lg-2">
                <label>Tanggal Awal:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="<?= !empty($input['tanggal_awal']) ? $input['tanggal_awal'] : '' ?>" name="tanggal_awal" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
              </div>

              <!-- Date -->
              <div class="form-group col-lg-2">
                <label>Tanggal Akhir:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="<?= !empty($input['tanggal_akhir']) ? $input['tanggal_akhir'] : '' ?>" name="tanggal_akhir" class="form-control pull-right" id="datepicker2">
                </div>
                <!-- /.input group -->
              </div>

              <!-- Filter Button -->
              <div class="form-group col-lg-2">
                <label>&nbsp;</label>
                <div class="input-group date">
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#tambah-laporan">
                      <i class="fa fa-filter"></i> Ubah Periode
                    </button>
                  </div>
              </div>

            <?= form_close() ?>

              <!-- Kolom Kosong -->
              <div class="form-group col-lg-4">
              </div>

            <?= form_open('laporan/pdf', ['onsubmit' => 'cetakPdf()', 'target' => '_blank']) ?>
              <input type="hidden" name="data_pdf" id="pdf_hidden">
              <input type="hidden" name="tanggal_awal_pdf" value="<?= $range[0] ?>">
              <input type="hidden" name="tanggal_akhir_pdf" value="<?= end($range) ?>">

              <!-- Filter Button -->
              <div class="form-group col-lg-2">
                <label>&nbsp;</label>
                <div class="input-group date" style="margin-left:auto; margin-right:0;">
                    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#tambah-laporan">
                      <i class="fa fa-file-pdf-o"></i> Ekspor PDF
                    </button>
                  </div>
              </div>
            <?= form_close() ?>
              
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <table id="tabel_laporan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Penjualan</th>
                  <th>Pembelian</th>
                  <th>Pengeluaran</th>
                  <th>Pendapatan</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $total_baris = count($laporan_umum);
                  $total_pendapatan = 0;
                  $idx_no_urut = 1;
                  $idx_tgl_penjualan = 1;
                  $idx_penjualan = 1;
                  $idx_pembelian = 1;
                  $idx_pengeluaran = 1;

                  foreach ($laporan_umum as $value) 
                  {
                    echo "<tr><td>" . $idx_no_urut . "</td>";

                    if($idx_tgl_penjualan < $total_baris) 
                    {
                      echo "<td>" . formatTanggalLengkap($value['tanggal']) . "</td>";
                    } else {
                      echo "<td>" . formatTanggalLengkap($value['tanggal']) . "</td>";
                    }          
                    ++$idx_tgl_penjualan;

                    if($idx_penjualan < $total_baris) 
                    {
                      echo "<td>" . number_format($value['penjualan'],0,",",".") . "</td>";
                    } else {
                      echo "<td>" . number_format($value['penjualan'],0,",",".") . "</td>";
                    }
                    ++$idx_penjualan;

                    if($idx_pembelian < $total_baris) 
                    {
                      echo "<td>" . number_format($value['pembelian'],0,",",".") . "</td>";
                    } else {
                      echo "<td>" . number_format($value['pembelian'],0,",",".") . "</td>";
                    }
                    ++$idx_pembelian;

                    if($idx_pengeluaran < $total_baris) 
                    {
                      echo "<td>" . number_format($value['pengeluaran'],0,",",".") . "</td>";
                    } else {
                      echo "<td>" . number_format($value['pengeluaran'],0,",",".") . "</td>";
                    }
                    ++$idx_pengeluaran;

                    $sub_total_pendapatan = $value['penjualan'] - $value['pembelian'] - $value['pengeluaran'];
                    $total_pendapatan += $sub_total_pendapatan;
                    echo "<td>" . number_format($sub_total_pendapatan,0,",",".") . "</td></tr>";          
                    ++$idx_no_urut;
                  }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th style="text-align:right">Total Pendapatan</th>
                  <th><?= number_format($total_pendapatan,0,",",".") ?></th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->