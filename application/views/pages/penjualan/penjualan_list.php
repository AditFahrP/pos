<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <div class="box">
                  <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="box-title">DAFTAR PENJUALAN</h3>
                    <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('penjualan/create')?>">Tambah Penjualan</a>
                </div>
                <div class="box-header btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn bg-green">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked> Copy
                    </label>
                    <label class="btn bg-green">
                        <input type="radio" name="options" id="option2" autocomplete="off"> PDF
                    </label>
                    <label class="btn bg-green">
                        <input type="radio" name="options" id="option3" autocomplete="off"> JSON
                    </label>
                    <label class="btn bg-green">
                        <input type="radio" name="options" id="option3" autocomplete="off"> Print
                    </label>
                </div>
              <div class="box-body">
                <table id="mytable7" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Bulan</th>
                    <th>Nama Produk</th>
                    <th>Produk Terjual</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1.</td>
                    <td>Penjualan</td>
                    <td>Penjualan</td>
                    <td>Penjualan</td>  
                    <td>Penjualan</td>  
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>