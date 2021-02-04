<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?= base_url() ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url() ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
// Script untuk menamplikan daftar Supplier
$(document).ready(function() {
    $('#daftar_produk').DataTable({
        "searching": false,
        "paging":   false,
        "order": [ 1, 'asc' ],
        "columnDefs": [
          { "orderable": false, "targets": 3 }
        ]
    });
} );
// END: Script untuk menamplikan daftar Supplier

// Script untuk menampilkan data dari database dan ditampilkan ke daftar Pembelian Produk
var total_harga_beli = 0;
var total_setelah_diskon = 0;
var no_urut_produk = 0;

var input_kode_produk = document.getElementById("kode");
var array_inputan_kode_produk = [];

function ambilDataProduk(id_produk) {
    $.ajax({
      type: 'POST',
      data: 'id='+id_produk,
      url: '<?= base_url()."pembelian/ambilDataProduk/" ?>'+id_produk,
      dataType: 'json',
      success: function (hasil) {
        array_inputan_kode_produk.push(hasil.kode_produk);
        no_urut_produk++;
        $('#daftar-produk-terpilih').append('<tr role="row" class="odd" id="baris'+hasil.id+'"><td class="no_urut_produk">'+no_urut_produk+'</td><td>'+hasil.kode_produk+'</td><td>'+hasil.nama_produk+'</td><td>Rp '+formatRupiah(hasil.harga_beli)+'</td><td><input type="number" min="1" id="kuantiti'+hasil.id+'" name="quantity[]" value="1" onchange="ubahKuantiti(this.value,'+hasil.harga_beli+','+hasil.id+')"></td><td id="sub_total_harga_beli'+hasil.id+'">Rp '+formatRupiah(hasil.harga_beli)+'</td><td><button type="button" id="input_hapus_produk" style="float: none; display: inline-block;" onclick="pindahIdProduk('+hasil.id+',\''+hasil.kode_produk+'\')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pembelian"><i class="fa fa-trash"></i></button></td><input type="hidden" name="value_input_kode_produk[]" value="'+hasil.kode_produk+'"><input type="hidden" name="value_input_harga_beli[]" value="'+hasil.harga_beli+'"><input type="hidden" id="id_input_sub_total_'+hasil.id+'" name="value_input_sub_total[]" value="'+hasil.harga_beli+'"></tr>');
        total_harga_beli += parseInt(hasil.harga_beli);

        var kuantiti_diskon = document.getElementById("diskon").value;
        if (kuantiti_diskon > 0) {
          nilai_diskon = total_harga_beli * kuantiti_diskon / 100;
          total_setelah_diskon = total_harga_beli - nilai_diskon;
          total_setelah_diskon_format = formatRupiah(total_setelah_diskon);
          total_setelah_diskon_terbilang = formatTerbilang(total_setelah_diskon);
          total_harga_beli_format = formatRupiah(total_harga_beli);
          $(".tampil-total-bayar").text(total_setelah_diskon_format).val('Rp. '+total_setelah_diskon_format);
          $("#totalrp").val('Rp. '+total_harga_beli_format);
          $("#tampil-terbilang").text(total_setelah_diskon_terbilang);
          document.getElementById('disable_tombol_'+hasil.id).disabled = true;
        } else {
          total_harga_beli_format = formatRupiah(total_harga_beli);
          total_harga_beli_terbilang = formatTerbilang(total_harga_beli);
          $(".tampil-total-bayar").text(total_harga_beli_format).val('Rp. '+total_harga_beli_format);
          $("#totalrp").val('Rp. '+total_harga_beli_format);
          $("#tampil-terbilang").text(total_harga_beli_terbilang);
          document.getElementById('disable_tombol_'+hasil.id).disabled = true;
        }
      }
    });
}
// END: Script untuk menampilkan data dari database dan ditampilkan ke daftar Pembelian Produk

