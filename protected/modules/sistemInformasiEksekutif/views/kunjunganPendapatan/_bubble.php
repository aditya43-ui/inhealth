<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/xy.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_bubble;
    var chartDataBubble = <?= json_encode($dataBubbleChart) ?>;
    var models = <?= json_encode($model) ?>;
    AmCharts.ready(function() {
        // generate some random data first
        // SERIAL CHART
        chart_bubble = new AmCharts.AmXYChart();
        chart_bubble.dataProvider = chartDataBubble;
        chart_bubble.dataDateFormat = "YYYY-MM-DD";
        chart_bubble.trendLines = [];
        chart_bubble.startDuration = 1.5;
        chart_bubble.numberFormatter = {
            precision: 0,
            decimalSeparator: ",",
            thousandsSeparator: "."
        };
        // first value axis (on the left)
        var valueAxis1 = new AmCharts.ValueAxis();
        valueAxis1.axisAlpha = 0;
        chart_bubble.addValueAxis(valueAxis1);
        var valueAxis2 = new AmCharts.ValueAxis();
        valueAxis2.type = "date";
        valueAxis2.axisAlpha = 0;
        valueAxis2.position = "bottom";
        valueAxis2.parseDates = true; // as our data is date-based, we set parseDates to true
        if (models.jns_periode == "hari") {
            valueAxis2.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "bulan") {
            valueAxis2.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if (models.jns_periode == "tahun") {
            valueAxis2.minPeriod = "YYYY"; // our data is daily, so we set minPeriod to DD
        }
        valueAxis2.dateFormats = [{
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
            format: 'DD MMM YYYY'
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
        chart_bubble.addValueAxis(valueAxis2);
        // GRAPHS
        // first graph
        var graph1 = new AmCharts.AmGraph();
        graph1.balloonText = "x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>";
        graph1.bullet = "bubble";
        graph1.valueField = "value";
        graph1.xField = "periode";
        graph1.yField = "y";
        graph1.fillAlphas = 0;
        graph1.lineAlpha = 0;
        graph1.maxBulletSize = 100;
        chart_bubble.addGraph(graph1);
        // second graph
        var graph2 = new AmCharts.AmGraph();
        graph2.balloonText = "x:<b>[[x]]</b> y:<b>[[y2]]</b><br>value:<b>[[value2]]</b>";
        graph2.bullet = "bubble";
        graph2.valueField = "value2";
        graph2.xField = "periode";
        graph2.yField = "y2";
        graph2.fillAlphas = 0;
        graph2.lineAlpha = 0;
        graph2.maxBulletSize = 100;
        chart_bubble.addGraph(graph2);
        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0.1;
        chartCursor.fullWidth = true;
        chart_bubble.addChartCursor(chartCursor);
        // SCROLLBAR
        var chartScrollbar = new AmCharts.ChartScrollbar();
        chart_bubble.addChartScrollbar(chartScrollbar);
        // WRITE
        chart_bubble.write("chartdiv");
    });
</script>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Pendapatan terhadap Kunjungan
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </div>
</div>