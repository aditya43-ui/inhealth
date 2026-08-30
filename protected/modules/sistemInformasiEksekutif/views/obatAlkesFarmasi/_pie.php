<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
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
    //========== PIE =========
    var chart_pie;
    var legend;
    var chartDataPie = <?= json_encode($dataPieChart) ?>;
    AmCharts.ready(function() {
        // PIE CHART
        chart_pie = new AmCharts.AmPieChart();
        chart_pie.dataProvider = chartDataPie;
        chart_pie.titleField = "jenis";
        chart_pie.valueField = "jumlah";
        chart_pie.labelRadius = 10;
        chart_pie.radius = 70;
        chart_pie.labelText = "[[title]]:[[value]]([[percents]]%)";
        chart_pie.colors = ["#990000", "#00ebeb", "#003beb", "#ebb000", "#00eb3b", "#eb00b0"];
        legend = new AmCharts.AmLegend();
        legend.align = "center";
        legend.markerType = "circle";
        chart_pie.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
        chart_pie.addLegend(legend);
        // WRITE
        chart_pie.write("pie");
    });
    //========== END PIE =========
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Rata-rata Penjualan 10 Obat Terbanyak - Periode <?php echo $awal; ?> s.d. <?php echo $akhir; ?>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <?php
    $h = count($dataPieChart);
    $px = 0;
    if ($h > 6) :
        $px = 400 + (25 * $h);
    else :
        $px = 400;
    endif;
    ?>
    <div class="panel-body">
        <div id="pie" style="width: 100%; height: <?php echo $px; ?>px;"></div>
    </div>
</div>