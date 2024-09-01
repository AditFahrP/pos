<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Kehadiran</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_hadir" id="kd_hadir" value="<?php echo $kd_hadir; ?>" />
            <div class="box-body">
            <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="nama_karyawan" id="nama_karyawan">
                      <option value="">--Pilih Karyawan--</option>
                      <?php foreach ($karyawan as $mark) :?>
                        <option value="<?php echo $mark->nama_karyawan?>" <?php echo ($mark->nama_karyawan == $nama_karyawan) ? 'selected' : ''; ?>><?php echo $mark->nama_karyawan?></option>
                    <?php endforeach ;?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Keterangan</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="keterangan" required>
                          <option value="">--Pilih Keterangan--</option>
                          <option value="Hadir" <?php echo ($keterangan == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                          <option value="Sakit" <?php echo ($keterangan == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                          <option value="Izin" <?php echo ($keterangan == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Tanggal</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl?>" type="text" class="form-control" id="datepicker" name="tgl" required placeholder="Masukan tanggal kehadiran">
                    </div>
                  </div>
                </div>
                </div>
              <div class="box-footer">
                <a href="<?php echo site_url('kehadiran')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>