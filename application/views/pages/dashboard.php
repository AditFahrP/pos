  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header" style="padding-top: 10px;">
      <div class="content-header" style="margin-top: 10px; width: 100%; height: 80px; background-color: white; border-radius: 10px; display: flex; flex-direction: row;">
        <img src="<?php echo base_url();?>assets/dist/img/user1-128x128.jpg" class="img-circle" alt="User Image" style="margin-top: 0px; width: 50px; height: 50px; padding: 0px;"> -->
        <!-- <h5 style="color: grey; padding-left: 20px;">
        <span>Selamat datang <?php echo $this->session->userdata('username')?></span><small style="color: grey;"><br>Available</small></h5>
      </div>
    </section> -->

    <section class="content">
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
            <h3><?php echo number_format($total_row, 0, '', ''); ?></h3>

              <p>Produk</p>
            </div>
            <div class="icon">
              <i class="fa fa-bar-chart"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
            <h3><?php echo number_format($total_pesanan, 0, '', ''); ?></h3>
              <p>Pelanggan</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
            <h3><?php echo number_format($total_jual, 0, '', ''); ?></h3>
              <p>Pendapatan</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
              <h3><?php echo number_format($total_qty, 0, '', '')?></h3>
              <p>Produk Terjual</p>
            </div>
            <div class="icon">
              <i class="fa fa-line-chart"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
              <h3><?php echo number_format($total_rows, 0, '','')?></h3>
              <p>Karyawan</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-xs-6">
          <div class="small-box" style="background-color: white;">
            <div class="inner">
              <h3><?php echo number_format($total_semua, 0, '', '')?></h3>
              <p>Pengeluaran</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
      </section>
    </section>
  </div>