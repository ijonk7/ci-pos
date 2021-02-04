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
<!-- bootstrap datepicker -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
//Date picker
$('#datepicker').datepicker({
  autoclose: true
})

//Date picker
$('#datepicker2').datepicker({
  autoclose: true
})

// Fungsi untuk memeriksa periode tanggal yang valid
function cekPeriodeTanggal() {
  var tanggal_awal_id = document.getElementById("datepicker").value;
  var tanggal_akhir_id = document.getElementById("datepicker2").value;
  var tanggal_awal = new Date(tanggal_awal_id);
  var tanggal_akhir = new Date(tanggal_akhir_id);

  if(tanggal_awal.getTime() > tanggal_akhir.getTime()) {
    alert('Tanggal Awal lebih besar dari Tanggal Akhir');
  	return false;
  } 
  else {
  	return true;
  }
}
// END: Fungsi untuk memeriksa periode tanggal yang valid

// Fungsi untuk mengambil elemen HTML tertentu dan memasukkannya ke elemen input untuk dicetak ke pdf
function cetakPdf() {
  var target = document.getElementById('tabel_laporan');
  var wrap = document.createElement('div');
  wrap.appendChild(target.cloneNode(true));
  // location.replace("http://localhost/pos/laporan/filter2/");
  document.getElementById("pdf_hidden").value = wrap.innerHTML;
  // alert(wrap.innerHTML);                  
}
// END: Fungsi untuk mengambil elemen HTML tertentu dan memasukkannya ke elemen input untuk dicetak ke pdf
</script>