<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Produk</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="kd_produk" id="kd_produk" value="<?php echo $kd_produk; ?>" />
              <input type="hidden" name="foto_produk" id="foto_produk"  value="<?php echo $foto_produk; ?>" />
              <div class="box-body">
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Kode Produk</label>
                  <div class="col-sm-1">
                    <input class="form-control" name="kd_produk" id="kd_produk" readonly value="<?php echo $kd_produk; ?>" />
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama Produk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $nama_produk?>" type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama produk" required autofocus>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Kategori Produk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $kategori_produk?>" type="text" class="form-control" id="kategori_produk" name="kategori_produk" required placeholder="Masukan kategori produk">
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Jumlah Produk</label>
                  <div class="col-sm-10">
                  <input value="<?php echo $jml_produk?>" class="form-control" id="jml_produk" name="jml_produk" placeholder="Masukan jumlah produk" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Harga Produk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $harga_produk?>" type="text" class="mata-uang form-control harga_produk" id="terbilang-input" name="harga_produk" onkeyup="inputTerbilang();" required placeholder="Masukan harga produk">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Gaji</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $gaji?>" type="text" class="mata-uang form-control harga_produk" id="terbilang-input" name="gaji" onkeyup="inputTerbilang();" required placeholder="Masukan gaji produk">
                  </div>
                </div> -->
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Produk Masuk</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl_produk_masuk?>" type="text" class="form-control" id="datepicker" name="tgl_produk_masuk" required placeholder="Masukan tanggal produk masuk">
                    </div>
                  </div>
                </div> -->
                    <div class="form-group">
                      <label for="exampleIputFile" class="col-sm-2 control-label">Foto Produk</label>
                      <div class="col-sm-10">
                        <input type="file" name="foto_produk" id="output" accept="image/*">
                        <p class="help-block">Saran 1:1</p>
                        <!-- <img src="<?php echo base_url() . '/images/fotoproduk/' . $foto_produk ?>"> -->
                    </div>
                  </div>
                </div>
              <div class="box-footer">
                <a href="<?php echo site_url('produk')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>