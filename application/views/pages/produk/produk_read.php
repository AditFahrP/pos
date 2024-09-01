<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-xs-12 col-lg-12">
        <div class="box">
          <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="box-title"><?php echo $button?> Produk</h3>
            <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('produk/update/'.$kd_produk) ?>">Udate Produk</a>
                </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="readtable" class="table table-bordered table-hover">
                  <tr><td>Nama Produk</td><td><?php echo $nama_produk?></td></tr>
                  <tr><td>Kategori Produk</td><td><?php echo $kategori_produk?></td></tr>
                  <tr><td>Jumlah Produk</td><td><?php echo $jml_produk?></td></tr>
                  <tr><td>Harga Produk</td><td><?php echo rupiah($harga_produk)?></td></tr>
                  <tr><td>Tanggal Produk Masuk</td><td><?php echo $tgl_produk_masuk?></td></tr>
                  <!-- <tr><td>Gaji</td><td><?php echo $gaji?></td></tr> -->
                  <tr><td>Foto Produk</td><td><img style="width: 17rem; height: 17rem;" src="<?php echo base_url()?>images/fotoproduk/<?php echo $foto_produk?>" alt=""></td></tr>
                </table>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('produk')?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>