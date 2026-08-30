<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<?php
if ($model->jns_periode == "bulan") {
    $awal = $model->bln_awal;
    $akhir = $model->bln_akhir;
} elseif ($model->jns_periode == "tahun") {
    $awal = $model->thn_awal;
    $akhir = $model->thn_akhir;
} else {
    $awal = $model->tgl_awal;
    $akhir = $model->tgl_akhir;
}
?>
<script>
    //========== BAR ========
    var chart_bar;
    var chartDataBar = <?= json_encode($dataBarLineChart) ?>;
    AmCharts.ready(function() {
        // SERIAL CHART
        chart_bar = new AmCharts.AmSerialChart();
        chart_bar.dataProvider = chartDataBar;
        chart_bar.categoryField = "jenis";
        chart_bar.startDuration = 1;
        chart_bar.plotAreaBorderColor = "#DADADA";
        chart_bar.plotAreaBorderAlpha = 1;
        chart_bar.rotate = true;
        // this single line makes the chart a bar chart
        //                chart_bar.rotate = true;
        // AXES
        // Category
        var categoryAxis = chart_bar.categoryAxis;
        categoryAxis.gridPosition = "start";
        categoryAxis.gridAlpha = 0.1;
        categoryAxis.axisAlpha = 0;
        // Value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.gridAlpha = 0.1;
        valueAxis.position = "bottom";
        chart_bar.addValueAxis(valueAxis);
        // GRAPHS
        // first graph
        var graph = new AmCharts.AmGraph();
        graph.valueField = "jumlah";
        graph.type = "column";
        graph.balloonText = "[[title]]:[[value]]";
        graph.lineAlpha = 0;
        graph.fillAlphas = 1;
        chart_bar.addGraph(graph);
        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_bar.addChartCursor(chartCursor);
        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_bar.addChartScrollbar(chartScrollbar);
        chart_bar.creditsPosition = "top-right";
        // WRITE
        chart_bar.write("chartdiv");
    });
</script>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Jenis Kasus Penyakit Pasien - Periode <?php echo $awal; ?> sd <?php echo $akhir; ?>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>