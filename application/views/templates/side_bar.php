<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo base_url('dashboard')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><?php echo $this->session->userdata('nama')?></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b> <?php echo $this->session->userdata('nama')?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">SELAMAT DATANG <?php echo strtoupper($this->session->userdata('nama'))?></span>
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php if ($this->session->userdata('username')) { ?>
          <li class="dropdown user ">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="<?php echo base_url()?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php echo $this->session->userdata('nama')?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <!-- <li class="user-header">
                <img src="<?php echo base_url()?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                <?php echo $this->session->userdata('username')?>
                </p>
              </li> -->
              <!-- Menu Body -->
              <!-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
              </li> -->
              <!-- Menu Footer-->
              <li class="dropdown-item">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a href="<?php echo base_url('login/logout')?>" class="btn btn-default btn-flat">Log out</a>
                </div>
              </li>
            </ul>
            <?php } ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url();?>assets/dist/img/logo_pos.jpg" style="width: 80%;" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Point of Sale</p>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        
        <?php if ($this->session->userdata('level') == 'admin'): ?>
        <!-- Tampilkan semua menu untuk admin -->
        <li class="<?php echo $this->uri->segment(1) == 'dashboard' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'kasir' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('kasir')?>">
                <i class="fa fa-calculator"></i> <span>Kasir</span>
            </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'produk' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('produk')?>">
            <i class="fa fa-bar-chart"></i><span>Produk</span>
            </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'pembelian' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('pembelian')?>">
            <i class="fa fa-cart-plus"></i><span>Pembelian Produk</span>
            </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'pengeluaran' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('pengeluaran')?>">
            <i class="fa fa-arrow-circle-up"></i><span>Pengeluaran</span>
            </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'penjualan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('penjualan')?>">
            <i class="fa fa-line-chart"></i> <span>Penjualan</span>
          </a>
        </li>
        <li class="treeview <?php echo $this->uri->segment(1) == 'konsumen' ? 'active' : ''; ?>">
          <a href="">
            <i class="fa fa-building-o"></i> <span>Konsumen</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo base_url('umum')?>"><i class="fa fa-circle-o"></i>Umum</a></li>
            <li class="active"><a href="<?php echo base_url('warung')?>"><i class="fa fa-circle-o"></i>Warung</a></li>
            <li class="active"><a href="<?php echo base_url('warungkomit')?>"><i class="fa fa-circle-o"></i>Warung Komitmen</a></li>
          </ul>
        </li>
        <!-- <li class="">
          <a href="<?php echo base_url('keuangan')?>">
            <i class="fa fa-money"></i> <span>Keuangan</span>
          </a>
        </li> -->
        <!-- <li class="<?php echo $this->uri->segment(1) == 'pelanggan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('pelanggan')?>">
            <i class="ion ion-person"></i> <span>Palanggan</span>
          </a>
        </li> -->
        <li class="<?php echo $this->uri->segment(1) == 'karyawan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('karyawan')?>">
            <i class="fa fa-group"></i> <span>Karyawan</span>
          </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'kehadiran' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('kehadiran')?>">
            <i class="fa fa-calendar"></i> <span>Kehadiran</span>
          </a>
        </li>
        <li class="<?php echo $this->uri->segment(1) == 'pesanan' ? 'active' : ''; ?>">
          <a href="<?php echo base_url('pesanan')?>">
            <i class="fa fa-cart-arrow-down"></i> <span>Delivery</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="<?php echo base_url('keuangan')?>"><i class="fa fa-circle-o"></i>Laporan Keuangan</a></li>
            <li class="active"><a href="<?php echo base_url('gaji')?>"><i class="fa fa-circle-o"></i>Gaji Karyawan</a></li>
            <li class="active"><a href="<?php echo base_url('kasbon')?>"><i class="fa fa-circle-o"></i>Kasbon</a></li>
            <li class="active"><a href="<?php echo base_url('hutang')?>"><i class="fa fa-circle-o"></i>Hutang</a></li>
          </ul>
        </li>
    <?php elseif ($this->session->userdata('level') == 'kasir'): ?>
        <!-- Tampilkan hanya menu kasir untuk kasir -->
        <li class="<?php echo $this->uri->segment(1) == 'kasir' ? 'active' : ''; ?>">
            <a href="<?php echo base_url('kasir')?>">
                <i class="fa fa-calculator"></i> <span>Kasir</span>
            </a>
        </li>
    <?php endif; ?>
    <!-- Tambahkan menu lainnya sesuai kebutuhan -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>