// Script untuk input produk berdasarkan kode produk
input_kode_produk.addEventListener("keyup", function(event) {

  if (event.keyCode === 13) {
    var inputan_kode_produk = document.getElementById("kode").value;
    var cek_eksis_array = array_inputan_kode_produk.includes(inputan_kode_produk);
      if (cek_eksis_array == true) {
        $.ajax({
          type: 'POST',
          data: 'id='+inputan_kode_produk,
          url: '<?= base_url()."pembelian/ambilDataProduk2/" ?>'+inputan_kode_produk,
          dataType: 'json',
          success: function (hasil) {
            var kuantiti_sebelum = document.getElementById("kuantiti"+hasil.id).value;
            kuantiti_produk = parseInt(kuantiti_sebelum) + 1;
            document.getElementById("kuantiti"+hasil.id).value = kuantiti_produk;
            var_harga_beli = parseInt(hasil.harga_beli);

            ubahKuantiti(kuantiti_produk, var_harga_beli, hasil.id);
          }
        });

      } else {      
        $.ajax({
          type: 'POST',
          data: 'id='+inputan_kode_produk,
          url: '<?= base_url()."pembelian/ambilDataProduk2/" ?>'+inputan_kode_produk,
          dataType: 'json',
          success: function (hasil) {
            array_inputan_kode_produk.push(inputan_kode_produk);
            no_urut_produk++;
            $('#daftar-produk-terpilih').append('<tr role="row" class="odd" id="baris'+hasil.id+'"><td class="no_urut_produk">'+no_urut_produk+'</td><td>'+hasil.kode_produk+'</td><td>'+hasil.nama_produk+'</td><td>Rp '+formatRupiah(hasil.harga_beli)+'</td><td><input type="number" min="1" id="kuantiti'+hasil.id+'" name="quantity[]" value="1" onchange="ubahKuantiti(this.value,'+hasil.harga_beli+','+hasil.id+')"></td><td id="sub_total_harga_beli'+hasil.id+'">Rp '+formatRupiah(hasil.harga_beli)+'</td><td><button type="button" style="float: none; display: inline-block;" onclick="pindahIdProduk('+hasil.id+',\''+hasil.kode_produk+'\')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-pembelian"><i class="fa fa-trash"></i></button></td><input type="hidden" name="value_input_kode_produk[]" value="'+hasil.kode_produk+'"><input type="hidden" name="value_input_harga_beli[]" value="'+hasil.harga_beli+'"><input type="hidden" id="id_input_sub_total_'+hasil.id+'" name="value_input_sub_total[]" value="'+hasil.harga_beli+'"></tr>');        
            total_harga_beli += parseInt(hasil.harga_beli);

            var kuantiti_diskon = document.getElementById("diskon").value;
            if (kuantiti_diskon > 0) {
              nilai_diskon = total_harga_beli * kuantiti_diskon / 100;
              total_setelah_diskon = total_harga_beli - nilai_diskon;
              total_setelah_diskon_format = formatRupiah(total_setelah_diskon);
              total_setelah_diskon_terbilang = formatTerbilang(total_setelah_diskon);
              total_harga_beli_format = formatRupiah(total_harga_beli);
              $(".tampil-total-bayar").text(total_setelah_diskon_format).val('Rp. '+total_setelah_diskon_format);
              $("#totalrp").val('Rp. '+total_harga_beli_format);
              $("#tampil-terbilang").text(total_setelah_diskon_terbilang);
              document.getElementById('disable_tombol_'+hasil.id).disabled = true;
            } else {
              total_harga_beli_format = formatRupiah(total_harga_beli);
              total_harga_beli_terbilang = formatTerbilang(total_harga_beli);
              $(".tampil-total-bayar").text(total_harga_beli_format).val('Rp. '+total_harga_beli_format);
              $("#totalrp").val('Rp. '+total_harga_beli_format);
              $("#tampil-terbilang").text(total_harga_beli_terbilang);
              document.getElementById('disable_tombol_'+hasil.id).disabled = true;
            }
          }
        });
      }

  }
});
// END: Script untuk input produk berdasarkan kode produk

