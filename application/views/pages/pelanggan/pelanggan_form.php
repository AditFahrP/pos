<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Pasien</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_penjualan" id="kd_penjualan" value="<?php echo $kd_penjualan; ?>" />
            <div class="box-body">
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nomor Identitas</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Penjualan</label>
                  <div class="col-sm-10">
                    <input  type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama lengkap" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Penjualan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_tlp" name="no_tlp" placeholder="Masukan no telepon" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-10">
                  <textarea style="height: 150px;" type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat lengkap" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Penjualan</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="jk" required>
                          <option value=""></option>
                          <option value="Penjualan" <?php echo ($jk == 'Penjualan') ? 'selected' : ''; ?>>Penjualan</option>
                          <option value="Penjualan" <?php echo ($jk == 'Penjualan') ? 'selected' : ''; ?>>Penjualan</option>
                        </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('penjualan')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>