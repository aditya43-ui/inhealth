<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_stacked;
    var chartDataStacked = <?= json_encode($dataStackChart) ?>;
    var models = <?= json_encode($model) ?>;
    AmCharts.ready(function() {
        // SERIAL CHART
        chart_stacked = new AmCharts.AmSerialChart();
        chart_stacked.dataProvider = chartDataStacked;
        chart_stacked.categoryField = "periode";
        chart_stacked.plotAreaBorderAlpha = 0;
        chart_stacked.marginLeft = 0;
        chart_stacked.marginBottom = 0;
        chart_stacked.startDuration = 1;
        chart_stacked.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        chart_stacked.numberFormatter = {
            precision: 0,
            decimalSeparator: ",",
            thousandsSeparator: "."
        };
        // AXES
        // category
        var categoryAxis = chart_stacked.categoryAxis;
        categoryAxis.startOnAxis = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.gridAlpha = 0.07;
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
            format: 'MM'
        }, {
            period: 'YYYY',
            format: 'YYYY'
        }];
        // first value axis (on the left)
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.stackType = "100%";
        valueAxis.gridAlpha = 0.07;
        valueAxis.position = "left";
        valueAxis.title = "Percent";
        chart_stacked.addValueAxis(valueAxis);
        // GRAPHS
        chart_stacked.graphs = <?= json_encode($graphsStack) ?>;
        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chart_stacked.addChartCursor(chartCursor);
        // LEGEND
        var legend = new AmCharts.AmLegend();
        legend.marginLeft = 110;
        //        legend.useGraphSettings = true;
        legend.align = "center";
        legend.equalWidths = false;
        legend.periodValueText = "Total: [[value.sum]]";
        legend.valueAlign = "left";
        legend.valueText = "[[value]] ([[percents]]%)";
        legend.valueWidth = 100;
        chart_stacked.addLegend(legend);
        // WRITE
        chart_stacked.write("stacked");
    });
</script>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Pendapatan Penunjang
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="stacked" style="width: 100%; height: 400px;"></div>
    </div>
</div>