<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Pengeluaran</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('penngeluaran/update/'.$kd_pengeluaran) ?>">Udate Pengeluaran</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Nama Pengeluaran</td><td><?php echo $pengeluaran?></td></tr>
                  <tr><td>Pengeluaran Untuk</td><td><?php echo $pengeluaran_untuk?></td></tr>
                  <tr><td>Biaya</td><td><?php echo $biaya?></td></tr>
                  <tr><td>Tanggal</td><td><?php echo $tgl?></td></tr>
                  <tr><td>Jam</td><td><?php echo $jam?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('pengeluaran')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>