<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <div class="box">
                  <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="box-title">DAFTAR PRODUK</h3>
                    <div class="box-title text-green" style="text-align: center; flex: 1;"  id="message">
                      <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                    <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('produk/create')?>">Tambah Produk</a>
                  </div>
                  <div style="margin: 10px;">
                    <a class="btn bg-green" href="<?php echo site_url('produk/pdf_view')?>" target="_BLANK"><i class="fa fa-file"></i> PDF</a>
                  </div>
              <div class="box-body">
                <table id="mytable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori Produk</th>
                    <th>Jumlah Produk</th>
                    <th>Harga Produk</th>
                    <!-- <th>Tanggal Masuk Produk</th> -->
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