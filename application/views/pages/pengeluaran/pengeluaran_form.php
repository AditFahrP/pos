<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Pengeluaran</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_pengeluaran" id="kd_pengeluaran" value="<?php echo $kd_pengeluaran; ?>" />
            <div class="box-body">
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama Pengeluaran</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $pengeluaran?>" type="text" class="form-control" id="pengeluaran" name="pengeluaran" placeholder="Masukan nama pengeluaran" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Pengeluaran Untuk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $pengeluaran_untuk?>" type="text" class="form-control" id="pengeluaran_untuk" name="pengeluaran_untuk" placeholder="Pengeluaran untuk" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Biaya</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $biaya?>" type="text" class="form-control" id="biaya" name="biaya" placeholder="Masukan biaya" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Tanggal</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl?>" type="text" class="form-control" id="datepicker" name="tgl" required placeholder="Masukan tanggal">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('pengeluaran')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>