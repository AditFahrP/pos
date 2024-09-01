<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <div class="box">
                  <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="box-title">DAFTAR PEMBELIAN PRODUK</h3>
                    <div class="box-title text-green" style="text-align: center; flex: 1;"  id="message">
                      <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                    <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('pembelian/create')?>">Tambah Pembelian Produk</a>
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
              <!-- /.box-header -->
              <div class="box-body">
                <table id="mytable8" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori Produk</th>
                    <th>Jumlah Produk</th>
                    <th>Harga Produk</th>
                    <th>Total Harga</th>
                    <th>Tanggal Masuk Produk</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  </tbody>
                  <!-- <tfoot>
                  <tr>
                    <th>Total</th>
                    <th>100000</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </tfoot> -->
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
</div>