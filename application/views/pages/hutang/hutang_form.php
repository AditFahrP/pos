<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Kasbon</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_top" id="kd_top" value="<?php echo $kd_top; ?>" />
            <div class="box-body">
            <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Tanggal Hutang</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl_hutang?>" type="text" class="form-control" id="datepicker" name="tgl_hutang" required placeholder="Masukan tanggal kasbon">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" value="<?php echo $nama?>" class="form-control" id="nama" name="nama" placeholder="Masukan nama" required>
                  </div>
                </div>
              <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-10">
                  <textarea style="height: 50px;" type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat lengkap" required><?php echo $alamat?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Total Hutang</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $total_hutang?>" type="text" class="form-control" id="total_hutang" name="total_hutang" placeholder="Masukan total hutang" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Bayar</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $bayar?>" type="text" class="form-control" id="bayar" name="bayar" placeholder="Masukan total bayar">
                  </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Bayar Via</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="via">
                          <option value="">--Pilih Pembayaran--</option>
                          <option value="Transfer" <?php echo ($via == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
                          <option value="Tunai" <?php echo ($via == 'Tunai') ? 'selected' : ''; ?>>Tunai</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Keterangan</label>
                  <div class="col-sm-10">
                  <textarea style="height: 50px;" type="text" class="form-control" id="ket" name="ket" placeholder="Masukan keterangan" required><?php echo $ket?></textarea>
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
                <a href="<?php echo site_url('hutang')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>