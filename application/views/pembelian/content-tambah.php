  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transaksi Pembelian
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li>Pembelian</li>
        <li class="active">Tambah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
              
              <?php $success_message = $this->session->flashdata('success'); ?>
              <?php $error_message = $this->session->flashdata('error'); ?>
              <?php $error_field = $this->session->flashdata('error_field'); ?>
              <?php if (!empty($success_message)): ?>
              <div class="alert alert-success alert-dismissible" style="margin-top: 10px; margin-bottom: 10px; padding: 10px 30px 10px 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p><i class="icon fa fa-check"></i> <?= $success_message ?></p>
              </div>
              <?php endif; ?>
              <?php if (!empty($error_message)): ?>
              <div class="alert alert-danger alert-dismissible" style="margin-top: 10px; margin-bottom: 10px; padding: 10px 30px 10px 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p><i class="icon fa fa-close"></i> <?= $error_message ?></p>
              </div>
              <?php endif; ?>
              <?php if (!empty($error_field)): ?>
              <div class="alert alert-warning alert-dismissible" style="margin-top: 10px; margin-bottom: 10px; padding: 10px 30px 10px 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $error_field ?>
              </div>
              <?php endif; ?>

              <!-- Modal Pilih Produk -->
              <div class="modal fade" id="pilih-produk">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Pilih Produk</h3>
                    </div>

                    <div class="modal-body">
                      <table id="daftar_produk" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['daftar_produk'] as $value): ?>
                            <tr>
                                <th><?= $value['kode_produk'] ?></th>
                                <th><?= $value['nama_produk'] ?></th>
                                <th><?= $value['harga_beli'] ?></th>
                                <th>
                                  <button class="btn btn-primary" id="disable_tombol_<?= $value['id'] ?>" onclick="ambilDataProduk(<?= $value['id'] ?>)" value="<?= $value['id'] ?>" data-dismiss="modal"><i class="fa fa-check-circle"></i> Pilih</button>                                  
                                </th>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                      </table>
                  </div>
                  
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- Modal Hapus Pembelian -->
            <div class="modal fade" id="hapus-pembelian">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Hapus Pembelian</h3>
                  </div>

                  <div class="modal-body">
                    <div class="form-group">
                      <div class="col-md-12">
                        <h4>Apa Anda yakin ingin menghapus pembelian ini ?</h4>
                        <input type="hidden" name="hapus_id_pembelian" id="hapus_id_pembelian">
                        <?= form_error('hapus_nama') ?>
                      </div>
                    </div>
                  </div>
            
                  <div class="modal-footer">
                    <button type="button" id="tombol-hapus-produk" class="btn btn-primary" data-dismiss="modal">Hapus</button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                  </div>
                  <!-- /.box-footer -->
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->      

          <div class="box-body">

            <table>
              <thead>
                <tr><td width="150">Supplier</td><td><b><?= $data['daftar_supplier'][0]['nama'] ?></b></td></tr>
                <tr><td>Alamat</td><td><b><?= $data['daftar_supplier'][0]['alamat'] ?></b></td></tr>
                <tr><td>Telpon</td><td><b><?= $data['daftar_supplier'][0]['telepon'] ?></b></td></tr>
              </thead>
            </table>
            <hr>

            <div class="form form-horizontal">
              <div class="form-group">
                  <label for="kode" class="col-md-2 control-label">Kode Produk</label>
                  <div class="col-md-5">
                    <div class="input-group">
                      <input id="kode" type="text" class="form-control" name="kode" autofocus="" required="">
                      <span class="input-group-btn">
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#pilih-produk">...</button>
                      </span>
                    </div>
                  </div>
              </div>
            </div>

            <?= form_open('', ['class' => 'form-keranjang']) ?>
              <input type="hidden" name="id_supplier"  value="<?= $data['daftar_supplier'][0]['id'] ?>">
              <input type="hidden" id="tanggal_waktu" name="tanggal_waktu" value="">

              <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table class="table table-striped tabel-pembelian dataTable no-footer" id="DataTables_Table_1">
                  <thead>
                     <tr role="row">
                      <th width="30" class="sorting_disabled" rowspan="1" colspan="1" style="width: 30px;">No</th>
                      <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 166px;">Kode Produk</th>
                      <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 175px;">Nama Produk</th>
                      <th align="right" class="sorting_disabled" rowspan="1" colspan="1" style="width: 92px;">Harga</th>
                      <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 110px;">Jumlah</th>
                      <th align="right" class="sorting_disabled" rowspan="1" colspan="1" style="width: 130px;">Sub Total</th>
                      <th width="100" class="sorting_disabled" rowspan="1" colspan="1" style="width: 100px;">Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="daftar-produk-terpilih">
                  </tbody>
                </table>
              </div>

              <br />

              <div class="col-md-8">
                 <div id="tampil-bayar" style="background: #dd4b39; color: #fff; font-size: 80px; text-align: center; height: 100px">Rp. <span class="tampil-total-bayar">0</span></div>
                 <div id="tampil-terbilang" style="background: #3c8dbc; color: #fff; font-weight: bold; padding: 10px"> Rupiah</div>
              </div>

              <div class="col-md-4">
                <div class="form form-horizontal form-pembelian">

                  <div class="form-group">
                    <label for="totalrp" class="col-md-4 control-label">Total</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control" id="totalrp" name="total_harga" readonly="" value="Rp. 0">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="diskon" class="col-md-4 control-label">Diskon</label>
                    <div class="col-md-8">
                      <input type="number" class="form-control" id="diskon" name="diskon" min="0" max="100" value="0" onfocusout="dapatDiskon(this.value)" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="bayarrp" class="col-md-4 control-label">Bayar</label>
                    <div class="col-md-8">
                      <input type="text" class="form-control tampil-total-bayar" id="bayarrp" name="total_bayar" readonly="" value="Rp. 0">
                    </div>
                  </div>

                </div>
              </div>

            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>

            <?= form_close() ?>

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