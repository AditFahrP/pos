<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-lg-12">
                <div class="box">
                  <div class="box-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 class="box-title">DAFTAR KEUANGAN</h3>
                    <div class="box-title text-green" style="text-align: center; flex: 1;"  id="message">
                      <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                    <a class="btn bg-purple" style="margin-left: auto; border-radius: 20px;" href="<?php echo site_url('keuangan/create') ?>">Tambah Keuangan</a>
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
                <table id="mytable13" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Saldo Awal</th>
                    <th>Pendapatan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo Akhir</th>
                    <th>Aksi</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Nama</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </section>
</div>