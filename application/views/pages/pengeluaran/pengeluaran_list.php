<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <div class="box">
                  <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="box-title">DAFTAR PENGELUARAN</h3>
                    <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('pengeluaran/create')?>">Tambah Pengeluaran</a>
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
                <!-- <a class="btn bg-red" style="margin: 10px; " href="<?php echo site_url('pengeluaran/hapus_data')?>" onclick="return confirm('Apakah Anda yakin ingin menghapus semua data pengeluaran? Semua data yang ada akan dihapus.');"><i class="fa fa-trash" aria-hidden="true"></i>Hapus Semua Data</a> -->

              <div class="box-body">
                <table id="mytable9" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pengeluaran</th>
                    <th>Pengeluaran Untuk</th>
                    <th>Biaya</th>
                    <th>Jam</th>
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