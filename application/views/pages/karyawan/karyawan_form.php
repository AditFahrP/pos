<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Karyawan</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_karyawan" id="kd_karyawan" value="<?php echo $kd_karyawan; ?>" />
            <div class="box-body">
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nomor Identitas</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $nama_karyawan?>" type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Level</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $level?>" type="text" class="form-control" id="level" name="level" placeholder="Level Karyawan" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-10">
                  <textarea style="height: 150px;" type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat lengkap" required><?php echo $alamat?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">No Telepon</label>
                  <div class="col-sm-10">
                    <input type="text" value="<?php echo $no_tlp?>" class="form-control" id="no_tlp" name="no_tlp" placeholder="Masukan nomer telepon" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Karyawan Masuk</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl_karyawan_masuk?>" type="text" class="form-control" id="datepicker" name="tgl_karyawan_masuk" required placeholder="Masukan tanggal karyawan masuk">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('karyawan')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>