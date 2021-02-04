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
<script>
// Script untuk menamplikan Datatables
  $(function () {
    $('#tabel_pengeluaran').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "pengeluaran/serverside_processing",
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(0).html(index + 1);
			  },
        "columnDefs": [ {
           "targets": [3], /* column index */
           "orderable": false, /* true or false */
        }]
    });
  });
// END: Script untuk menamplikan Datatables

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Pengeluaran
  function ambilData(id_pengeluaran) {
    $.ajax({
      type: 'POST',
      data: 'id='+id_pengeluaran,
      url: '<?= base_url()."pengeluaran/ambilData" ?>',
      dataType: 'json',
      success: function (hasil) {
        $('[id="edit_id_pengeluaran"]').val(hasil.id);
        $('[id="edit_jenis_pengeluaran"]').val(hasil.jenis_pengeluaran);
        $('[id="edit_nominal"]').val(formatRupiah(hasil.nominal));
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Pengeluaran

// Script untuk menambahkan titik saat menginput angka di Modal Form
  var tambah_nominal = document.getElementById('nominal');
	tambah_nominal.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		tambah_nominal.value = formatRupiah(this.value);
	});

  var edit_nominal = document.getElementById('edit_nominal');
	edit_nominal.addEventListener('keyup', function(e){
		// tambahkan 'Rp.' pada saat form di ketik
		// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
		edit_nominal.value = formatRupiah(this.value);
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

// Script untuk memindahkan nilai dari button delete ke Form Modal Delete Pengeluaran
function hapusData(id_produk) {
    document.getElementById("hapus_id_pengeluaran").value = id_produk;        
  }
// END: Script untuk memindahkan nilai dari button delete ke Form Modal Delete Pengeluaran
</script>