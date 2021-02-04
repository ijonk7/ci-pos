<!DOCTYPE html>
<html>
<head>
<style>
#tabel_laporan, h1, h5 {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#tabel_laporan td, #tabel_laporan th {
  border: 1px solid #ddd;
  padding: 8px;
  white-space:nowrap;
}

#tabel_laporan tr:nth-child(even){background-color: #f2f2f2;}

#tabel_laporan tr:hover {background-color: #ddd;}

#tabel_laporan th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>
</head>
<body>
<h1 style="text-align: center; margin-bottom: 0px;">Laporan Pendapatan</h1>
<p style="text-align: center; margin-top: 0px;">Tanggal: <?= formatTanggalHariLengkap($tanggal_awal) ?> s/d <?= formatTanggalHariLengkap($tanggal_akhir) ?></p>
<br>
<?= $data ?>
</body>
</html>