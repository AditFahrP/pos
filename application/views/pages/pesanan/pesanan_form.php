<div class="content-wrapper">
    <div class="content">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $button?> Delivery</h3>
            </div>
            <form action="<?php echo $action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" class="form-control" name="kd_pesan" id="kd_pesan" value="<?php echo $kd_pesan; ?>" />
            <div class="box-body">
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Nomor Identitas</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEmail3" placeholder="">
                  </div>
                </div> -->
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Tanggal Pesan</label>
                  <div class="col-sm-10">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input value="<?php echo $tgl_pesan?>" type="text" class="form-control" id="datepicker1" name="tgl_pesan" required placeholder="Masukan tanggal produk masuk">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Jam Pesan</label>
                  <div class="col-sm-10">
                    <input type="text" value="<?php echo $jam ?>" class="form-control" id="jam" name="jam" placeholder="Jam Pesan" required>
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-10">
                  <textarea style="height: 150px;" type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat lengkap" required></textarea>
                  </div>
                </div> -->
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Pelanggan</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="pelanggan" required>
                          <option value="">Pilih Pelanggan</option>
                          <option value="Umum" <?php echo ($pelanggan == 'Umum') ? 'selected' : ''; ?>>Umum</option>
                          <option value="Warung" <?php echo ($pelanggan == 'Warung') ? 'selected' : ''; ?>>Warung</option>
                          <option value="Warung Komitmen" <?php echo ($pelanggan == 'Warung Komitmen') ? 'selected' : ''; ?>>Warung Komitmen</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="varchar" class="col-sm-2 control-label">Nama Pelanggan :</label>
                    <div class="col-sm-10">
                      <input value="<?php echo $nama?>" name="nama" id="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                  <label for="varchar" class="col-sm-2 control-label">Total Harga</label>
                  <div class="col-sm-10">
                    <input type="text" value="<?php echo $total_harga?>" class="form-control" id="total_harga" name="total_harga" placeholder="Total Harga" required>
                  </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Pembayaran</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="pembayaran" required>
                          <option value="">Pilih Pembayaran</option>
                          <option value="Tunai" <?php echo ($pembayaran == 'Tunai') ? 'selected' : ''; ?>>Tunai</option>
                          <option value="Transfer" <?php echo ($pembayaran == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
                          <option value="TOP" <?php echo ($pembayaran == 'TOP') ? 'selected' : ''; ?>>TOP</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Pengirim</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="pengirim">
                          <option value="">Pilih Pengirim</option>
                          <option value="Aby Rochim" <?php echo ($pengirim == 'Aby Rochim') ? 'selected' : ''; ?>>Aby Rochim</option>
                          <option value="Budi" <?php echo ($pengirim == 'Budi') ? 'selected' : ''; ?>>Budi</option>
                          <option value="Danang" <?php echo ($pengirim == 'Danang') ? 'selected' : ''; ?>>Danang</option>
                          <option value="Rohmat" <?php echo ($pengirim == 'Rohmat') ? 'selected' : ''; ?>>Rohmat</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="varchar" class="col-sm-2 control-label">Diatas 3 - 10 KM :</label>
                    <div class="col-sm-10">
                      <input value="<?php echo $ongkir?>" name="ongkir" id="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                <label for="varchar" class="col-sm-2 control-label">Delivery</label>
                    <div class="col-sm-10">
                      <div class="select">
                        <select class="form-control" name="delivery">
                          <option value="">Pilih Pengiriman</option>
                          <option value="Diantarkan" <?php echo ($delivery == 'Diantarkan') ? 'selected' : ''; ?>>Diantarkan</option>
                          <option value="Ambil Sendiri" <?php echo ($delivery == 'Ambil Sendiri') ? 'selected' : ''; ?>>Ambil Sendiri</option>
                        </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="<?php echo site_url('pesanan')?>" class="btn btn-default">Cancel</a>
                <button type="submit" class="btn btn-success"><?php echo $button?></button>
              </div>
            </form>
        </div>
    </div>
</div>