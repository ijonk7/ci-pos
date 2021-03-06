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
    $('#tabel_pembelian').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "pembelian/serverside_processing",
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(0).html(index + 1);
			  },
        "order": [ 1, 'desc' ],
        "columnDefs": [ {
           "targets": [3], /* column index */
           "orderable": false, /* true or false */
        }]
    });
  });
// END: Script untuk menamplikan Datatables

// Script untuk menamplikan daftar Supplier
$(document).ready(function() {
    $('#daftar_supplier').DataTable();
} );
// END: Script untuk menamplikan daftar Supplier

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Pembelian
  function ambilData(id_pembeliannya) {
    $('#tabel_detail_pembelian').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "pembelian/dtl_pembelian_serverside/"+id_pembeliannya,
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(0).html(index + 1);
			  },
        paging: false,
        searching: false,
        destroy: true
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Pembelian

// Script untuk memindahkan nilai dari button delete ke Form Modal Delete Pembelian
function hapusData(id_produk) {
    document.getElementById("hapus_id_pembelian").value = id_produk;        
  }
// END: Script untuk memindahkan nilai dari button delete ke Form Modal Delete Pembelian
</script>