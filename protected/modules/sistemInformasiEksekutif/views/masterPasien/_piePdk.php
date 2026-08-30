<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
<script>
    //========== PIE =========
    var chart_pie_pdk;
    var pdklegend;

    var chartDataPiePdk = <?= json_encode($dataPieChartPdk) ?>;
    AmCharts.ready(function () {
        // PIE CHART
        chart_pie_pdk = new AmCharts.AmPieChart();
        chart_pie_pdk.dataProvider = chartDataPiePdk;
        chart_pie_pdk.titleField = "jenis";
        chart_pie_pdk.valueField = "jumlah";
        chart_pie_pdk.titles = [
            {
                "text": "Grafik Jumlah Pasien Berdasarkan Jenis Pendidikan",
                "size": 15
            }
        ];
        
        // LEGEND
        pdklegend = new AmCharts.AmLegend();
        pdklegend.align = "center";
        pdklegend.markerType = "circle";
        chart_pie_pdk.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie_pdk.addLegend(pdklegend);

        // WRITE
        chart_pie_pdk.write("piePdk");
    });
    //========== END PIE =========

</script>
<div class="white-container">
    <div id="piePdk" style="width: 100%; height: 400px;"></div>
</div>




