  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar User
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-user">
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

              <!-- Modal Tambah User -->
              <div class="modal fade" id="tambah-user">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Tambah User</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Nama', 'nama', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('nama', $input->nama, ['class' => 'form-control', 'id' => 'nama', 'placeholder' => 'Nama', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('nama') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Username', 'username', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('username', $input->username, ['class' => 'form-control', 'id' => 'username', 'placeholder' => 'Username', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('username') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Email', 'email', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_email = array(
                              'type' => 'email',           //it's 'number', not 'numeric'
                              'value' => $input->email,
                              'name' => 'email',
                              'id' => 'email',
                              'class' => 'form-control',
                              'placeholder' => 'Email', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_email) ?>
                          <div style="background-color: #ec463f;"><?= form_error('email') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Password Baru', 'password_baru', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_password_baru = array(
                              'type' => 'password',           //it's 'number', not 'numeric'
                              'value' => $input->password_baru,
                              'name' => 'password_baru',
                              'id' => 'password_baru',
                              'class' => 'form-control',
                              'placeholder' => 'Password Baru', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_password_baru) ?>
                          <div style="background-color: #ec463f;"><?= form_error('password_baru') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Konfirmasi Password Baru', 'konfirmasi_password_baru', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $tambah_konfirmasi_password_baru = array(
                              'type' => 'password',           //it's 'number', not 'numeric'
                              'value' => $input->konfirmasi_password_baru,
                              'name' => 'konfirmasi_password_baru',
                              'id' => 'konfirmasi_password_baru',
                              'class' => 'form-control',
                              'placeholder' => 'Konfirmasi Password Baru', 
                              'required' => 'required'
                            );
                          ?>
                          <?= form_input($tambah_konfirmasi_password_baru) ?>
                          <div style="background-color: #ec463f;"><?= form_error('konfirmasi_password_baru') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Level', 'level', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_dropdown('level', ['staff' => 'staff', 'admin' => 'admin'], '', ['class' => 'form-control', 'id' => 'level', 'placeholder' => 'Level', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('level') ?></div>
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

              <!-- Modal Edit User -->
              <div class="modal fade" id="edit-user">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('user/update', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" name="edit_id_user" id="edit_id_user">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Edit User</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <?= form_label('Nama', 'edit_nama', ['class' => 'col-md-3 control-label']) ?>
                        <div class="col-md-6">
                          <?= form_input('edit_nama', '', ['class' => 'form-control', 'id' => 'edit_nama', 'placeholder' => 'Nama', 'required' => 'required']) ?>
                          <?= form_error('edit_nama') ?>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Username', 'edit_username', ['class' => 'col-md-3 control-label']) ?>
                        <div class="col-md-6">
                          <?= form_input('edit_username', '', ['class' => 'form-control', 'id' => 'edit_username', 'placeholder' => 'Username', 'required' => 'required']) ?>
                          <?= form_error('edit_username') ?>
                        </div>
                      </div>
                      <div class="form-group">
                      <?= form_label('Email', 'edit_email', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('edit_email', '', ['class' => 'form-control', 'id' => 'edit_email', 'placeholder' => 'Email', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_email') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Password Baru', 'edit_password_baru', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_password_baru = array(
                              'type' => 'password',           //it's 'number', not 'numeric'
                              'value' => $input->password_baru,
                              'name' => 'edit_password_baru',
                              'id' => 'edit_password_baru',
                              'class' => 'form-control',
                              'placeholder' => 'Password Baru'
                            );
                          ?>
                          <?= form_input($edit_password_baru) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_password_baru') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Konfirmasi Password Baru', 'edit_konfirmasi_password_baru', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?php
                            $edit_konfirmasi_password_baru = array(
                              'type' => 'password',           //it's 'number', not 'numeric'
                              'value' => $input->konfirmasi_password_baru,
                              'name' => 'edit_konfirmasi_password_baru',
                              'id' => 'edit_konfirmasi_password_baru',
                              'class' => 'form-control',
                              'placeholder' => 'Konfirmasi Password Baru'
                            );
                          ?>
                          <?= form_input($edit_konfirmasi_password_baru) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_konfirmasi_password_baru') ?></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <?= form_label('Level', 'edit_level', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_dropdown('edit_level', ['staff' => 'staff', 'admin' => 'admin'], '', ['class' => 'form-control', 'id' => 'edit_level', 'placeholder' => 'Level', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('edit_level') ?></div>
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

              <!-- Modal Hapus User -->
              <div class="modal fade" id="hapus-user">
                <div class="modal-dialog">
                  <div class="modal-content">
                  <?= form_open('user/delete', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Hapus User</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12">
                          <h4>Apa Anda yakin ingin menghapus user ini ?</h4>
                          <input type="hidden" name="hapus_id_user" id="hapus_id_user">
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
              <table id="tabel_user" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Email</th>
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