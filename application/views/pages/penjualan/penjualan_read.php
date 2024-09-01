<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Penjualan</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('penjualan/update/'.$kd_detail_pesanan) ?>">Udate Penjualan</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Tanggal</td><td><?php echo $tgl?></td></tr>
                  <tr><td>Bulan</td><td><?php echo $bulan?></td></tr>
                  <tr><td>Nama Produk</td><td><?php echo $nama_produk?></td></tr>
                  <tr><td>Produk Terjual</td><td><?php echo $qty?></td></tr>
                  <tr><td>Total Harga</td><td><?php echo $total_harga?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('penjualan')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>