// Script untuk memindah id produk ke tombol button
function ubahKuantiti(kuantiti_produk, harga_beli, id_produk) {
    var sub_total_harga_beli = document.getElementById("sub_total_harga_beli"+id_produk).textContent;

		var string_sub_total_harga_beli = sub_total_harga_beli.replace(/[^,\d]/g, '');
    total_harga_beli -= string_sub_total_harga_beli;
    var sub_total_produk = kuantiti_produk * harga_beli;
    total_harga_beli += sub_total_produk;

    var kuantiti_diskon = document.getElementById("diskon").value;

    if (kuantiti_diskon > 0) {
      nilai_diskon = total_harga_beli * kuantiti_diskon / 100;
      total_setelah_diskon = total_harga_beli - nilai_diskon;

      sub_total_produk_format = formatRupiah(sub_total_produk);
      total_setelah_diskon_format = formatRupiah(total_setelah_diskon);
      total_setelah_diskon_terbilang = formatTerbilang(total_setelah_diskon);
      total_harga_beli_format = formatRupiah(total_harga_beli);
      $(".tampil-total-bayar").text(total_setelah_diskon_format).val('Rp. '+total_setelah_diskon_format);
      $("#totalrp").val('Rp. '+total_harga_beli_format);
      $("#sub_total_harga_beli"+id_produk).text('Rp. '+sub_total_produk_format);
      $("#id_input_sub_total_"+id_produk).val(sub_total_produk);      
      $("#tampil-terbilang").text(total_setelah_diskon_terbilang);
    } else {
      sub_total_produk_format = formatRupiah(sub_total_produk);
      total_harga_beli_format = formatRupiah(total_harga_beli);
      total_harga_beli_terbilang = formatTerbilang(total_harga_beli);
      $(".tampil-total-bayar").text(total_harga_beli_format).val('Rp. '+total_harga_beli_format);
      $("#totalrp").val('Rp. '+total_harga_beli_format);
      $("#sub_total_harga_beli"+id_produk).text('Rp. '+sub_total_produk_format);
      $("#id_input_sub_total_"+id_produk).val(sub_total_produk);
      $("#tampil-terbilang").text(total_harga_beli_terbilang);
    }
  }
// END: Script untuk memindah id produk ke tombol button

// Script untuk memindah id produk ke tombol button
function dapatDiskon(nilai_diskon) {
    var nilai_diskon = total_harga_beli * nilai_diskon / 100;
    total_setelah_diskon = total_harga_beli - nilai_diskon;
    total_harga_beli_format = formatRupiah(total_setelah_diskon);
    total_harga_beli_terbilang = formatTerbilang(total_setelah_diskon);
    $(".tampil-total-bayar").text(total_harga_beli_format).val('Rp. '+total_harga_beli_format);
    $("#tampil-terbilang").text(total_harga_beli_terbilang);    
  }
// END: Script untuk memindah id produk ke tombol button

// Script untuk memindah id produk ke tombol button
function pindahIdProduk(id_produk, kode_produk) {
    document.getElementById("tombol-hapus-produk").setAttribute("onclick", "hapusProduk("+id_produk+",'"+kode_produk+"')");
    console.log(kode_produk);
  }
// END: Script untuk memindah id produk ke tombol button

