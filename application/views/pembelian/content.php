  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pembelian
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pembelian</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#pilih-supplier">
              <i class="fa fa-plus-circle"></i> Transaksi Baru
              </button>
              
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

              <!-- Modal Pilih Supplier -->
              <div class="modal fade" id="pilih-supplier">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Pilih Supplier</h3>
                    </div>

                    <div class="modal-body">
                      <table id="daftar_supplier" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data['daftar_supplier'] as $value): ?>
                            <tr>
                                <th><?= $value['nama'] ?></th>
                                <th><?= $value['alamat'] ?></th>
                                <th><?= $value['telepon'] ?></th>
                                <th>
                                  <a href="pembelian/<?= $value['id'] ?>" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a>                                  
                                </th>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                      </table>
                  </div>
                  
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

              <!-- Modal Edit Pembelian -->
              <div class="modal fade" id="edit-pembelian">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Detail Pembelian</h3>
                    </div>

                    <div class="modal-body">
                      <table id="tabel_detail_pembelian" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Produk</th>
                          <th>Nama Produk</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Sub Total</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                          <th>No</th>
                          <th>Kode Produk</th>
                          <th>Nama Produk</th>
                          <th>Harga</th>
                          <th>Jumlah</th>
                          <th>Sub Total</th>
                        </tr>
                        </tfoot>
                      </table>                    
                    </div>
                    
                    <!-- /.box-footer -->
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
                  <?= form_open('pembelian/delete', ['class' => 'form-horizontal']) ?>
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
                      <button type="submit" class="btn btn-primary">Hapus</button>
                      <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    </div>
                    <!-- /.box-footer -->
                  <?= form_close() ?>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->
              
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <table id="tabel_pembelian" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Diskon</th>
                  <th>Total Bayar</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Supplier</th>
                  <th>Total Item</th>
                  <th>Total Harga</th>
                  <th>Diskon</th>
                  <th>Total Bayar</th>
                  <th>Aksi</th>
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