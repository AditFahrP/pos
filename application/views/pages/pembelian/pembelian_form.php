<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Pembelian Produk</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
              <input type="hidden" name="kd_beli" id="kd_beli" value="<?php echo $kd_beli; ?>" />
              <div class="box-body">
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Kode Produk</label>
                  <div class="col-sm-1">
                    <input class="form-control" name="kd_beli" id="kd_beli" readonly value="<?php echo $kd_beli; ?>" />
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Nama Produk</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="nama_produk" id="nama_produk">
                      <option value="">--Pilih Produk--</option>
                      <?php foreach ($produk as $mark) :?>
                        <option value="<?php echo $mark->nama_produk?>" <?php echo ($mark->nama_produk == $nama_produk) ? 'selected' : ''; ?>><?php echo $mark->nama_produk?></option>
                    <?php endforeach ;?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Kategori Produk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $kategori_produk?>" type="text" class="form-control" id="kategori_produk" name="kategori_produk" required placeholder="Masukan kategori produk">
                  </div>
                </div>
                <div class="form-group">
    <label for="jml_produk" class="col-sm-2 control-label">Jumlah Produk</label>
    <div class="col-sm-10">
        <input value="<?php echo $jml_produk?>" class="form-control" id="jml_produk" name="jml_produk" placeholder="Masukan jumlah produk" required>
    </div>
  </div>
<div class="form-group">
    <label for="harga_produk" class="col-sm-2 control-label">Harga Produk</label>
    <div class="col-sm-10">
      <input value="<?php echo $harga_produk?>" type="text" class="mata-uang form-control harga_produk" id="harga_produk" name="harga_produk" onkeyup="hitungTotal();" required placeholder="Masukan harga produk">
    </div>
  </div>
  <div class="form-group">
    <label for="total_harga" class="col-sm-2 control-label">Total Harga</label>
    <div class="col-sm-10">
      <input value="<?php echo $total_harga?>" type="text" class="mata-uang form-control total_harga" id="total_harga" name="total_harga" placeholder="Total harga">
    </div>
  </div>
    <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Produk Masuk</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl_produk_masuk?>" type="text" class="form-control" id="datepicker" name="tgl_produk_masuk" required placeholder="Masukan tanggal produk masuk">
                    </div>
                  </div>
                </div>
                </div>
              <div class="box-footer">
                <a href="<?php echo site_url('pembelian')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>