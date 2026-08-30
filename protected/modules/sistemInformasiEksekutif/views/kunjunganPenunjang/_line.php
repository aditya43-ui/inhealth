<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_line;
    var chartDataLine = <?= json_encode($dataBarLineChart) ?>;
    var models = <?= json_encode($model) ?>;
    AmCharts.ready(function() {
        // generate some random data first
        // SERIAL CHART
        chart_line = new AmCharts.AmSerialChart();
        chart_line.dataProvider = chartDataLine;
        chart_line.categoryField = "periode";
        chart_line.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
        chart_line.addListener("dataUpdated", zoomChart);
        // AXES
        // category
        var categoryAxis = chart_line.categoryAxis;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        if (models.jns_periode == "hari") {
            categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "bulan") {
            categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "tahun") {
            categoryAxis.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
        }
        categoryAxis.minorGridEnabled = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.twoLineMode = true;
        categoryAxis.dateFormats = [{
            period: 'fff',
            format: 'JJ:NN:SS'
        }, {
            period: 'ss',
            format: 'JJ:NN:SS'
        }, {
            period: 'mm',
            format: 'JJ:NN'
        }, {
            period: 'hh',
            format: 'JJ:NN'
        }, {
            period: 'DD',
            format: 'DD'
        }, {
            period: 'WW',
            format: 'DD'
        }, {
            period: 'MM',
            format: 'MMM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];
        // first value axis (on the left)
        var valueAxis1 = new AmCharts.ValueAxis();
        valueAxis1.axisColor = "#FF6600";
        valueAxis1.axisThickness = 2;
        valueAxis1.gridAlpha = 0;
        chart_line.addValueAxis(valueAxis1);
        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
        graph1.title = "Laboratorium";
        graph1.valueField = "jumlah_lab";
        graph1.bullet = "round";
        graph1.hideBulletsCount = 30;
        graph1.bulletBorderThickness = 1;
        chart_line.addGraph(graph1);
        // second graph
        var graph2 = new AmCharts.AmGraph();
        graph2.valueAxis = valueAxis1; // we have to indicate which value axis should be used
        graph2.title = "Radiologi";
        graph2.valueField = "jumlah_radio";
        graph2.bullet = "square";
        graph2.hideBulletsCount = 30;
        graph2.bulletBorderThickness = 1;
        chart_line.addGraph(graph2);
        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_line.addChartCursor(chartCursor);
        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_line.addChartScrollbar(chartScrollbar);
        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend.marginLeft = 110;
        legend.useGraphSettings = true;
        chart_line.addLegend(legend);
        // WRITE
        chart_line.write("chartdiv");
    });
    // this method is called when chart is first inited as we listen for "dataUpdated" event
    function zoomChart() {
        // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
        chart_line.zoomToIndexes(0, 30);
    }
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Kunjungan ke Penunjang
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>