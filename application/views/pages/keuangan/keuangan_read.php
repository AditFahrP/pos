<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Keuangan</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('keuangan/update/'.$kd_uang) ?>">Udate Keuangan</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Tanggal</td><td><?php echo $tgl?></td></tr>
                  <tr><td>Saldo Awal</td><td><?php echo $saldo_awal?></td></tr>
                  <tr><td>Pendapatan</td><td><?php echo $pendapatan?></td></tr>
                  <tr><td>Pengeluaran</td><td><?php echo $pengeluaran?></td></tr>
                  <tr><td>Saldo Akhir</td><td><?php echo $saldo_akhir?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('keuangan')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>