<!-- jQuery 3 -->
<script src="<?= base_url() ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url() ?>assets/bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>assets/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)

    var areaChartData = {
      labels  : [
        <?php
        $total_baris = count($laporan_umum);
        $idx_tgl_penjualan = 1;

        foreach ($laporan_umum as $value) 
        {
          if($idx_tgl_penjualan < $total_baris) 
          {
            echo "'".formatTanggalLengkap($value['tanggal']) . "', ";
          } else {
            echo "'".formatTanggalLengkap($value['tanggal']) . "'";
          }
          ++$idx_tgl_penjualan;
        }
        ?>
      ],
      datasets: [
        {
          label               : 'Penjualan',
          fillColor           : 'rgba(93,160,57, 1)',
          strokeColor         : 'rgba(93,160,57, 1)',
          pointColor          : 'rgba(93,160,57, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            <?php
              $idx_penjualan = 1;

              foreach ($laporan_umum as $value)
              {
                if($idx_penjualan < $total_baris) 
                {
                  echo $value['penjualan'] . ", ";
                } else {
                  echo $value['penjualan'];
                }
                ++$idx_penjualan;
              }
            ?>
          ]
        }
      ]
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)

    //-------------
    //- LINE CHART -
    //--------------
    var areaChartData2 = {
      labels  : [
        <?php
        $idx_tgl_umum = 1;

        foreach ($laporan_umum as $value) 
        {
          if($idx_tgl_umum < $total_baris) 
          {
            echo "'".formatTanggalLengkap($value['tanggal']) . "', ";
          } else {
            echo "'".formatTanggalLengkap($value['tanggal']) . "'";
          }
          ++$idx_tgl_umum;
        }
        ?>    
      ],
      datasets: [
        {
          label               : 'Penjualan Green',
          fillColor           : 'rgba(85,207,48, 1)',
          strokeColor         : 'rgba(85,207,48, 1)',
          pointColor          : 'rgba(85,207,48, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [            
            <?php
              $idx_penjualan_umum = 1;

              foreach ($laporan_umum as $value)
              {
                if($idx_penjualan_umum < $total_baris) 
                {
                  echo $value['penjualan'] . ", ";
                } else {
                  echo $value['penjualan'];
                }
                ++$idx_penjualan_umum;
              }
            ?>
          ]
        },
        {
          label               : 'Pembelian Blue',
          fillColor           : 'rgba(48,85,207,1)',
          strokeColor         : 'rgba(48,85,207,1)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(48,85,207,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(48,85,207,1)',
          data                : [
            <?php
              $idx_pembelian = 1;

              foreach ($laporan_umum as $value)
              {
                if($idx_pembelian < $total_baris) 
                {
                  echo $value['pembelian'] . ", ";
                } else {
                  echo $value['pembelian'];
                }
                ++$idx_pembelian;
              }
            ?>
          ]
        },
        {
          label               : 'Pengeluaran Red',
          fillColor           : 'rgba(207,48,84,1)',
          strokeColor         : 'rgba(207,48,84,1)',
          pointColor          : '#cf3055',
          pointStrokeColor    : 'rgba(207,48,84,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(207,48,84,1)',
          data                : [
            <?php
              $idx_pengeluaran = 1;

              foreach ($laporan_umum as $value)
              {
                if($idx_pengeluaran < $total_baris) 
                {
                  echo $value['pengeluaran'] . ", ";
                } else {
                  echo $value['pengeluaran'];
                }
                ++$idx_pengeluaran;
              }
            ?>            
          ]
        }
      ]
    }

    var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
    var lineChart                = new Chart(lineChartCanvas)
    var lineChartOptions         = areaChartOptions
    lineChartOptions.datasetFill = false
    lineChart.Line(areaChartData2, lineChartOptions)

  })
</script>
