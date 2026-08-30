<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/pie.js', CClientScript::POS_BEGIN); ?>
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
        chart_pie.labelRadius = 30;
        chart_pie.labelText = "[[title]]:[[value]]([[percents]]%)";
        chart_pie.numberFormatter = {
            precision: 0,
            decimalSeparator: ",",
            thousandsSeparator: "."
        };
        // WRITE
        chart_pie.write("pie");
    });
    //========== END PIE =========
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Pendapatan Instalasi
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="pie" style="width: 100%; height: 400px;"></div>
    </div>
</div>