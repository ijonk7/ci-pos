  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Supplier
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Supplier</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-supplier">
              <i class="fa fa-plus-circle"></i> Tambah
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

              <!-- Modal Tambah Supplier -->
              <div class="modal fade" id="tambah-supplier">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Tambah Supplier</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Nama Supplier', 'nama', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('nama', $input->nama, ['class' => 'form-control', 'id' => 'nama', 'placeholder' => 'Nama Supplier', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('nama') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Alamat', 'alamat', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('alamat', $input->alamat, ['class' => 'form-control', 'id' => 'alamat', 'placeholder' => 'Alamat Supplier', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('alamat') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Telepon', 'telepon', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $telepon = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'value' => $input->telepon,
                              'name' => 'telepon',
                              'id' => 'telepon',
                              'class' => 'form-control',
                              'placeholder' => 'Telepon Supplier', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($telepon) ?>
                          <div style="background-color: #ec463f;"><?= form_error('telepon') ?></div>
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

              <!-- Modal Edit Supplier -->
              <div class="modal fade" id="edit-supplier">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('supplier/update', ['class' => 'form-horizontal']) ?>
                  <input type="hidden" id="edit_tanggal_waktu" name="edit_tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Edit Supplier</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Nama Supplier', 'edit_nama', ['class' => 'col-md-3 control-label']) ?>
                        <div class="col-md-6">
                          <input type="hidden" name="edit_id_supplier" id="edit_id_supplier">
                          <?= form_input('edit_nama', '', ['class' => 'form-control', 'id' => 'edit_nama', 'placeholder' => 'Nama Supplier', 'required' => 'required']) ?>
                          <?= form_error('edit_nama') ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Alamat', 'edit_alamat', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_alamat', '', ['class' => 'form-control', 'id' => 'edit_alamat', 'placeholder' => 'Alamat Supplier', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_alamat') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Telepon', 'edit_telepon', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_telepon = array(
                              'type' => 'number',           //it's 'number', not 'numeric'
                              'name' => 'edit_telepon',
                              'id' => 'edit_telepon',
                              'class' => 'form-control',
                              'placeholder' => 'Telepon Supplier', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($edit_telepon) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_telepon') ?></div>
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

              <!-- Modal Hapus Supplier -->
              <div class="modal fade" id="hapus-supplier">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <?= form_open('supplier/delete', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Hapus supplier</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4>Apa Anda yakin ingin menghapus Supplier ini ?</h4>
                          <input type="hidden" name="hapus_id_supplier" id="hapus_id_supplier">
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
              <table id="tabel_supplier" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Supplier</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama Supplier</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
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