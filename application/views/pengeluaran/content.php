  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Pengeluaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pengeluaran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-pengeluaran">
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

              <!-- Modal Tambah Pengeluaran -->
              <div class="modal fade" id="tambah-pengeluaran">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Tambah Pengeluaran</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Jenis Pengeluaran', 'jenis_pengeluaran', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('jenis_pengeluaran', $input->jenis_pengeluaran, ['class' => 'form-control', 'id' => 'jenis_pengeluaran', 'placeholder' => 'Jenis Pengeluaran', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('jenis_pengeluaran') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Nominal', 'nominal', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('nominal', $input->nominal, ['class' => 'form-control', 'id' => 'nominal', 'placeholder' => 'Nominal Pengeluaran', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('nominal') ?></div>
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

              <!-- Modal Edit Pengeluaran -->
              <div class="modal fade" id="edit-pengeluaran">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('pengeluaran/update', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="edit_tanggal_waktu" name="edit_tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Edit Pengeluaran</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Jenis Pengeluaran', 'edit_jenis_pengeluaran', ['class' => 'col-md-3 control-label']) ?>
                        <div class="col-md-6">
                          <input type="hidden" name="edit_id_pengeluaran" id="edit_id_pengeluaran">
                          <?= form_input('edit_jenis_pengeluaran', '', ['class' => 'form-control', 'id' => 'edit_jenis_pengeluaran', 'placeholder' => 'Jenis Pengeluaran', 'required' => 'required']) ?>
                          <?= form_error('edit_jenis_pengeluaran') ?>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Nominal', 'edit_nominal', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_nominal', '', ['class' => 'form-control', 'id' => 'edit_nominal', 'placeholder' => 'Nominal Pengeluaran', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_nominal') ?></div>
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

              <!-- Modal Hapus Pengeluaran -->
              <div class="modal fade" id="hapus-pengeluaran">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <?= form_open('pengeluaran/delete', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Hapus Pengeluaran</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4>Apa Anda yakin ingin menghapus pengeluaran ini ?</h4>
                          <input type="hidden" name="hapus_id_pengeluaran" id="hapus_id_pengeluaran">
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
              <table id="tabel_pengeluaran" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Jenis Pengeluaran</th>
                  <th>Nominal</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Jenis Pengeluaran</th>
                  <th>Nominal</th>
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