<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Delivery</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('pesanan/update/'.$kd_pesan) ?>">Udate Delivery</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Tanggal Pesan</td><td><?php echo $tgl_pesan?></td></tr>
                  <tr><td>Jam Pesan</td><td><?php echo $jam?></td></tr>
                  <tr><td>Pelanggan</td><td><?php echo $pelanggan?></td></tr>
                  <tr><td>Nama Pelanggan</td><td><?php echo $nama?></td></tr>
                  <tr><td>Total Harga</td><td><?php echo $total_harga?></td></tr>
                  <tr><td>Pembayaran</td><td><?php echo $pembayaran?></td></tr>
                  <tr><td>Pengirim</td><td><?php echo $pengirim?></td></tr>
                  <tr><td>Ongkir</td><td><?php echo $ongkir?></td></tr>
                  <tr><td>Delivery</td><td><?php echo $delivery?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('pesanan')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>