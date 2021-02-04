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
    $('#tabel_supplier').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "supplier/serverside_processing",
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(0).html(index + 1);
			  },
        "columnDefs": [ {
           "targets": [2], /* column index */
           "orderable": false, /* true or false */
        }]
    });
  });
// END: Script untuk menamplikan Datatables

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Supplier
  function ambilData(id_supplier) {
    $.ajax({
      type: 'POST',
      data: 'id='+id_supplier,
      url: '<?= base_url()."supplier/ambilData" ?>',
      dataType: 'json',
      success: function (hasil) {
        $('[id="edit_id_supplier"]').val(hasil.id);
        $('[id="edit_nama"]').val(hasil.nama);
        $('[id="edit_alamat"]').val(hasil.alamat);
        $('[id="edit_telepon"]').val(hasil.telepon);
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Supplier

// Script untuk memindahkan nilai dari button delete ke Form Modal Delete Supplier
function hapusData(id_produk) {
    document.getElementById("hapus_id_supplier").value = id_produk;        
  }
// END: Script untuk memindahkan nilai dari button delete ke Form Modal Delete Supplier
</script>