<header class="main-header">
    <!-- Logo -->
    <a href="<?= site_url('dashboard') ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>P</b>OS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>POS</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu" onclick="kosongkanPesan()">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success" id="total-pesan"><?= $this->session->userdata('total_pesan') === 0 ? '' : $this->session->userdata('total_pesan') ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki <span id="total-angka-pesan"><?= $alert['total_pesan'] === 0 ? 0 : $alert['total_pesan'] ?></span> pesan</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">                  
                  <?php if(!empty($alert['list_pesan'])): ?>
                  <?php foreach ($alert['list_pesan'] as $value): ?>
                  <li data-toggle="tooltip" data-placement="right" title="<?= $value['judul_pesan'] ?>">
                    <a href="#">
                     <small><i class="fa fa-clock-o"></i> <?= formatTanggalWaktuLengkap($value['created_at']) ?></small><br>
                    <div class="pull-left">
                      <img src="<?= base_url('assets/images/foto-profil/'.$this->session->userdata('foto')) ?>" class="img-circle">
                    </div>
                      <h4>
                        <?= $value['user_pengirim'] ?>
                      </h4>
                      <p><?= $value['judul_pesan'] ?></p>
                    </a>
                  </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="footer"><a href="<?= site_url('pesan') ?>">Lihat semua pesan</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu" onclick="kosongkanNotifikasi()">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="total-notifikasi"><?= $this->session->userdata('total_notifikasi') === 0 ? '' : $this->session->userdata('total_notifikasi') ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki <span id="total-angka-notifikasi"><?= $alert['total_notifikasi'] === 0 ? 0 : $alert['total_notifikasi'] ?></span> notifikasi</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <?php if(!empty($alert['list_notifikasi'])): ?>
                  <?php foreach ($alert['list_notifikasi'] as $value): ?>
                  <li data-toggle="tooltip" data-placement="right" title="<?= $value['created_by'] . ' ' . $value['subjek'] . ' ' . $value['objek'] ?>">
                    <a href="#">
                      <span style="font-size: 12px;"><?= formatTanggalWaktuLengkap($value['created_at']) ?></span><br />
                      <i class="fa fa-users text-aqua"></i> <span style="font-size: 14px;"><?= $value['created_by'] . ' ' . $value['subjek'] . ' ' . $value['objek'] ?></span>
                    </a>
                  </li>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </ul>
              </li>
              <li class="footer"><a href="<?= site_url('notifikasi') ?>">Lihat semua notifikasi</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url('assets/images/foto-profil/'.$this->session->userdata('foto')) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= $this->session->userdata('nama') ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url('assets/images/foto-profil/'.$this->session->userdata('foto')) ?>" class="img-circle" alt="User Image">

                <p>
                <?= $this->session->userdata('nama') ?> - <?= $this->session->userdata('jabatan') ?>
                  <small>Member sejak: <?= $this->session->userdata('created_at') ?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?= site_url('profil') ?>" class="btn btn-default btn-flat">Edit Profil</a>
                </div>
                <div class="pull-right">
                  <a href="<?= site_url('logout') ?>" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>