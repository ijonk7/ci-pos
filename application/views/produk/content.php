  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?= form_open('produk/pdfBarcode', ['onsubmit' => 'return cekCheckboxBarcode()', 'target' => '_blank']) ?>

              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-produk">
              <i class="fa fa-plus-circle"></i> Tambah
              </button>
              <button type="button" id="tampil-modal-multiple-delete" onclick="cekCheckbox()" class="btn btn-danger" data-toggle="modal" data-target="#hapus-multiple-produk">
              <i class="fa fa-trash"></i> Hapus
              </button>

              <input type="hidden" name="cetak_barcode" id="cetak_barcode">
              <button type="submit" class="btn btn-info">
              <i class="fa fa-barcode"></i> Cetak Barcode
              </button>
              <?= form_close() ?>
              
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

              <!-- Modal Tambah Produk -->
              <div class="modal fade" id="tambah-produk">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Tambah Produk</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Kode Produk', 'kode_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_number_id = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'value' => $input->kode_produk,
                              'name' => 'kode_produk',
                              'id' => 'kode_produk',
                              'class' => 'form-control',
                              'placeholder' => 'Kode Produk', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_number_id) ?>
                          <div style="background-color: #ec463f;"><?= form_error('kode_produk') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Nama Produk', 'nama_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('nama_produk', $input->nama_produk, ['class' => 'form-control', 'id' => 'nama_produk', 'placeholder' => 'Nama Produk', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('nama_produk') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Kategori Produk', 'kategori_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_dropdown('kategori_produk', $list_menu, $input->kategori_produk, ['class' => 'form-control', 'id' => 'kategori_produk', 'placeholder' => 'Kategori Produk', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('kategori_produk') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Merk', 'merk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('merk', $input->merk, ['class' => 'form-control', 'id' => 'merk', 'placeholder' => 'Merk']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('merk') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Harga Beli', 'harga_beli', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('harga_beli', $input->harga_beli, ['class' => 'form-control', 'id' => 'harga_beli', 'placeholder' => 'Harga Beli', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('harga_beli') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Diskon', 'diskon', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_number_diskon = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'value' => $input->diskon,
                              'name' => 'diskon',
                              'id' => 'diskon',
                              'class' => 'form-control',
                              'placeholder' => 'Diskon', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_number_diskon) ?>
                          <div style="background-color: #ec463f;"><?= form_error('diskon') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Harga Jual', 'harga_jual', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('harga_jual', $input->harga_jual, ['class' => 'form-control', 'id' => 'harga_jual', 'placeholder' => 'Harga Jual', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('harga_jual') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Stok', 'stok', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_number_stok = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'value' => $input->stok,
                              'name' => 'stok',
                              'id' => 'stok',
                              'class' => 'form-control',
                              'placeholder' => 'Stok', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_number_stok) ?>
                          <div style="background-color: #ec463f;"><?= form_error('stok') ?></div>
                        </div>
                      </div>                      
                    </div>
            
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Simpan</button>
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

              <!-- Modal Edit Produk -->
              <div class="modal fade" id="edit-produk">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('produk/update', ['class' => 'form-horizontal']) ?>
                  <input type="hidden" id="edit_tanggal_waktu" name="edit_tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Edit Produk</h3>
                    </div>

                    <div class="modal-body">                      
                    <input type="hidden" name="edit_id_produk" id="edit_id_produk">
                    <div class="form-group">
                        <?= form_label('Kode Produk', 'edit_kode_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_number_id = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'name' => 'edit_kode_produk',
                              'id' => 'edit_kode_produk',
                              'class' => 'form-control',
                              'placeholder' => 'Kode Produk',
                              'disabled'    => 'disabled'
                            );
                          ?>
                          <?= form_input($edit_number_id) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Nama Produk', 'edit_nama_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_nama_produk', '', ['class' => 'form-control', 'id' => 'edit_nama_produk', 'placeholder' => 'Nama Produk', 'required' => 'required']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Kategori Produk', 'edit_kategori_produk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_dropdown('edit_kategori_produk', $list_menu, '', ['class' => 'form-control', 'id' => 'edit_kategori_produk', 'placeholder' => 'Kategori Produk', 'required' => 'required']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Merk', 'edit_merk', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_merk', '', ['class' => 'form-control', 'id' => 'edit_merk', 'placeholder' => 'Merk']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Harga Beli', 'edit_harga_beli', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_harga_beli', '', ['class' => 'form-control', 'id' => 'edit_harga_beli', 'placeholder' => 'Harga Beli', 'required' => 'required']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Diskon', 'edit_diskon', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_number_diskon = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'name' => 'edit_diskon',
                              'id' => 'edit_diskon',
                              'value' => '0',
                              'class' => 'form-control',
                              'placeholder' => 'Diskon', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($edit_number_diskon) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Harga Jual', 'edit_harga_jual', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_harga_jual', '', ['class' => 'form-control', 'id' => 'edit_harga_jual', 'placeholder' => 'Harga Jual', 'required' => 'required']) ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Stok', 'edit_stok', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_number_stok = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'name' => 'edit_stok',
                              'id' => 'edit_stok',
                              'class' => 'form-control',
                              'placeholder' => 'Stok', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($edit_number_stok) ?>
                        </div>
                      </div>
                    </div>
            
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Simpan</button>
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

              <!-- Modal Hapus Produk -->
              <div class="modal fade" id="hapus-produk">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <?= form_open('produk/delete', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Hapus Produk</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4>Apa Anda yakin ingin menghapus produk ini ?</h4>
                          <input type="hidden" name="hapus_id_produk" id="hapus_id_produk">
                          <?= form_error('hapus_id_produk') ?>
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

              <!-- Modal Hapus Multiple Produk -->
              <div class="modal fade" id="hapus-multiple-produk">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <?= form_open('produk/deleteMultiple', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Hapus Produk</h4>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4>Apa Anda yakin ingin menghapus produk ini ?</h4>
                          <input type="hidden" name="hapus_multiple_id_produk" id="hapus_multiple_id_produk">
                          <?= form_error('hapus_multiple_id_produk') ?>
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
              <table id="tabel_produk" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th><input type="checkbox" id="parent_checked_delete"></th>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Merk</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Diskon</th>
                  <th>Stok</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th></th>
                  <th>No</th>
                  <th>Kode Produk</th>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Merk</th>
                  <th>Harga Beli</th>
                  <th>Harga Jual</th>
                  <th>Diskon</th>
                  <th>Stok</th>
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