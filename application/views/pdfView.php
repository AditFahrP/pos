<html lang="en">
<head>
  <style type="text/css">
     .table {
      width: 100%;
      border-spacing: 0;
     }

     .table tr:first-child th,
     .table tr:first-child td {
      border-top: 1px solid #000;
     }

     .table tr th:first-child,
     .table tr td:first-child {
      border-left: 1px solid #000;
     }

     .table tr th,
     .table tr td {
      border-right: 1px solid #000;
      border-bottom: 1px solid #000;
      padding: 4px;
      vertical-align: top;
     }

     .text-center {
      text-align: center;
     }
  </style>
</head>
<body>
    <h3 class="box-title">DAFTAR PRODUK</h3>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-center">No</th>
        <th>Nama Produk</th>
        <th>Kategori Produk</th>
        <th>Jumlah Produk</th>
        <th>Harga Produk</th>
      </tr>
    </thead>
    <tbody>
    <?php $kd_produk = 1; ?>
    <?php foreach ($produk as $row): ?>
      <tr>
        <td class="text-center"><?php echo $kd_produk; ?></td>
        <td><?php echo $row->nama_produk; ?></td>
        <td><?php echo $row->kategori_produk; ?></td>
        <td><?php echo $row->jml_produk; ?></td>
        <td><?php echo $row->harga_produk; ?></td>
      </tr>
      <?php $kd_produk++; ?>
      <?php endforeach; ?>
      
    </tbody>
  </table>
</body>
</html>

