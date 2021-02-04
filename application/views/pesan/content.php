  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pesan Masuk
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= site_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pesan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-pesan">
              <i class="fa fa-plus-circle"></i> Pesan Baru
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

              <!-- Modal Tambah Pesan -->
              <div class="modal fade" id="tambah-pesan">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Tambah Pesan</h3>
                    </div>

                    <div class="modal-body">

                      <?php
                        foreach ($list_user as $val)
                        {
                            $data_user[$val['username']] = $val['username'];
                        }

                        $no_pesan_terakhir =  $no_pesan['no_pesan'] + 1;
                      ?>

                      <div class="form-group">
                        <?= form_label('No Pesan', 'no_pesan', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('no_pesan', '#'. $no_pesan_terakhir, ['class' => 'form-control', 'id' => 'no_pesan', 'readonly' => 'readonly', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('no_pesan') ?></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <?= form_label('Kepada', 'user_penerima', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                        <?= form_dropdown('user_penerima', $data_user, '', ['class' => 'form-control select2', 'style' => 'width: 100%']); ?>
                        </div>
                      </div>

                      <div class="form-group">
                        <?= form_label('Judul', 'judul_pesan', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                          <?= form_input('judul_pesan', $input->judul_pesan, ['class' => 'form-control', 'id' => 'judul_pesan', 'placeholder' => 'Judul', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('judul_pesan') ?></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <?= form_label('Pesan', 'isi_pesan', ['class' => 'col-md-3 control-label']); ?>
                        <div class="col-md-6">
                        <?= form_textarea('isi_pesan', $input->isi_pesan, ['class' => 'form-control', 'id' => 'isi_pesan', 'rows' => '6', 'placeholder' => 'Isi pesan']) ?>
                        </div>
                      </div>

                    </div>
            
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Kirim</button>
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

              <!-- Modal Edit Pesan -->
              <div class="modal fade" id="edit-pesan">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('pesan/update', ['class' => 'form-horizontal']) ?>
                    <input type="hidden" id="edit_tanggal_waktu" name="edit_tanggal_waktu">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Daftar Pesan</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12" id="lihat-pesan"></div>
                      </div>
                    </div>

                    <!-- /.box-footer -->
                  <?= form_close() ?>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->

              <!-- Modal Hapus Pesan -->
              <div class="modal fade" id="hapus-pesan">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <?= form_open('pesan/replyPesan', ['class' => 'form-horizontal']) ?>
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title">Balas Pesan (#<span id="judul-no-pesan"></span>)</h3>
                    </div>

                    <div class="modal-body">
                      <div class="form-group">
                        <div class="col-md-12" id="reply-pesan">
                        </div>
                      </div>

                      <?php
                      $data_reply_no_pesan = array(
                        'type'  => 'hidden',
                        'name'    => 'reply_no_pesan',
                        'id'    => 'id_reply_no_pesan',
                        );
                      
                        echo form_input($data_reply_no_pesan);
                      ?>

                      <div class="form-group">
                        <?= form_label('Kepada', 'reply_user_penerima', ['class' => 'col-md-3']); ?>
                        <div class="col-md-12">
                          <?= form_input('reply_user_penerima', '', ['class' => 'form-control', 'id' => 'reply_user_penerima', 'readonly' => 'readonly', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('reply_user_penerima') ?></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <?= form_label('Judul', 'reply_judul_pesan', ['class' => 'col-md-3']); ?>
                        <div class="col-md-12">
                          <?= form_input('reply_judul_pesan', '', ['class' => 'form-control', 'id' => 'reply_judul_pesan', 'readonly' => 'readonly', 'required' => 'required']) ?>
                          <div style="background-color: #ec463f;"><?= form_error('reply_judul_pesan') ?></div>
                        </div>
                      </div>

                      <div class="form-group">
                        <?= form_label('Pesan', 'id_reply_isi_pesan', ['class' => 'col-md-3']); ?>
                        <div class="col-md-12">
                        <?= form_textarea('reply_isi_pesan', '', ['class' => 'form-control', 'id' => 'id_reply_isi_pesan', 'rows' => '6', 'placeholder' => 'Isi pesan', 'required' => 'required']) ?>
                        </div>
                      </div>

                    </div>
            
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Kirim</button>
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
              <table id="tabel_pesan" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>ID Pesan</th>
                  <th>Dari</th>
                  <th>Judul Pesan</th>
                  <th>Tanggal & Waktu</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>ID Pesan</th>
                  <th>Dari</th>
                  <th>Judul Pesan</th>
                  <th>Tanggal & Waktu</th>
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