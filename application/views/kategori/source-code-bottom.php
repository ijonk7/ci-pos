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
    $('#tabel_kategori').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "kategori/serverside_processing",
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

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Kategori
  function ambilData(id_kategori) {
    $.ajax({
      type: 'POST',
      data: 'id='+id_kategori,
      url: '<?= base_url()."kategori/ambilData" ?>',
      dataType: 'json',
      success: function (hasil) {
        $('[id="edit_id_kategori"]').val(hasil.id);
        $('[id="edit_nama_kategori"]').val(hasil.nama_kategori);
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Edit Kategori

// Script untuk memindahkan nilai dari button delete ke Form Modal Delete Kategori
function hapusData(id_produk) {
    document.getElementById("hapus_id_kategori").value = id_produk;
  }
// END: Script untuk memindahkan nilai dari button delete ke Form Modal Delete Kategori
</script>