// Script untuk menghapus produk yang telah dipilih
function hapusProduk(id_produk, kode_produk) {
    
    var sub_total_harga_beli = document.getElementById("sub_total_harga_beli"+id_produk).textContent;

    var string_sub_total_harga_beli = sub_total_harga_beli.replace(/[^,\d]/g, '');

    total_harga_beli -= parseInt(string_sub_total_harga_beli);

    var kuantiti_diskon = document.getElementById("diskon").value;
    if (kuantiti_diskon > 0) {
      nilai_diskon = total_harga_beli * kuantiti_diskon / 100;
      total_setelah_diskon = total_harga_beli - nilai_diskon;
      total_setelah_diskon_format = formatRupiah(total_setelah_diskon);
      total_harga_beli_format = formatRupiah(total_harga_beli);
      total_setelah_diskon_terbilang = formatTerbilang(total_setelah_diskon);
      $('#baris'+id_produk).remove();

      document.getElementById('disable_tombol_'+id_produk).removeAttribute("disabled");

      var index_array_id_produk = array_inputan_kode_produk.indexOf(kode_produk);
 
      if (index_array_id_produk > -1) {
        array_inputan_kode_produk.splice(index_array_id_produk, 1);
      }

      no_urut_produk--;
      for (i = 0; i < no_urut_produk; i++) {
        $('td.no_urut_produk:eq('+i+')').text(i+1);
      }

      $(".tampil-total-bayar").text(total_setelah_diskon_format).val('Rp. '+total_setelah_diskon_format);
      $("#totalrp").val('Rp. '+total_harga_beli_format);
      $("#tampil-terbilang").text(total_setelah_diskon_terbilang);
    } else {
      total_harga_beli_format = formatRupiah(total_harga_beli);
      total_harga_beli_terbilang = formatTerbilang(total_harga_beli);
      $('#baris'+id_produk).remove();

      document.getElementById('disable_tombol_'+id_produk).removeAttribute("disabled");

      var index_array_id_produk = array_inputan_kode_produk.indexOf(kode_produk);
 
      if (index_array_id_produk > -1) {
        array_inputan_kode_produk.splice(index_array_id_produk, 1);
      }
      
      no_urut_produk--;
      for (i = 0; i < no_urut_produk; i++) {
        $('td.no_urut_produk:eq('+i+')').text(i+1);
      }

      $(".tampil-total-bayar").text(total_harga_beli_format).val('Rp. '+total_harga_beli_format);
      $("#totalrp").val('Rp. '+total_harga_beli_format);
      $("#tampil-terbilang").text(total_harga_beli_terbilang);
    }   
  }
// END: Script untuk menghapus produk yang telah dipilih

// Script untuk format Rupiah
	function formatRupiah(angka){
    var angka_string = angka.toString()
		var number_string = angka_string.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
 
		return rupiah;
	}
// END: Script untuk format Rupiah

// Script untuk membuat angka terbilang
function formatTerbilang(total_harga_beli){
    var bilangan = total_harga_beli.toString()
    var kalimat="";
    var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
    var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
    var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
    var panjang_bilangan = bilangan.length;
     
    /* pengujian panjang bilangan */
    if(panjang_bilangan > 15){
        kalimat = "Diluar Batas";
    }else{
        /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
        for(i = 1; i <= panjang_bilangan; i++) {
            angka[i] = bilangan.substr(-(i),1);
        }
         
        var i = 1;
        var j = 0;
         
        /* mulai proses iterasi terhadap array angka */
        while(i <= panjang_bilangan){
            subkalimat = "";
            kata1 = "";
            kata2 = "";
            kata3 = "";
             
            /* untuk Ratusan */
            if(angka[i+2] != "0"){
                if(angka[i+2] == "1"){
                    kata1 = "Seratus";
                }else{
                    kata1 = kata[angka[i+2]] + " Ratus";
                }
            }
             
            /* untuk Puluhan atau Belasan */
            if(angka[i+1] != "0"){
                if(angka[i+1] == "1"){
                    if(angka[i] == "0"){
                        kata2 = "Sepuluh";
                    }else if(angka[i] == "1"){
                        kata2 = "Sebelas";
                    }else{
                        kata2 = kata[angka[i]] + " Belas";
                    }
                }else{
                    kata2 = kata[angka[i+1]] + " Puluh";
                }
            }
             
            /* untuk Satuan */
            if (angka[i] != "0"){
                if (angka[i+1] != "1"){
                    kata3 = kata[angka[i]];
                }
            }
             
            /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
            if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")){
                subkalimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
            }
             
            /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
            kalimat = subkalimat + kalimat;
            i = i + 3;
            j = j + 1;
        }
         
        /* mengganti Satu Ribu jadi Seribu jika diperlukan */
        if ((angka[5] == "0") && (angka[6] == "0")){
            kalimat = kalimat.replace("Satu Ribu","Seribu");
        }
    }

    return kalimat + 'Rupiah';
}
// END: Script untuk membuat angka terbilang
</script>