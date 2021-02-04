<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url() ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
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
    $('#tabel_pesan').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "pesan/serverside_processing",
			  "fnCreatedRow": function (row, data, index) {
			    $('td', row).eq(0).html(index + 1);
			  },
        "order": [ 4, 'asc' ],
        "columnDefs": [ {
           "targets": [0,5], /* column index */
           "orderable": false, /* true or false */
        }]
    });
  });
// END: Script untuk menamplikan Datatables

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Lihat Pesan
  function lihatPesan(no_pesan) {
    $.ajax({
      type: 'POST',
      data: 'no_pesannya='+no_pesan,
      url: '<?= base_url()."pesan/lihatPesan" ?>',
      dataType: 'json',
      success: function (hasil) {
        var x;
        var d = '';
        for (x in hasil) {
          d += "<p>Dari: "+hasil[x].user_pengirim+"<span style=\"float: right;\"><small>"+formatTanggal(hasil[x].created_at)+"</small></span></p><p>Judul Pesan: "+hasil[x].judul_pesan+"</p><p>Isi Pesan: "+hasil[x].isi_pesan+"</p><hr>";
        }
        $("#lihat-pesan").html(d);
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Lihat Pesan

// Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Reply Pesan
  function balasPesan(no_pesan) {
    $.ajax({
      type: 'POST',
      data: 'no_pesannya='+no_pesan,
      url: '<?= base_url()."pesan/lihatPesan" ?>',
      dataType: 'json',
      success: function (hasil) {
        var x;
        var d = '';
        for (x in hasil) {
          d += "<p>Dari: "+hasil[x].user_pengirim+"<span style=\"float: right;\"><small>"+formatTanggal(hasil[x].created_at)+"</small></span></p><p>Judul Pesan: "+hasil[x].judul_pesan+"</p><p>Isi Pesan: "+hasil[x].isi_pesan+"</p><hr>";
        }
          $("#reply-pesan").html(d);
          $('[id="judul-no-pesan"]').text(hasil[0].no_pesan);
          $('[id="id_reply_no_pesan"]').val(hasil[0].no_pesan);
          $('[id="reply_user_penerima"]').val(hasil[0].user_pengirim);
          $('[id="reply_judul_pesan"]').val(hasil[0].judul_pesan);
      }
    });
  }
// END: Script untuk menampilkan data dari database dan ditampilkan ke Form Modal Reply Pesan

// Script untuk format tanggal dan waktu
function formatTanggal(waktu) {
  var d = new Date(waktu);  

  var bulan_array = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];
  
  var tanggal = addZero(d.getDate());
  var bulan = bulan_array[d.getMonth()];
  var tahun = d.getFullYear();

  var jam = addZero(d.getHours());
  var menit = addZero(d.getMinutes());
  var detik = addZero(d.getSeconds());
  var tanggal_waktu = tanggal + " " + bulan +  " " + tahun + " " + jam + ":" + menit + ":" + detik;
  return tanggal_waktu;
}

function addZero(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
// END: Script untuk format tanggal dan waktu

$(function () {
  //Initialize Select2 Elements
  $('.select2').select2()
})
</script>