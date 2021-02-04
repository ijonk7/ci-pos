<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode Produk</title>
    <style>
        * {
          box-sizing: border-box;
        }

        /* Create three equal columns that floats next to each other */
        .column {
          float: left;
          width: 29.33%;
          padding: 10px;
          height: 80px; /* Should be removed. Only for demonstration */
          border-style: solid;
          border-width: 1px;
          border-color: gray;
          margin-left: 2px;
          margin-right: 2px;
          margin-bottom: 10px;
        }

        /* Clear floats after the columns */
        .row:after {
          content: "";
          display: table;
          clear: both;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Barcode Produk</h2>

<?php 
  foreach ($array_list_barcode as $index_array) {
    $x = 4;
    switch ($x % 3) {
        case 0:
            echo '<div class="row"><div class="column" style="text-align: center; font-size: 10px;">'.$index_array['nama_produk'].' - Rp. '.number_format($index_array['harga_jual'],0,",",".").'<img src="'.base_url('assets/dist/img/barcode/'.$index_array['nama_gambar']).'" style="margin-top: 5px;"></div>';
            break;
        case 1:
            echo '<div class="column" style="text-align: center; font-size: 10px;">'.$index_array['nama_produk'].' - Rp. '.number_format($index_array['harga_jual'],0,",",".").'<img src="'.base_url('assets/dist/img/barcode/'.$index_array['nama_gambar']).'" style="margin-top: 5px;"></div>';
            break;
        case 2:
            echo '<div class="column" style="text-align: center; font-size: 10px;">'.$index_array['nama_produk'].' - Rp. '.number_format($index_array['harga_jual'],0,",",".").'<img src="'.base_url('assets/dist/img/barcode/'.$index_array['nama_gambar']).'" style="margin-top: 5px;"></div></div><br>';
            break;
        default:
            echo "<br>";
    }
    $x += 1;
  } 
?>
</body>
</html>
