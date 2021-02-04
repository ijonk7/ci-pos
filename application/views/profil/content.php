  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Profil
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">User</li>
        <li class="active">Edit Profil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              
              <?php $success_message = $this->session->flashdata('success'); ?>
              <?php $error_message = $this->session->flashdata('error'); ?>
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
              <?php if (!empty($error_validasi)): ?>
              <div class="alert alert-danger alert-dismissible" style="margin-top: 10px; margin-bottom: 10px; padding: 10px 30px 10px 10px;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $error_validasi ?>
              </div>
              <?php endif; ?>
              
            </div>
            <!-- /.box-header -->
            
            <!-- form start -->
            <?= form_open_multipart('profil', ['class' => 'form-horizontal'], ['id_user' => $this->session->userdata('id_user')]) ?>
              <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
              <div class="box-body">
                <div class="form-group">
                  <label for="foto_profil" class="col-sm-2 control-label">Foto Profil</label>

                  <div class="col-sm-10">
                    <?= form_upload('foto_profil', '', ['class' => 'form-control', 'id' => 'foto_profil']) ?>
                    <small><em>Gambar harus bertipe jpg / png / gif, Ukuran Maks: 100 kb, Lebar Maks: 215 px, Tinggi Maks: 215 px.</em></small>
                    <span style="color: red;">
                      <?= !empty($gagal_upload['error']) ? $gagal_upload['error'] : '<br>' ?>
                    </span>
                    <img src="<?= base_url('assets/images/foto-profil/'.$input['foto']) ?>" width="215" height="215">
                  </div>
                </div>
                <div class="form-group">
                  <label for="password_lama" class="col-sm-2 control-label">Password Lama</label>                  

                  <div class="col-sm-10">
                    <?= form_password('password_lama', '', ['class' => 'form-control', 'id' => 'password_lama', 'placeholder' => 'Password Lama']) ?>
                    <?= form_error('password_lama') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="password_baru" class="col-sm-2 control-label">Password Baru</label>

                  <div class="col-sm-10">
                    <?= form_password('password_baru', '', ['class' => 'form-control', 'id' => 'password_baru', 'placeholder' => 'Password Baru']) ?>
                    <?= form_error('password_baru') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="konfirmasi_password_baru" class="col-sm-2 control-label">Konfirmasi Password Baru</label>

                  <div class="col-sm-10">
                    <?= form_password('konfirmasi_password_baru', '', ['class' => 'form-control', 'id' => 'konfirmasi_password_baru', 'placeholder' => 'Konfirmasi Password Baru']) ?>
                    <?= form_error('konfirmasi_password_baru') ?>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Simpan Perubahan</button>
              </div>
              <!-- /.box-footer -->
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