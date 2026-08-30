<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/amcharts.js', CClientScript::POS_BEGIN); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/amcharts/serial.js', CClientScript::POS_BEGIN); ?>
<script>
    var chart_stacked_jk;

    var chartDataStackedJk = <?= json_encode($dataStackChartJk) ?>;
    var models = <?= json_encode($model) ?>;

    AmCharts.ready(function () {

        // SERIAL CHART
        chart_stacked_jk = new AmCharts.AmSerialChart();

        chart_stacked_jk.dataProvider = chartDataStackedJk;
        chart_stacked_jk.categoryField = "periode";
        chart_stacked_jk.plotAreaBorderAlpha = 0;
        chart_stacked_jk.marginLeft = 0;
        chart_stacked_jk.marginBottom = 0;
        chart_stacked_jk.startDuration = 1;
        chart_stacked_jk.dataDateFormat = "YYYY-MM-DD JJ:NN:SS";
        chart_stacked_jk.titles = [
            {
                "text": "Grafik Pertumbuhan Jumlah Pasien Berdasarkan Jenis Kelamin",
                "size": 15
            }
        ];
        // AXES
        // category
        var categoryAxis = chart_stacked_jk.categoryAxis;
        categoryAxis.startOnAxis = true;
        categoryAxis.axisColor = "#DADADA";
        categoryAxis.gridAlpha = 0.07;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        if(models.jns_periode == "hari"){
                    categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        }
        if(models.jns_periode == "bulan"){
                    categoryAxis.minPeriod = "MM"; // our data is daily, so we set minPeriod to DD
        }
        if(models.jns_periode == "tahun"){
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
        valueAxis.stackType = "regular";
        valueAxis.gridAlpha = 0;
        valueAxis.position = "left";
        chart_stacked_jk.addValueAxis(valueAxis);

        // GRAPHS
        
        var graph1 = new AmCharts.AmGraph();
        graph1.title = "Laki - laki";
        graph1.valueField = "jumlah_l";
        graph1.balloonText = "[[title]]:[[value]]";
        graph1.lineAlpha = 0;
        graph1.fillAlphas = 1;
        chart_stacked_jk.addGraph(graph1);
        
        var graph2 = new AmCharts.AmGraph();
        graph2.title = "Perempuan";
        graph2.valueField = "jumlah_p";
        graph2.balloonText = "[[title]]:[[value]]";
        graph2.lineAlpha = 0;
        graph2.fillAlphas = 1;
        chart_stacked_jk.addGraph(graph2);

        // CURSOR
        var chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorAlpha = 0;
        chartCursor.zoomable = false;
        chart_stacked_jk.addChartCursor(chartCursor);

        // LEGEND
        var umurStacklegend = new AmCharts.AmLegend();
        umurStacklegend.marginLeft = 110;
//        legend.useGraphSettings = true;
        umurStacklegend.align = "center";
        umurStacklegend.equalWidths = false;
        umurStacklegend.periodValueText = "Total: [[value.sum]]";
        umurStacklegend.valueAlign = "left";
        umurStacklegend.valueText = "[[value]] ([[percents]]%)";
        umurStacklegend.valueWidth = 100;
        chart_stacked_jk.addLegend(umurStacklegend);

        // WRITE
        chart_stacked_jk.write("stackedJk");
    });

</script>
<div class="white-container">
    <div id="stackedJk" style="width: 100%; height: 400px;"></div>
</div>


