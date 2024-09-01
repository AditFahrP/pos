<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Keuangan</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_uang" id="kd_uang" value="<?php echo $kd_uang; ?>" />
            <div class="box-body">
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Tanggal</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl?>" type="text" class="form-control" id="datepicker" name="tgl" required placeholder="Masukan tanggal">
                    </div>
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Saldo Awal</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $saldo_awal?>" type="text" class="form-control" id="saldo_awal" name="saldo_awal" placeholder="Masukan saldo awal">
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Pengeluaran</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $pengeluaran?>" type="text" class="form-control" id="pengeluaran" name="pengeluaran" placeholder="Masukan pengeluaran">
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Pendapatan</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $pendapatan?>" type="text" class="form-control" id="pendapatan" name="pendapatan" placeholder="Masukan pendapatan">
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Saldo Akhir</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $saldo_akhir?>" type="text" class="form-control" id="saldo_akhir" name="saldo_akhir" placeholder="Masukan saldo akhir">
                  </div>
                </div>
                </div>
              <div class="box-footer">
                <a href="<?php echo site_url('keuangan')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>