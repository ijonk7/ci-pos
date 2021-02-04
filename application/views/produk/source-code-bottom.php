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
// Script untuk menamplikan Datatables
  $(function () {
    $('#tabel_produk').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "produk/serverside_processing",
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(1).html(index + 1);
			  },
        "columnDefs": [{
           "targets": [0,10], /* column index */
           "orderable": false, /* true or false */
        }]
    });
  });
// END: Script untuk menamplikan Datatables

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Produk
  function ambilData(id_produk) {
    $.ajax({
      type: 'POST',
      data: 'id='+id_produk,
      url: '<?= base_url()."produk/ambilData" ?>',
      dataType: 'json',
      success: function (hasil) {
        $('[id="edit_id_produk"]').val(hasil.id);
        $('[id="edit_kode_produk"]').val(hasil.kode_produk);
        $('[id="edit_nama_produk"]').val(hasil.nama_produk);
        $('[id="edit_kategori_produk"]').val(hasil.id_kategori);
        $('[id="edit_merk"]').val(hasil.merk);
        $('[id="edit_harga_beli"]').val(formatRupiah(hasil.harga_beli));
        $('[id="edit_diskon"]').val(hasil.diskon);
        $('[id="edit_harga_jual"]').val(formatRupiah(hasil.harga_jual));
        $('[id="edit_stok"]').val(hasil.stok);
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Produk

// Script untuk memindahkan nilai dari button delete ke Form Modal Delete Produk
  function hapusData(id_produk) {
    document.getElementById("hapus_id_produk").value = id_produk;        
  }
// END: Script untuk memindahkan nilai dari button delete ke Form Modal Delete Produk

// Script untuk menambahkan titik saat menginput angka di Modal Form
  var tambah_harga_beli = document.getElementById('harga_beli');
	tambah_harga_beli.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		tambah_harga_beli.value = formatRupiah(this.value);
	});

  var tambah_harga_jual = document.getElementById('harga_jual');
	tambah_harga_jual.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		tambah_harga_jual.value = formatRupiah(this.value);
	});

  var edit_harga_beli = document.getElementById('edit_harga_beli');
  edit_harga_beli.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    edit_harga_beli.value = formatRupiah(this.value);
  });

  var edit_harga_jual = document.getElementById('edit_harga_jual');
  edit_harga_jual.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    edit_harga_jual.value = formatRupiah(this.value);
  });
 
	/* Fungsi formatRupiah */
	function formatRupiah(angka){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
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
// END: Script untuk menambahkan titik saat menginput angka di Modal Form

// Script selectAll dan UnSelectAll
  $('#parent_checked_delete').click(function(event) {   
    if(this.checked) {
      // Iterate each checkbox
      $('input[name="checked_delete[]"]:checkbox').each(function() {
          this.checked = true;                        
      });
    } else {
      $('input[name="checked_delete[]"]:checkbox').each(function() {
          this.checked = false;                       
      });
    }
  });	
// END: Script selectAll dan UnSelectAll

// Script untuk memeriksa Checkbox, apakah sudah di ceklis atau belum saat ingin melakukan Multiple Delete
  function cekCheckbox() {
    var checked = 0;
 
    //Reference the Table.
    var tblFruits = document.getElementById("tabel_produk");
  
    //Reference all the CheckBoxes in Table.
    var chks = tblFruits.getElementsByTagName("INPUT");
  
    //Loop and count the number of checked CheckBoxes.
    for (var i = 0; i < chks.length; i++) {
      if (chks[i].checked) {
          checked++;
      }
    }

    if (checked > 0) {    
      var items = document.getElementsByName('checked_delete[]');
			var selectedItems="";
			for(var i=0; i<items.length; i++){
				if(items[i].type=='checkbox' && items[i].checked==true)
					selectedItems+=items[i].value+",";
			}

      document.getElementById("hapus_multiple_id_produk").value = selectedItems;        
      document.getElementById("tampil-modal-multiple-delete").setAttribute("data-toggle", "modal");
      return true;
    } else {
      document.getElementById("tampil-modal-multiple-delete").removeAttribute("data-toggle");
      alert("Pilih minimal 1 data yang ingin dihapus");
      return false;
    }
  }
// END: Script untuk memeriksa Checkbox, apakah sudah di ceklis atau belum saat ingin melakukan Multiple Delete


// Script untuk memeriksa Checkbox Barcode, apakah sudah di ceklis atau belum saat ingin melakukan Cetak Barcode
function cekCheckboxBarcode() {
    var checked = 0;
 
    //Reference the Table.
    var tblFruits = document.getElementById("tabel_produk");
  
    //Reference all the CheckBoxes in Table.
    var chks = tblFruits.getElementsByTagName("INPUT");
  
    //Loop and count the number of checked CheckBoxes.
    for (var i = 0; i < chks.length; i++) {
      if (chks[i].checked) {
          checked++;
      }
    }

    if (checked > 0) {
      var items = document.getElementsByName('checked_delete[]');
			var selectedItems="";
			for(var i=0; i<items.length; i++){
				if(items[i].type=='checkbox' && items[i].checked==true)
					selectedItems+=items[i].value+",";
			}

      document.getElementById("cetak_barcode").value = selectedItems;
      return true;
    } else {
      alert("Pilih minimal 1 data untuk cetak barcode");
      return false;
    }
  }
// END: Script untuk memeriksa Checkbox Barcode, apakah sudah di ceklis atau belum saat ingin melakukan Cetak Barcode
</script>