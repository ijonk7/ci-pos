  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengaturan
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pengaturan</li>
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
            <?= form_open_multipart('pengaturan', ['class' => 'form-horizontal', 'onsubmit' => 'waktuSekarang()'], ['id_pengaturan' => '1']) ?>
              <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
              <div class="box-body">
                <div class="form-group">
                  <label for="nama_perusahaan" class="col-sm-2 control-label">Nama Perusahaan</label>                  

                  <div class="col-sm-10">
                    <?= form_input('nama_perusahaan', $input['nama_perusahaan'], ['class' => 'form-control', 'id' => 'nama_perusahaan', 'placeholder' => 'Nama Perusahaan', 'maxlength' => '100', 'required' => 'required']) ?>
                    <?= form_error('nama_perusahaan') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="alamat" class="col-sm-2 control-label">Alamat</label>

                  <div class="col-sm-10">
                    <?= form_input('alamat', $input['alamat'], ['class' => 'form-control', 'id' => 'alamat', 'placeholder' => 'Alamat', 'required' => 'required']) ?>
                    <?= form_error('alamat') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="telepon" class="col-sm-2 control-label">Telepon</label>

                  <div class="col-sm-10">
                    <?= form_input('telepon', $input['telepon'], ['class' => 'form-control', 'id' => 'telepon', 'placeholder' => 'Telepon', 'maxlength' => '20', 'required' => 'required']) ?>
                    <?= form_error('telepon') ?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="logo_perusahaan" class="col-sm-2 control-label">Logo Perusahaan</label>

                  <div class="col-sm-10">
                    <?= form_upload('logo_perusahaan', '', ['class' => 'form-control', 'id' => 'logo_perusahaan']) ?>
                    <small><em>Gambar harus bertipe jpg / png / gif, Ukuran Maks: 100 kb, Lebar Maks: 200 px, Tinggi Maks: 82 px.</em></small>
                    <span style="color: red;">
                      <?= !empty($gagal_upload['error']) ? $gagal_upload['error'] : '<br>' ?>
                    </span>
                    <img src="<?= base_url('assets/images/logo/'.$input['logo']) ?>" width="200" height="82">
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Simpan Perubahan</button>
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