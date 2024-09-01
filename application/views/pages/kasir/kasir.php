<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content" style="display: flex; flex-direction: row;">
        <form action="<?php echo base_url()?>kasir/tambah" method="post" accept-charset="utf-8">
            <div class="col-lg-12 col-md-9">
                <div class="col-lg-12 col-md-12 input-group" style="margin-bottom: 20px;">
                    <input type="text" id="search-input" class="form-control" placeholder="Cari barang berdasarkan nama">
                    <div id="search-results"></div>
                </div>
            <?php foreach($produk as $bars) {?>
                <div class="col-lg-6 col-xs-6 col-md-6">
                    <div class="card" style="width: 17rem;">
                    <img style="width: 17rem; height: 17rem; padding-top: 10px; background-color: white;" class="card-img-top" 
                    src="<?php echo base_url()?>images/fotoproduk/<?php echo !empty($bars->foto_produk) ? $bars->foto_produk : 'gambar_kosong.png'; ?>" alt="Foto Produk">
                        <div class="card-body form-group" style="background-color: white; border-top: 0.5px solid;">
                            <p class="card-text text-center"><?php echo $bars->nama_produk?></p>
                            <small class="card-text form-group">Harga Produk: Rp. <?php echo rupiah($bars->harga_produk)?></small>
                            <small class="card-text form-group">Jumlah Produk: <?php echo $bars->jml_produk?></small>
                            <div class="number">
                                <span class="minus">-</span>
                                <input class="input" type="text" name="jml_produk" value="1"/>
                                <span class="plus">+</span>
                            </div>
                            <!-- <input class="form-control" style="width: 50px;" type="text" id="jml_produk" name="jml_produk" value="1"> -->
                            <input type="hidden" id="harga_produk" name="harga_produk" value="<?php  echo $bars->harga_produk; ?>">
                            <input type="hidden" id="kd_produk" name="kd_produk" value="<?php  echo $bars->kd_produk; ?>">
                            <input type="hidden" id="nama_produk" name="nama_produk" value="<?php echo $bars->nama_produk; ?>">
                            <input type="hidden" id="foto_produk" name="foto_produk" value="<?php echo $bars->foto_produk; ?>">
                            <input type="hidden" id="jml_produk" name="jml_produk" value="<?php echo $bars->jml_produk; ?>">
                            <button type="button" class="btn btn-success add-produk-btn" data-jml_produk="<?php echo $bars->jml_produk; ?>" data-kd_produk="<?php echo $bars->kd_produk; ?>" data-nama_produk="<?php echo $bars->nama_produk; ?>" data-harga_produk="<?php echo $bars->harga_produk; ?>" data-foto_produk="<?php echo $bars->foto_produk; ?>" id="btn" style="margin-top: 10px; width: 100%;">add produk</button>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </form>
        <div class="content col-lg-12">
        <form action="<?php echo base_url()?>kasir/proses_order" method="post" enctype="multipart/form-data">
            <div class="row">
                <div clas="box-body" style="background-color: white;">
                    <!-- <input type="button" id="updateCartBtn" value="Update cart" class="btn btn-primary" style="margin: 10px;"> -->
                    <input type="hidden" id="total_harga_input" name="total_harga" value="">
                    <input type="hidden" name="total_barang" id="total_barang" value="">
            <table class="table table-bordered table-hover" style="max-height: 500px;">
                <thead>
                  <tr>
                    <th>Foto Produk</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>X</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $subtotal = 0;
                        $cartIsEmpty = empty($content);
                        if($cartIsEmpty) {
                        } else {
                            foreach ($content as $item) {
                                ?>
                                <input type="hidden" name="cart[<?php echo $item['id']?>][id]" value="<?php echo $item['id'];?>" />
                                <input type="hidden" name="cart[<?php echo $item['id']?>][rowid]" value="<?php echo $item['rowid'];?>" />
                                <input type="hidden" name="cart[<?php echo $item['id']?>][nama]" value="<?php echo $item['nama'];?>" />
                                <input type="hidden" name="cart[<?php echo $item['id']?>][harga]" value="<?php echo $item['harga'];?>" />
                                <input type="hidden" name="cart[<?php echo $item['id']?>][qty]" value="<?php echo $item['qty'];?>" />
                                <input type="hidden" name="cart[<?php echo $item['id']?>][gambar]" value="<?php echo $item['gambar'];?>" />
                                <!-- <input type="hidden" name="cart[<?php echo $item['id']?>][gaji]" value="<?php echo $item['gaji'];?>" /> -->

                                <?php 
                                $subbayar = $item['qty'] * $item['harga'];
                                $subtotal = $subtotal + $subbayar;
                                ?>
                    ?>
                    <tr>
                        <td><?php echo $item['nama']?></td>
                        <td><input type="text" name="cart[<?php echo $item['id'];?>][qty]" value="<?php echo $item['qty'];?>" placeholder="0"></td>
                        <!-- <td><input type="text" name="cart[<?php echo $item['id'];?>][gaji]" value="<?php echo $item['gaji'];?>" placeholder="0"></td> -->
                        <td>Rp. <?php echo number_format($item['harga'], 0, ",",".");?></td>
                    </tr>
                  </tbody>
                    <?php }
                    }?>
                  <tfoot>
                    <tr>
                        <th>Total Barang</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <th></th>
                    </tr>
                </tfoot>
                </table>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Pelanggan :</label>
                </div>
                <select name="pelanggan" id="" class="form-control">
                    <option value="">--Pilih pelanggan--</option>
                    <option value="Umum">Umum</option>
                    <option value="Warung">Warung</option>
                    <option value="Warung Komitmen">Warung Komitmen</option>
                </select>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Nama Pelanggan :</label>
                </div>
                <input name="nama" id="nama" class="form-control" placeholder="Masukan nama pelanggan">
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Alamat :</label>
                </div>
                    <textarea style="height: 100px;" type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukan alamat lengkap" required></textarea>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Delivery :</label>
                </div>
                <select name="ambil" id="" class="form-control">
                    <option value="">--Pilih delivery--</option>
                    <option value="Ambil sendiri">Ambil sendiri</option>
                    <option value="Diantarkan">Diantarkan</option>
                </select>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Pilih transaksi :</label>
                </div>
                <select name="transaksi" id="" class="form-control">
                    <option value="">--Pilih transaksi--</option>
                    <option value="Tunai">Tunai</option>
                    <option value="Transfer">Transfer</option>
                    <option value="TOP">TOP</option>
                </select>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Gaji Karyawan :</label>
                </div>
                <select name="gaji" id="" class="form-control">
                    <option value="">--Pilih gaji--</option>
                    <option value="1000">1000</option>
                    <option value="2000">2000</option>
                    <option value="500">500</option>
                </select>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Pilih pengirim :</label>
                </div>
                <select name="delivery" id="" class="form-control">
                    <option value="">--Pilih pengirim--</option>
                    <?php foreach ($karyawan as $mark) :?>
                    <option value="<?php echo $mark->nama_karyawan?>"><?php echo $mark->nama_karyawan?></option>
                <?php endforeach ;?>
                </select>
            </div>
            <div class="card-body">
                <div class="card-text">
                    <label for="" class="control-label">Diatas 3 - 10 KM :</label>
                </div>
                <input name="ongkir" id="" class="form-control">
            </div>
            <button style="margin-top: 10px; width: 200px;" type="submit" class="btn btn-success">Kirim</button>
        </div>
    </form>
</div>
</div>

</div>  