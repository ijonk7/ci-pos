<?php
$level = $this->session->userdata('level'); 
?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= base_url('assets/images/foto-profil/'.$this->session->userdata('foto')) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?= $this->session->userdata('nama') ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="<?= isset($data['dashboard']) ? $data['dashboard'] : ''; ?>">
          <a href="<?= site_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?= isset($data['kategori']) ? $data['kategori'] : ''; ?>">
          <a href="<?= site_url('kategori') ?>">
            <i class="fa fa-cube"></i> <span>Kategori</span>
          </a>
        </li>
        <li class="<?= isset($data['produk']) ? $data['produk'] : ''; ?>">
          <a href="<?= site_url('produk') ?>">
            <i class="fa fa-cubes"></i> <span>Produk</span>
          </a>
        </li>
        <li class="<?= isset($data['supplier']) ? $data['supplier'] : ''; ?>">
          <a href="<?= site_url('supplier') ?>">
            <i class="fa fa-truck"></i> <span>Supplier</span>
          </a>
        </li>
        <li class="<?= isset($data['pengeluaran']) ? $data['pengeluaran'] : ''; ?>">
          <a href="<?= site_url('pengeluaran') ?>">
            <i class="fa fa-money"></i> <span>Pengeluaran</span>
          </a>
        </li>
        <?php if ($level === 'admin'): ?>
        <li class="<?= isset($data['user']) ? $data['user'] : ''; ?>">
          <a href="<?= site_url('user') ?>">
            <i class="fa fa-user"></i> <span>User</span>
          </a>
        </li>
        <?php endif; ?>
        <li class="<?= isset($data['penjualan']) ? $data['penjualan'] : ''; ?>">
          <a href="<?= site_url('penjualan') ?>">
            <i class="fa fa-upload"></i> <span>Penjualan</span>
          </a>
        </li>
        <li class="<?= isset($data['pembelian']) ? $data['pembelian'] : ''; ?>">
          <a href="<?= site_url('pembelian') ?>">
            <i class="fa fa-download"></i> <span>Pembelian</span>
          </a>
        </li>
        <li class="<?= isset($data['laporan']) ? $data['laporan'] : ''; ?>">
          <a href="" id="link_laporan" onclick="cariTanggalSekarang()">
            <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
          </a>
        </li>
        <?php if ($level === 'admin'): ?>
        <li class="<?= isset($data['pengaturan']) ? $data['pengaturan'] : ''; ?>">
          <a href="<?= site_url('pengaturan') ?>">
            <i class="fa fa-gears"></i> <span>Pengaturan</span>
          </a>
        </li>
        <?php endif; ?>
    </section>
    <!-- /.sidebar -->
  </aside>

<script>
function cariTanggalSekarang() {
  var waktu_sekarang = new Date();
  var laporan_bulan_ini = addZero(waktu_sekarang.getMonth() + 1);
  var laporan_tahun_ini = waktu_sekarang.getFullYear();
  var total_hari_laporan = new Date(laporan_tahun_ini, laporan_bulan_ini, 0).getDate();

  document.getElementById("link_laporan").setAttribute("href", "<?= site_url('laporan?total_hari=') ?>"+total_hari_laporan+"&bulan="+laporan_bulan_ini+"&tahun="+laporan_tahun_ini);
  // location.assign("https://www.w3schools.com");
}

function addZero(i) {
  if (i < 10) {
    i = "0" + i;
  }
  return i;
}
</script>