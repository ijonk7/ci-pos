<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS | <?= $data['title'] ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

  <?php $this->load->view($data['source_code_top']) ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <?php $this->load->view('part/header') ?>
  <?php $this->load->view('part/side-menu') ?>
  <?php $this->load->view($data['content']) ?>
  <?php $this->load->view('part/footer') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<?php $this->load->view($data['source_code_bottom']) ?>

<script>
// Script untuk menghapus session total_pesan dan mengosongkan nilai dengan id="total-pesan"
  function kosongkanPesan() {
    $.ajax({
      type: 'POST',
      url: '<?= base_url()."$this->nama_controller/kosongkan_pesan" ?>',
      success: function () {
        document.getElementById("total-pesan").innerHTML = '';
      }
    });
  }
// END: Script untuk menghapus session total_pesan dan mengosongkan nilai dengan id="total-pesan"

// Script untuk menghapus session total_notifikasi dan mengosongkan nilai dengan id="total-notifikasi"
function kosongkanNotifikasi() {
    $.ajax({
      type: 'POST',
      url: '<?= base_url()."$this->nama_controller/kosongkan_notifikasi" ?>',
      success: function () {
        document.getElementById("total-notifikasi").innerHTML = '';
      }
    });
  }
// END: Script untuk menghapus session total_notifikasi dan mengosongkan nilai dengan id="total-notifikasi"

// Script untuk menamplikan Tooltip di Notifikasi
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
// END: Script untuk menamplikan Tooltip di Notifikasi
</script>
</body>
</html>
