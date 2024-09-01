<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- DataTables -->
<script src="<?php echo base_url();?>assets/bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url();?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url();?>assets/bower_components/chart.js/Chart.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script> $.widget.bridge('uibutton', $.ui.button);</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<script src="<?php echo base_url('assets/js/terbilang.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
    {
      return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
    };
    
    //tabel produk
    var t = $("#mytable").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "produk/json", "type": "POST"},
        columns: [
          {
            "data": "kd_produk",
            "orderable": true
          },
            {"data": "nama_produk"},
            {"data": "kategori_produk"},
            {"data": "jml_produk"},
            {"data": "harga_produk"},
            // {"data": "tgl_produk_masuk"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    //tabel karyawan
    var t = $("#mytable2").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "karyawan/json", "type": "POST"},
        columns: [
          {
            "data": "kd_karyawan",
            "orderable": true
          },
            {"data": "nama_karyawan"},
            {"data": "level"},
            {"data": "alamat"},
            {"data": "no_tlp"},
            {"data": "tgl_karyawan_masuk"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable3").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "pesanan/json", "type": "POST"},
        columns: [
          {
            "data": "kd_pesan",
            "orderable": true
          },
            {"data": "tgl_pesan"},
            {"data": "jam"},
            {"data": "pelanggan"},
            {"data": "nama"},
            {"data": "alamat"},
            {"data": "total_harga"},
            {"data": "pembayaran"},
            {"data": "pengirim", "defaultContent": ""},
            {"data": "ongkir", "defaultContent": ""},
            {"data": "delivery"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable4").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "umum/json", "type": "POST"},
        columns: [
          {
            "data": "kd_umum",
            "orderable": true
          },
            {"data": "tgl_pesan"},
            {"data": "jam"},
            {"data": "pelanggan"},
            {"data": "nama"},
            {"data": "alamat"},
            {"data": "total_harga"},
            {"data": "pembayaran"},
            {"data": "pengirim", "defaultContent": ""},
            {"data": "ongkir", "defaultContent": ""},
            {"data": "delivery"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable5").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "warung/json", "type": "POST"},
        columns: [
          {
            "data": "kd_warung",
            "orderable": true
          },
            {"data": "tgl_pesan"},
            {"data": "jam"},
            {"data": "pelanggan"},
            {"data": "nama"},
            {"data": "alamat"},
            {"data": "total_harga"},
            {"data": "pembayaran"},
            {"data": "pengirim", "defaultContent": ""},
            {"data": "ongkir", "defaultContent": ""},
            {"data": "delivery"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable6").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "warungkomit/json", "type": "POST"},
        columns: [
          {
            "data": "kd_warungkomit",
            "orderable": true
          },
            {"data": "tgl_pesan"},
            {"data": "jam"},
            {"data": "pelanggan"},
            {"data": "nama"},
            {"data": "alamat"},
            {"data": "total_harga"},
            {"data": "pembayaran"},
            {"data": "pengirim", "defaultContent": ""},
            {"data": "ongkir", "defaultContent": ""},
            {"data": "delivery"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable7").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "penjualan/json", "type": "POST"},
        columns: [
          {
            "data": "kd_detail_pesanan",
            "orderable": true
          },
            {"data": "tgl"},
            {"data": "bulan"},
            {"data": "nama_produk"},
            {"data": "qty"},
            {"data": "total_harga"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable8").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "pembelian/json", "type": "POST"},
        columns: [
          {
            "data": "kd_beli",
            "orderable": true
          },
          {"data": "nama_produk"},
          {"data": "kategori_produk"},
          {"data": "jml_produk"},
          {"data": "harga_produk"},
          {"data": "total_harga"},
          {"data": "tgl_produk_masuk"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable9").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "pengeluaran/json", "type": "POST"},
        columns: [
          {
            "data": "kd_pengeluaran",
            "orderable": true
          },
          {"data": "tgl"},
          {"data": "pengeluaran"},
          {"data": "pengeluaran_untuk"},
          {"data": "biaya"},
          {"data": "jam"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable10").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "kehadiran/json", "type": "POST"},
        columns: [
          {
            "data": "kd_hadir",
            "orderable": true
          },
          {"data": "tgl"},
          {"data": "jam"},
          {"data": "nama_karyawan"},
          {"data": "keterangan"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable11").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "kasbon/json", "type": "POST"},
        columns: [
          {
            "data": "kd_kasbon",
            "orderable": true
          },
          {"data": "tgl_kasbon"},
          {"data": "nama"},
          {"data": "alamat"},
          {"data": "jml_hutang"},
          {"data": "via"},
          {"data": "ket"},
          {"data": "bayar"},
          {"data": "saldo_akhir"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable12").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "gaji/json", "type": "POST"},
        columns: [
          {
            "data": "kd_gaji",
            "orderable": true
          },
          {"data": "tgl"},
          {"data": "nama_karyawan"},
          {"data": "gaji"},
          {"data": "bulan"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable13").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "keuangan/json", "type": "POST"},
        columns: [
          {
            "data": "kd_uang",
            "orderable": true
          },
          {"data": "tgl"},
          {"data": "saldo_awal"},
          {"data": "pendapatan"},
          {"data": "pengeluaran"},
          {"data": "saldo_akhir"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

    var t = $("#mytable14").dataTable({
      initComplete: function() {
      var api = this.api();
      $('#mytable_filter input')
              .off('.DT')
              .on('keyup.DT', function(e) {
                if (e.keyCode == 13) {
                  api.search(this.value).draw();
            }
          });
        },
        oLanguage: {
          sProcessing: "loading..."
        },
        processing: true,
        serverSide: true,
        ajax: {"url": "hutang/json", "type": "POST"},
        columns: [
          {
            "data": "kd_top",
            "orderable": true
          },
          {"data": "tgl_hutang"},
          {"data": "nama"},
          {"data": "alamat"},
          {"data": "total_hutang"},
          {"data": "bayar"},
          {"data": "via"},
          {"data": "ket"},
          {"data": "saldo_akhir"},
          {
            "data" : "action",
            "orderable": false,
            "className" : "text-center"
          },
        ],
        order: [[0, 'desc']],
        rowCallback: function(row, data, iDisplayIndex) {
          var info = this.fnPagingInfo();
          var page = info.iPage;
          var length = info.iLength;
          var index = page * length + (iDisplayIndex + 1);
          $('td:eq(0)', row).html(index);
        }
    });

});
//Date picker
$('#datepicker').datepicker({
  autoclose: true,
  format: 'dd-mm-yyyy',
});

$('#datepicker1').datepicker({
  autoclose: true,
  format: 'dd-mm-yyyy',
});

function inputTerbilang() {
  //membuat inputan otomatis jadi mata uang
  $('.mata-uang').mask('0.000.000.000.000.000', {reverse: true});
  
  //mengambil data uang yang akan dirubah jadi terbilang
  var input = document.getElementById("terbilang-input").value.replace(/\./g, "");
  
  //menampilkan hasil dari terbilang
  document.getElementById("terbilang-output").value = terbilang(input).replace(/  +/g, ' ');
} 

var isPasswordRevealed = false;

        $('#password-toggle').on('click', function() {
            isPasswordRevealed = !isPasswordRevealed;

            if (isPasswordRevealed) {
                $('#password-toggle-img').attr('src', '<?php echo base_url()?>images/eye.svg');
                $('#password').attr('type', 'text');
            }
            else {
                $('#password-toggle-img').attr('src', '<?php echo base_url()?>images/eye-slash.svg');
                $('#password').attr('type', 'password');
            }
        });

        $(document).ready(function(){
    $('#btn').click(function(){
        var kode = $('#kode').val();
        var nama = $('#nama').val();
        var harga = $('#harga').val();
        var gambar = $('#gambar').val();
        var jumlah = $('#jumlah').val();
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>shopcart/tambah',
            data: {
                kode: kode,
                nama: nama,
                harga: harga,
                gambar: gambar,
                jumlah: jumlah
            },
            success: function(response){
                // Tambahkan kode di sini jika Anda ingin menangani respons dari server
                // Misalnya, memperbarui tampilan keranjang belanja setelah menambahkan produk
            }
        });
    });
});

$(document).ready(function() {
  $(document).on('click', '.minus', function() {
				var $input = $(this).parent().find('input');
				var count = parseInt($input.val()) - 1;
				count = count < 1 ? 1 : count;
				$input.val(count);
				$input.change();
				return false;
			});
			$(document).on('click', '.plus', function() {
				var $input = $(this).parent().find('input');
				$input.val(parseInt($input.val()) + 1);
				$input.change();
				return false;
			});
		});

    $(document).ready(function(){
    $(document).on('click', '.add-produk-btn', function(){
        var kd_produk = $(this).data('kd_produk');
        var nama_produk = $(this).data('nama_produk');
        var harga_produk = $(this).data('harga_produk');
        var foto_produk = $(this).data('foto_produk');
        var jml_produk = $(this).parent().find('input[name="jml_produk"]').val(); // Ambil nilai dari input jumlah produk
        
        // Jika nilai tidak valid, atur menjadi 1
        if (isNaN(jml_produk) || jml_produk <= 0) {
            jml_produk = 1;
        }
        
        // Periksa apakah produk dengan ID yang sama sudah ada dalam tabel
        var existingRow = $('tbody tr[data-id="' + kd_produk + '"]');
        if(existingRow.length > 0) {
            // Jika produk sudah ada, tambahkan jumlah qty-nya saja
            var qtyInput = existingRow.find('td:eq(2) input');
            var qtyValue = parseInt(qtyInput.val()) + parseInt(jml_produk);
            qtyInput.val(qtyValue);
            hitungTotalBarang();
            hitungTotalHarga();
        } else {
            // Jika produk belum ada, tambahkan baris baru ke dalam tabel
            $.ajax({
                url: '<?php echo base_url()?>kasir/tambah', // Ubah URL sesuai dengan controller CI Anda
                type: 'POST',
                dataType: 'json',
                data: {
                  kd_produk: kd_produk, 
                  nama_produk: nama_produk, 
                  harga_produk: harga_produk, 
                  foto_produk: foto_produk, 
                  jml_produk: jml_produk
                },
                success: function(response){
                    if(response.status == 'success'){
                        // Tambahkan data produk ke dalam tabel
                        var newRow = '<tr style="border: none;" data-id="' + response.id + '">';
                        newRow += '<td><img src="<?php echo base_url()?>images/fotoproduk/' + (response.foto_produk ? response.foto_produk : 'gambar_kosong.png') + '" style="width: 6rem; height: 6rem" alt="' + response.nama_produk + '"></td>';
                        newRow += '<td>' + response.nama_produk + '</td>';
                        newRow += '<td><input class="input" type="text" name="cart[' + response.id + '][qty]" value="' + response.jml_produk + '" placeholder="0" readonly></td>';
                        newRow += '<td>Rp. ' + response.harga_produk + '</td>';
                        newRow += '<td><button type="button" class="hapus-produk" data-id="' + response.id + '">x</button></td>';
                        newRow += '</tr>';
                        $('tbody').append(newRow);
                        hitungTotalBarang();
                        hitungTotalHarga();
                    } else {
                        alert('Gagal menambahkan produk!');
                    }
                }
            });
        }
    });
});

  
  $(document).on('click', '.hapus-produk', function(){
  var id_produk = $(this).data('id'); // Ambil ID produk dari atribut data
  var row = $(this).closest('tr'); // Temukan baris yang berisi tombol hapus yang ditekan

  // Lakukan AJAX request untuk menghapus produk dari session atau database (sesuai dengan kebutuhan Anda)
  $.ajax({
      url: '<?php echo base_url()?>kasir/hapus', // Ganti URL dengan URL aksi penghapusan di Controller Anda
      type: 'POST',
      dataType: 'json',
      data: { id_produk: id_produk },
      success: function(response){
          if(response.status == 'success'){
              // Hapus baris dari tabel jika penghapusan berhasil
              row.remove();
              hitungTotalBarang();
              hitungTotalHarga();
          } else {
              alert('Gagal menghapus produk!');
          }
      }
  });
});
  function hitungTotalHarga() {
    var totalHarga = 0;
    $('tbody tr').each(function() {
        var qty = parseInt($(this).find('td:eq(2) input').val()); // Ambil nilai qty dari input dalam kolom ke-3
        var harga = parseFloat($(this).find('td:eq(3)').text().replace('Rp. ', '').replace(',', '')); // Ambil harga produk dari kolom ke-4
        totalHarga += qty * harga;
    });
    
    // Tampilkan total harga di footer tabel
    $('tfoot tr:eq(1) th:eq(1)').text('Rp. ' + rupiah(totalHarga));

    // Atur nilai total harga ke dalam input tersembunyi
    $('#total_harga_input').val(totalHarga);
}


function hitungTotalBarang() {
    var totalBarang = 0;
    $('tbody tr').each(function() {
        var qty = parseInt($(this).find('td:eq(2) input').val()); // Ambil nilai qty dari input dalam kolom ke-3
        if (!isNaN(qty)) { // Pastikan qty adalah angka
            totalBarang += qty;
        }
    });
    
    // Tampilkan total barang di footer tabel
    $('tfoot tr:eq(0) th:eq(1)').text(totalBarang);
}

    $(document).ready(function() {
    // Event listener untuk klik tombol "Update cart"
    $('#updateCartBtn').click(function() {
        // Membuat objek untuk menyimpan data yang akan dikirim
        var cartData = [];
        
        // Mengambil data yang diubah di dalam tabel
        $('input[name^="cart["][name$="][qty]"]').each(function() {
            var id = $(this).closest('tr').find('input[name$="[id]"]').val();
            var qty = $(this).val();
            cartData.push({ id: id, qty: qty });
        });

        // Mengirim data form menggunakan AJAX
        $.ajax({
            url: $('#updateCartForm').attr('action'), // URL dari form
            type: 'POST',
            dataType: 'json',
            data: { cartData: cartData }, // Mengirim data yang diubah dalam format yang diinginkan
            success: function(response) {
              // Tampilkan pesan sukses atau gagal jika diperlukan
              console.log(response); // Cetak respons ke konsol untuk pemeriksaan
              updateTotal();
                // Update tabel atau lakukan tindakan lain sesuai respons dari server
            },
            error: function(xhr, status, error) {
                // Tampilkan pesan error jika diperlukan
                console.error(error);
            }
        });
    });
});

function updateCartItem(row) {
    var qty = parseInt(row.find('input[name$="[qty]"]').val());
    var harga = parseInt(row.find('input[name$="[harga]"]').val());
    var totalHarga = qty * harga;

    // Update total harga produk untuk baris tertentu
    row.find('td:eq(3)').text('Rp. ' + totalHarga.toLocaleString());

    // Panggil fungsi untuk mengupdate total barang dan total harga setelah mengupdate qty
    updateTotal();
}
// Fungsi untuk mengupdate total barang dan total harga
function updateTotal() {
    var totalBarang = 0;
    var totalHarga = 0;

    // Iterasi setiap baris produk dalam tabel
    $('tbody tr').each(function() {
        var qty = parseInt($(this).find('input[name$="[qty]"]').val());
        var harga = parseInt($(this).find('input[name$="[harga]"]').val());

        // Jika qty atau harga tidak valid, lanjutkan ke baris berikutnya
        if(isNaN(qty) || isNaN(harga)) {
            return true; // continue
        }

        // Akumulasi total barang dan total harga
        totalBarang += qty;
        totalHarga += qty * harga;
    });

    // Update total barang dan total harga pada footer tabel
    $('tfoot tr:eq(0) th:eq(1)').text(totalBarang);
    $('tfoot tr:eq(1) th:eq(1)').text('Rp. ' + totalHarga.toLocaleString());
}

$(document).ready(function(){
        $('#search-input').on('keyup', function(){
            var searchText = $(this).val().toLowerCase();
            if(searchText.length > 0){
                $.ajax({
                    url: "<?php echo base_url()?>kasir/cari_barang",
                    method: "POST",
                    data: {searchText: searchText},
                    dataType: "json",
                    success: function(response){
                        var html = '';
                        if(response.length > 0){
                            $.each(response, function(index, value){
                                html += '<div class="col-lg-6 col-xs-6 col-md-6" style="margin-top: 20px">';
                                html += '<div class="card" style="width: 17rem;">';
                                html += '<img style="width: 17rem; height: 17rem; padding-top: 10px; background-color: white;" class="card-img-top" src="<?php echo base_url()?>images/fotoproduk/' + (value.foto_produk ? value.foto_produk : 'gambar_kosong.png') + '" alt="Foto Produk">';
                                html += '<div class="card-body form-group" style="background-color: white; border-top: 0.5px solid;">';
                                html += '<p class="card-text text-center">' + value.nama_produk + '</p>';
                                html += '<small class="card-text form-group">Harga Produk: Rp. ' + rupiah(value.harga_produk) + '</small>';
                                html += '<div class="number">';
                                html += '<span class="minus">-</span>';
                                html += '<input class="input" type="text" name="jml_produk" value="1"/>';
                                html += '<span class="plus">+</span>';
                                html += '</div>';
                                html += '<input type="hidden" id="harga_produk" name="harga_produk" value="' + value.harga_produk + '">';
                                html += '<input type="hidden" id="kd_produk" name="kd_produk" value="' + value.kd_produk + '">';
                                html += '<input type="hidden" id="nama_produk" name="nama_produk" value="' + value.nama_produk + '">';
                                html += '<input type="hidden" id="foto_produk" name="foto_produk" value="' + value.foto_produk + '">';
                                html += '<button type="button" class="btn btn-success add-produk-btn" data-kd_produk="' + value.kd_produk + '" data-nama_produk="' + value.nama_produk + '" data-harga_produk="' + value.harga_produk + '" data-foto_produk="' + value.foto_produk + '" id="btn" style="margin-top: 10px; width: 100%;">add produk</button>';
                                html += '</div></div></div>';
                            });
                        } else {
                            html = '<p>Tidak ada barang yang ditemukan.</p>';
                        }
                        $('#search-results').html(html);
                    }
                });
            } else {
                $('#search-results').html('');
            }
        });
    });

    function rupiah(angka) {
      var reverse = angka.toString().split('').reverse().join('');
      var ribuan = reverse.match(/\d{1,3}/g);
      var formatted = ribuan.join('.').split('').reverse().join('');
      return formatted;
}

function hitungTotal() {
        var jml_produk = document.getElementById('jml_produk').value;
        var harga_produk = document.getElementById('harga_produk').value;

        // Menghilangkan tanda titik atau koma jika ada
        harga_produk = harga_produk.replace(/\D/g,'');

        if (harga_produk === '') {
            document.getElementById('total_harga').value = 0; // Atur kembali nilai total_harga menjadi nol atau nilai default
            return; // Keluar dari fungsi
        }

        var total_harga = parseFloat(jml_produk) * parseFloat(harga_produk);

        // Menampilkan hasil perhitungan pada input total_harga
        document.getElementById('total_harga').value = total_harga;
    }
</script>

