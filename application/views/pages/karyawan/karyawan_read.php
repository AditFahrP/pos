<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Karyawan</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('karyawan/update/'.$kd_karyawan) ?>">Udate Karyawan</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Nama Karyawan</td><td><?php echo $nama_karyawan?></td></tr>
                  <tr><td>Level</td><td><?php echo $level?></td></tr>
                  <tr><td>Alamat</td><td><?php echo $alamat?></td></tr>
                  <tr><td>No Telepon</td><td><?php echo $no_tlp?></td></tr>
                  <tr><td>Tanggal Karyawan Masuk</td><td><?php echo $tgl_karyawan_masuk?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('karyawan')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>