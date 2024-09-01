<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Obat</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('hutang/update/'.$kd_top) ?>">Udate Hutang</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Nama Obat</td><td><?php echo $nama_obat?></td></tr>
                  <tr><td>Keterangan</td><td><?php echo $keterangan?></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('hutang')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>