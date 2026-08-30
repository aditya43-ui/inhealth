<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== PIE =========
    var chart_pie_kerja;
    var kerjalegend;

    var chartDataPieKerja = <?= json_encode($dataPieChartKerja) ?>;
    AmCharts.ready(function () {
        // PIE CHART
        chart_pie_kerja = new AmCharts.AmPieChart();
        chart_pie_kerja.dataProvider = chartDataPieKerja;
        chart_pie_kerja.titleField = "jenis";
        chart_pie_kerja.valueField = "jumlah";
        chart_pie_kerja.titles = [
            {
                "text": "Grafik Jumlah Pasien Berdasarkan Jenis Pekerjaan",
                "size": 15
            }
        ];
        
        // LEGEND
        kerjalegend = new AmCharts.AmLegend();
        kerjalegend.align = "center";
        kerjalegend.markerType = "circle";
        chart_pie_kerja.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie_kerja.addLegend(kerjalegend);

        // WRITE
        chart_pie_kerja.write("pieKerja");
    });
    //========== END PIE =========

</script>
<div class="white-container">
    <div id="pieKerja" style="width: 100%; height: 400px;"></div>
</div>




