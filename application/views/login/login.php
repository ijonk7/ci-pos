<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Favicon all devices -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url() ?>assets/images/favicon-image/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?= base_url() ?>assets/images/favicon-image/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url() ?>assets/images/favicon-image/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= base_url() ?>assets/images/favicon-image/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>assets/images/favicon-image/favicon-16x16.png">
  <link rel="manifest" href="<?= base_url() ?>assets/images/favicon-image/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= base_url() ?>assets/images/favicon-image/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/bower_components/Ionicons/css/ionicons.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/iCheck/square/blue.css') ?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page" style="background-image: url(<?= base_url('assets/images/background/background.jpg') ?>); background-repeat: no-repeat;">
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="../../index2.html"><b>Login </b>POS</a> -->
    <img src="<?= base_url('assets/images/logo/'.$logo->logo) ?>" width="200" height="82">
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); border-radius: 10px;">
    <p class="login-box-msg">Login untuk menggunakan aplikasi</p>

    <?php $success_message = $this->session->flashdata('success'); ?>
    <?php $error_message = $this->session->flashdata('error'); ?>
    <?php if (!empty($success_message)): ?>
    <p class="alert alert-success">
    <?= $success_message ?>
    </p>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
    <p class="alert alert-danger">
    <?= $error_message ?>
    </p>
    <?php endif; ?>

    <?= form_open('', 'onsubmit = "waktuSekarang()"') ?>
        <input type="hidden" id="tanggal_waktu" name="tanggal_waktu">
      <div class="form-group has-feedback">
        <?= form_input('username', 'guest', ['class' => 'form-control', 'style' => 'border-radius: 25px;', 'placeholder' => 'Username']) ?>
        <?= form_error('username') ?>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?= form_password('password', 'guestguest', ['class' => 'form-control', 'style' => 'border-radius: 25px;', 'placeholder' => 'Password']) ?>
        <?= form_error('password') ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" checked> Ingat Saya
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius: 25px; background-color: #00a75f;">Masuk</button>
        </div>
        <!-- /.col -->
      </div>
    <?= form_close() ?>

    <br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= base_url('assets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
  
// Script untuk mendapatkan tanggal dan waktu sekarang
  function waktuSekarang() {
    var d = new Date();
    
    var tahun = d.getFullYear();
    var bulan = addZero(d.getMonth() + 1)
    var tanggal = addZero(d.getDate());
  
    var jam = addZero(d.getHours());
    var menit = addZero(d.getMinutes());
    var detik = addZero(d.getSeconds());
    document.getElementById("tanggal_waktu").value = tahun + "-" + bulan + "-" + tanggal + " " + jam + ":" + menit + ":" + detik;
  }

  function addZero(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
// END: Script untuk mendapatkan tanggal dan waktu sekarang
</script>
</body>
</html>
