<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Penjualan</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_detail_pesanan" id="kd_detail_pesanan" value="<?php echo $kd_detail_pesanan; ?>" />
            <div class="box-body">
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nomor Identitas</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="">
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
                  <label for="varchar" class="col-sm-2 control-label">Jumlah Produk</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $qty?>" type="text" class="form-control" id="qty" name="qty" placeholder="Masukan Jumlah Produk" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Total Harga</label>
                  <div class="col-sm-10">
                    <input value="<?php echo $total_harga?>" type="text" class="form-control" id="total_harga" name="total_harga" placeholder="Masukan Total Harga" required>
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