<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_cylinder;
    var chartData = <?= json_encode($dataCylChart) ?>;
    AmCharts.ready(function() {
        // SERIAL CHART
        chart_cylinder = new AmCharts.AmSerialChart();
        chart_cylinder.dataProvider = chartData;
        chart_cylinder.categoryField = "category";
        chart_cylinder.depth3D = 100;
        chart_cylinder.angle = 30;
        chart_cylinder.autoMargins = false;
        chart_cylinder.marginBottom = 100;
        chart_cylinder.marginLeft = 100;
        var categoryAxis = chart_cylinder.categoryAxis;
        categoryAxis.axisAlpha = 0;
        categoryAxis.labelOffset = 40;
        categoryAxis.gridAlpha = 0;
        // first value axis (on the left)
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.stackType = "100%";
        valueAxis.gridAlpha = 0.07;
        chart_cylinder.addValueAxis(valueAxis);
        var graph1 = new AmCharts.AmGraph();
        graph1.type = "column";
        graph1.topRadius = 1;
        graph1.columnWidth = 1;
        graph1.showOnAxis = true;
        graph1.lineThickness = 2;
        graph1.lineColor = "#8d003b";
        graph1.fillColors = "#8d003b";
        graph1.title = "Lunas";
        graph1.valueField = "jumlah_lunas";
        graph1.balloonText = "[[title]]:[[value]]";
        graph1.lineAlpha = 0.5;
        graph1.fillAlphas = 0.8;
        chart_cylinder.addGraph(graph1);
        // second graph
        var graph2 = new AmCharts.AmGraph();
        graph2.type = "column";
        graph2.topRadius = 1;
        graph2.columnWidth = 1;
        graph2.showOnAxis = true;
        graph2.lineThickness = 2;
        graph2.lineColor = "#cdcdcd";
        graph2.fillColors = "#cdcdcd";
        graph2.title = "Belum Lunas"
        graph2.valueField = "jumlah_belumlunas";
        graph2.balloonText = "[[title]]:[[value]]";
        graph2.lineAlpha = 0.5;
        graph2.fillAlphas = 0.5;
        chart_cylinder.addGraph(graph2);
        var legend = new AmCharts.AmLegend();
        chart_cylinder.addLegend(legend);
        chart_cylinder.write("cylinder");
    });
</script>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Total Pembayaran Pelayanan Pasien
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="cylinder" style="width: 100%; height: 400px;"></div>
    </div>
</div>